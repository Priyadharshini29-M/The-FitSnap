'use strict';
/**
 * Brix-Tryon demo server
 *  - serves the static website (the folder above /server)
 *  - POST /api/tryon   : one free virtual try-on per visitor (IP + signed cookie)
 *  - GET  /api/tryon/status
 *
 * Providers (TRYON_PROVIDER): huggingface | runpod | mock
 * Secrets live only in server/.env, never in the browser.
 */
const fs = require('fs');
const path = require('path');
const crypto = require('crypto');
const express = require('express');

// ---------- tiny .env loader (no extra dependency) ----------
(function loadEnv() {
    const file = path.join(__dirname, '.env');
    if (!fs.existsSync(file)) return;
    fs.readFileSync(file, 'utf8').split(/\r?\n/).forEach((line) => {
        const m = line.match(/^\s*([A-Z0-9_]+)\s*=\s*(.*)\s*$/);
        if (!m || line.trim().startsWith('#')) return;
        let v = m[2];
        if ((v.startsWith('"') && v.endsWith('"')) || (v.startsWith("'") && v.endsWith("'"))) v = v.slice(1, -1);
        if (process.env[m[1]] === undefined) process.env[m[1]] = v;
    });
})();

const PORT = Number(process.env.PORT || 3000);
const PROVIDER = (process.env.TRYON_PROVIDER || 'mock').toLowerCase();
const SECRET = process.env.SESSION_SECRET || crypto.randomBytes(32).toString('hex');
const TRUST_PROXY = process.env.TRUST_PROXY || ''; // e.g. "1" behind nginx / a load balancer
const TRUST_CF = String(process.env.TRUST_CLOUDFLARE || '').toLowerCase() === 'true';
const MAX_IMAGE_BYTES = 6 * 1024 * 1024;
const TIMEOUT_MS = Number(process.env.TRYON_TIMEOUT_MS || 150000);
const WEB_ROOT = path.join(__dirname, '..');
const ASSETS = path.join(WEB_ROOT, 'assets');

if (!process.env.SESSION_SECRET) {
    console.warn('[warn] SESSION_SECRET is not set. Using a random one, so cookies and stored hashes reset on restart.');
}

// ---------- garments the demo is allowed to use (whitelist) ----------
const GARMENTS = {
    dress: { file: 'look-w2-garment.jpg', desc: 'sage green floral wrap midi dress', name: 'Sage Floral Wrap Dress' },
    denim: { file: 'look-w3-garment.jpg', desc: 'light wash denim jacket', name: 'Classic Denim Jacket' },
    suit: { file: 'look-m1-garment.jpg', desc: 'navy blue two piece suit with shirt and tie', name: 'Navy Three-Piece Suit' },
    hoodie: { file: 'look-m2-garment.jpg', desc: 'oversized charcoal grey hoodie with joggers', name: 'Oversized Hoodie Set' },
    kurta: { file: 'look-m3-garment.jpg', desc: 'cream kurta with dark teal nehru jacket', name: 'Kurta & Nehru Jacket Set' },
    shirt: { file: 'studio-flat.jpg', desc: 'olive green linen button-up shirt', name: 'Linen Shirt' },
};

// ---------- one-credit store (IP + cookie), persisted to disk ----------
const DATA_DIR = path.join(__dirname, 'data');
const USAGE_FILE = path.join(DATA_DIR, 'usage.json');
fs.mkdirSync(DATA_DIR, { recursive: true });
let usage = {};
try { usage = JSON.parse(fs.readFileSync(USAGE_FILE, 'utf8')); } catch (e) { usage = {}; }
let saveTimer = null;
function persist() {
    clearTimeout(saveTimer);
    saveTimer = setTimeout(() => {
        const tmp = USAGE_FILE + '.tmp';
        fs.writeFileSync(tmp, JSON.stringify(usage));
        fs.renameSync(tmp, USAGE_FILE);
    }, 100);
}
const hmac = (s) => crypto.createHmac('sha256', SECRET).update(String(s)).digest('hex');
const inflight = new Set(); // reservations: check-and-set is synchronous, so two requests can never both pass

