# Brix-Tryon website: PHP + MySQL content system

The home page (`index.php`) reads its text, pictures, pricing plans, FAQs, testimonials and
articles from MySQL. You change them in the admin panel at `/admin/`, no code needed.

## Set up on XAMPP (local)

1. Start **Apache** and **MySQL** in the XAMPP control panel.
2. Put this folder under `C:\xampp\htdocs\` (or point a virtual host at it).
3. Open a terminal in this folder and run:

   ```
   C:\xampp\php\php.exe install.php
   ```

   It creates the database `brix_tryon`, loads the current website content, and prints your
   admin username and a random password. It is safe to run again; it never overwrites edits.
   To choose your own login: `php install.php --user=you --pass=a-long-password`.
4. Open `http://localhost/<folder>/` for the site and `http://localhost/<folder>/admin/` for the admin.

## Set up on shared hosting

1. In your host's control panel create a MySQL database and user.
2. Copy `config.sample.php` to `config.local.php` and fill in the database details.
3. Upload all files, then run `php install.php` (SSH), or run it locally against the remote
   database by pointing `config.local.php` at it.
4. Make sure the `uploads/` folder is writable by PHP.

## What you can edit in the admin

| Area | Where |
|---|---|
| Headings, paragraphs, buttons, numbers, footer, pop-up texts, SEO title/description | **Page content** (one page per website section) |
| Logo, favicon, hero photo, feature photos, step image | **Page content**, choose a new file under the picture |
| Pricing plans, FAQs, testimonials, articles, comparison table | **Lists**: add, edit, hide, delete, reorder |
| "Get access" form and newsletter sign-ups | **Sign-ups**: view, mark read, delete, download CSV |

In headings, wrap a word in stars for the italic accent: `AI virtual *try-on*`. A new line is a line break.

## How it works

- `data/content.json`: every editable field with its original text (also the fallback if MySQL is down, so the site never goes blank).
- Tables: `settings` (one row per field), `items` (list rows), `leads`, `admins` (see `lib/schema.sql`).
- To make another piece of text editable: add it to `data/content.json`, replace it in `index.php`
  with `<?= e('your.key') ?>` (or `ttl()` for headings, `img()` for pictures), then run `php install.php`.

## Not editable from the admin (still in the page code)

- The animated product demo in the hero, the AI Studio picture strip and the calculator.
- The "Try it free" garments. Those must match the whitelist in `server/index.js`.
- Terms and Privacy pages (`terms-of-service.html`, `privacy-policy.html`).

## The live "Try it free" demo

It calls `/api/tryon`, which is the Node app in `server/`. Under Apache it keeps working only if that
app is running and proxied (see the commented `ProxyPass` lines in `.htaccess`). The Node server no
longer serves the website; it only provides the API.

## Security notes

- Change the generated admin password after the first login (Admin → Change password).
- `uploads/` only accepts real images and cannot execute scripts. `lib/`, `data/`, `server/` and
  `config*.php` are blocked from direct web access by `.htaccess` (Apache). On Nginx, add equivalent rules.
- Do not commit `config.local.php`.
