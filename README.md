# GhostProvider — landing (PHP, cPanel-ready)

Static-ish PHP landing + crypto checkout for a digital-services seller
(domains, hosting, VPN, email, SSL). No framework, no build step, no DB.
Deploy: upload everything to cPanel `public_html`.

## Live repo
https://github.com/fingerfingertool/ghostproviderhome · branch `master`

## Stack
- `index.php` — landing page + contact form (POST → PHP `mail()`)
- `checkout.php` — flow: plan → details (email only, no KYC) → coin → redirect to `pay.php` → done
- `pay.php` — wallet-connect screen (Trust Wallet, MetaMask, Phantom, Rabby, Rainbow, OKX, Base Pay, Other). Real QR = `<scheme>:<wallet>?amount=<amt>`. Installed badges via real JS provider detection. "Launch extension" → TBA alert.
- `cart.php` — cart (localStorage `gp_cart`), checkout handoff via `?domains=`
- `assets/app.js` — mock domain search (hash-based availability across 8 TLDs × name combos), cart helpers
- `assets/style.css` — all styles (warm paper theme, Sora + Inter)
- `config.php` — all real settings (see below)
- `.htaccess` — DirectoryIndex + rewrite

## Key config (`config.php`)
- `CONTACT_EMAIL` = `hello@ghostprovider.com` (mailbox must exist; `mail()` may need SMTP on cPanel)
- `PLANS` — start 4.90 / plus 11.90 / pro 29.00 USD/mo
- `COINS` — BTC/ETH/USDT/LTC with placeholder `rate` and `wallet` (marked REPLACE). QR follows these automatically.

## Flows
1. Hero search → results list → Add to cart → `cart.php` → Checkout → `checkout.php?step=details&domains=...`
2. Get started / plan buttons → `checkout.php` → details → coin → `pay.php` (QR + wallet list + TBA extension btn + "I've paid →") → done screen
3. Contact form on `index.php#contact` → `mail()` → inline success/error

## Deliberate placeholders (must fix before launch)
1. Domain availability is MOCK (`hash()` in `app.js`). Needs registrar API (OpenProvider/Namecheap/Cloudflare).
2. Wallets + rates in `config.php` are demo. Replace with real addresses; live rates/BTCPay for auto-confirm.
3. Trust strip (`index.php#trust`) copies reference (USA TODAY/Forbes/Trustpilot/Facebook) — replace or remove (legal risk).
4. Stats (40k+, 14 min, 2019) and plan prices are invented — confirm real ones.
5. Logo is a "G" square; CI brand (colors/fonts/logo) not applied.
6. Contact form has no SMTP/captcha; test delivery on the actual cPanel host.

## Conventions for continuing AI
- Pure PHP, no composer. Keep it dependency-free and cPanel-compatible (PHP 7.4+).
- Crypto only, no KYC, no accounts: never ask for more than delivery email (+ optional domain).
- Trust block: keep exact 4-column layout, only swap text when given real data.
- Commit + push to `master` after each change (`git add -A && git commit -m ... && git push origin master`).
- Never commit real wallet private keys; public addresses in `config.php` are fine.