function normalizeIp(raw) {
    let ip = String(raw || '').trim();
    if (ip.startsWith('::ffff:')) ip = ip.slice(7);
    if (ip.includes(':')) { // IPv6: a user controls a whole /64, so key on the /64
        const parts = ip.split(':');
        return parts.slice(0, 4).join(':');
    }
    return ip;
}
function clientIp(req) {
    if (TRUST_CF && req.headers['cf-connecting-ip']) return normalizeIp(req.headers['cf-connecting-ip']);
    return normalizeIp(req.ip || req.socket.remoteAddress);
}
function readCookieId(req) {
    const raw = (req.headers.cookie || '').split(';').map((c) => c.trim()).find((c) => c.startsWith('bt_id='));
    if (!raw) return null;
    const [id, sig] = decodeURIComponent(raw.slice(6)).split('.');
    if (!id || !sig) return null;
    try {
        const a = Buffer.from(hmac('c:' + id).slice(0, 24));
        const b = Buffer.from(String(sig).padEnd(24).slice(0, 24));
        return a.length === b.length && crypto.timingSafeEqual(a, b) ? id : null;
    } catch (e) { return null; }
}
function ensureCookie(req, res) {
    let id = readCookieId(req);
    if (!id) {
        id = crypto.randomBytes(12).toString('hex');
        const val = encodeURIComponent(id + '.' + hmac('c:' + id).slice(0, 24));
        res.setHeader('Set-Cookie', `bt_id=${val}; Path=/; Max-Age=${60 * 60 * 24 * 365}; HttpOnly; SameSite=Lax`);
    }
    return id;
}
function keysFor(req, res) {
    return [hmac('ip:' + clientIp(req)), hmac('ck:' + ensureCookie(req, res))];
}
const isUsed = (keys) => keys.some((k) => usage[k]);
const isBusy = (keys) => keys.some((k) => inflight.has(k));

// ---------- tiny in-memory request throttle (before any work) ----------
const hits = new Map();
function throttle(limit, windowMs) {
    return (req, res, next) => {
        const k = clientIp(req) + req.path;
        const now = Date.now();
        const arr = (hits.get(k) || []).filter((t) => now - t < windowMs);
        if (arr.length >= limit) return res.status(429).json({ error: 'too_many_requests' });
        arr.push(now); hits.set(k, arr);
        next();
    };
}
setInterval(() => { const now = Date.now(); hits.forEach((v, k) => { if (!v.some((t) => now - t < 120000)) hits.delete(k); }); }, 60000).unref();

// ---------- image helpers ----------
function parseDataUrl(str) {
    const m = /^data:(image\/(?:jpeg|png|webp));base64,([A-Za-z0-9+/=]+)$/.exec(String(str || ''));
    if (!m) return null;
    const buf = Buffer.from(m[2], 'base64');
    if (!buf.length || buf.length > MAX_IMAGE_BYTES) return null;
    const jpg = buf[0] === 0xff && buf[1] === 0xd8;
    const png = buf[0] === 0x89 && buf[1] === 0x50;
    const webp = buf.slice(0, 4).toString() === 'RIFF' && buf.slice(8, 12).toString() === 'WEBP';
    if (!(jpg || png || webp)) return null;
    return { buf, mime: m[1] };
}
const toDataUrl = (buf, mime) => `data:${mime || 'image/jpeg'};base64,${buf.toString('base64')}`;
const withTimeout = (p, ms) => Promise.race([p, new Promise((_, rej) => setTimeout(() => rej(new Error('timeout')), ms))]);

// ---------- providers ----------
async function runHuggingFace(person, garment, desc) {
    const { Client } = await import('@gradio/client');
    const space = process.env.HF_SPACE || 'yisol/IDM-VTON';
    const client = await Client.connect(space, process.env.HF_TOKEN ? { hf_token: process.env.HF_TOKEN } : {});
    const result = await client.predict('/tryon', {
        dict: { background: new Blob([person.buf], { type: person.mime }), layers: [], composite: null },
        garm_img: new Blob([garment.buf], { type: garment.mime }),
        garment_des: desc,
        is_checked: true,
        is_checked_crop: false,
        denoise_steps: Number(process.env.HF_STEPS || 30),
        seed: 42,
    });
    const out = result && result.data && result.data[0];
    const url = out && (out.url || out.path);
    if (!url) throw new Error('no_output');
    const r = await fetch(url);
    if (!r.ok) throw new Error('download_failed');
    return { buf: Buffer.from(await r.arrayBuffer()), mime: r.headers.get('content-type') || 'image/png' };
}

