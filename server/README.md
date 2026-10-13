# Brix-Tryon demo server

Serves the website and runs the **"Try it free"** virtual try-on.
One free try per visitor, enforced on the server (never in the browser).

## Run it

```bash
cd server
npm install
cp .env.example .env      # then edit .env
npm start                 # http://localhost:3000
```

The site must be opened through this server (not as a plain file or static host),
because the page calls `/api/tryon`.

## Providers (`TRYON_PROVIDER` in `.env`)

| Value | What it does |
|---|---|
| `mock` | No GPU. Returns the uploaded photo after 2.5 s. Use it to test the flow and the one-try rule. |
| `huggingface` | Calls a Gradio Space (default `yisol/IDM-VTON`) with `@gradio/client`. Set `HF_TOKEN` to avoid anonymous queue limits. |
| `runpod` | Calls your RunPod serverless endpoint (`/run` then `/status`). Set `RUNPOD_ENDPOINT_ID`, `RUNPOD_API_KEY` and, if your handler uses different field names, `RUNPOD_PERSON_FIELD` / `RUNPOD_GARMENT_FIELD` / `RUNPOD_EXTRA_INPUT`. |

The RunPod handler is expected to return an image as base64, a data URL or an
`http(s)` URL in `output.image` (also accepted: `output_image`, `result`, `image_url`,
or the output itself). Adjust `runRunpod()` in `index.js` if yours differs.

## How "one user, one credit" works

- Every request is keyed by a hash of the visitor **IP** (IPv6 by /64) **and** a signed
  `bt_id` cookie. If either key has already used its try, the request is refused (HTTP 429).
- The credit is reserved before generation (so two parallel requests cannot both pass)
  and is only **spent after a successful result**. A provider error does not burn it.
- Usage is stored in `server/data/usage.json` as HMAC hashes, not raw IPs.
- Set `SESSION_SECRET` to a long random value and keep it stable, otherwise hashes
  reset on restart and everyone gets a new try.
- Behind nginx / a load balancer set `TRUST_PROXY=1`; behind Cloudflare set
  `TRUST_CLOUDFLARE=true`. Otherwise every visitor looks like the proxy's IP.

Known limits of an IP-based rule: people on a shared network (office, campus, mobile
carrier NAT) share one try, and someone can switch IP with a VPN. Stronger options are
email or phone verification before the try.

## Privacy

Uploaded photos are processed in memory and are not written to disk by this server.
They are sent to the provider you choose (Hugging Face or RunPod), so mention that in
your privacy policy.