async function runRunpod(person, garment) {
    const id = process.env.RUNPOD_ENDPOINT_ID, key = process.env.RUNPOD_API_KEY;
    if (!id || !key) throw new Error('runpod_not_configured');
    const base = `https://api.runpod.ai/v2/${id}`;
    const headers = { Authorization: `Bearer ${key}`, 'Content-Type': 'application/json' };
    const input = {};
    input[process.env.RUNPOD_PERSON_FIELD || 'person_image'] = person.buf.toString('base64');
    input[process.env.RUNPOD_GARMENT_FIELD || 'garment_image'] = garment.buf.toString('base64');
    let extra = {};
    try { extra = JSON.parse(process.env.RUNPOD_EXTRA_INPUT || '{}'); } catch (e) { /* ignore */ }
    let job = await (await fetch(`${base}/run`, { method: 'POST', headers, body: JSON.stringify({ input: Object.assign(input, extra) }) })).json();
    if (!job.id) throw new Error('runpod_submit_failed');
    const t0 = Date.now();
    while (job.status !== 'COMPLETED') {
        if (['FAILED', 'CANCELLED', 'TIMED_OUT'].includes(job.status)) throw new Error('runpod_' + job.status);
        if (Date.now() - t0 > TIMEOUT_MS) throw new Error('timeout');
        await new Promise((r) => setTimeout(r, 1500));
        job = await (await fetch(`${base}/status/${job.id}`, { headers })).json();
    }
    const o = job.output;
    let v = o && (o.image || o.output_image || o.result || o.image_url || (Array.isArray(o) ? o[0] : o));
    if (v && typeof v === 'object') v = v.image || v.url || v.base64;
    if (typeof v !== 'string') throw new Error('runpod_no_output');
    if (/^https?:\/\//.test(v)) {
        const r = await fetch(v);
        return { buf: Buffer.from(await r.arrayBuffer()), mime: r.headers.get('content-type') || 'image/png' };
    }
    const b64 = v.replace(/^data:image\/\w+;base64,/, '');
    return { buf: Buffer.from(b64, 'base64'), mime: 'image/png' };
}

// dev provider: no GPU needed, lets you test the whole flow and the one-credit rule
async function runMock(person) {
    await new Promise((r) => setTimeout(r, 2500));
    return { buf: person.buf, mime: person.mime };
}

async function generate(person, garment, desc) {
    if (PROVIDER === 'huggingface') return runHuggingFace(person, garment, desc);
    if (PROVIDER === 'runpod') return runRunpod(person, garment);
    return runMock(person);
}

// ---------- app ----------
const app = express();
app.disable('x-powered-by');
if (TRUST_PROXY) app.set('trust proxy', /^\d+$/.test(TRUST_PROXY) ? Number(TRUST_PROXY) : TRUST_PROXY);
app.use(express.json({ limit: '9mb' }));

app.get('/api/tryon/status', throttle(60, 60000), (req, res) => {
    const keys = keysFor(req, res);
    res.set('Cache-Control', 'no-store').json({ used: isUsed(keys), busy: isBusy(keys), provider: PROVIDER, garments: Object.keys(GARMENTS) });
});

app.post('/api/tryon', throttle(8, 60000), async (req, res) => {
    res.set('Cache-Control', 'no-store');
    const keys = keysFor(req, res);
    if (isUsed(keys)) return res.status(429).json({ error: 'free_try_used' });
    if (isBusy(keys)) return res.status(409).json({ error: 'in_progress' });

    const garmentDef = GARMENTS[String((req.body || {}).garmentId)];
    const person = parseDataUrl((req.body || {}).image);
    if (!garmentDef) return res.status(400).json({ error: 'bad_garment' });
    if (!person) return res.status(400).json({ error: 'bad_image' });

    keys.forEach((k) => inflight.add(k)); // reserve the single credit
    try {
        const gBuf = fs.readFileSync(path.join(ASSETS, garmentDef.file));
        const out = await withTimeout(generate(person, { buf: gBuf, mime: 'image/jpeg' }, garmentDef.desc), TIMEOUT_MS);
        const stamp = { t: Date.now(), g: String(req.body.garmentId) };
        keys.forEach((k) => { usage[k] = stamp; }); // spend it only after a successful result
        persist();
        res.json({ ok: true, image: toDataUrl(out.buf, out.mime), garment: garmentDef.name });
    } catch (err) {
        console.error('[tryon] failed:', err && err.message);
        res.status(502).json({ error: 'generation_failed' }); // credit NOT spent
    } finally {
        keys.forEach((k) => inflight.delete(k));
    }
});

// never serve server code, secrets or the usage store
app.use((req, res, next) => {
    if (/^\/(server|data)(\/|$)|^\/\.env/i.test(decodeURIComponent(req.path))) return res.status(404).end();
    next();
});
app.use(express.static(WEB_ROOT, { extensions: ['html'] }));

app.listen(PORT, () => {
    console.log(`Brix-Tryon running on http://localhost:${PORT}  (provider: ${PROVIDER})`);
});
