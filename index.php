<?php
require_once __DIR__ . '/config.php';
$sent = false; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact'])) {
    $name = trim(substr($_POST['name'] ?? '', 0, 100));
    $email = trim(substr($_POST['email'] ?? '', 0, 150));
    $msg = trim(substr($_POST['message'] ?? '', 0, 2000));
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $msg === '') {
        $error = 'Please add your name, a valid email and a short message.';
    } else {
        @mail(CONTACT_EMAIL, 'New inquiry — ' . SITE_NAME, "Name: $name\nEmail: $email\n\n$msg", 'From: ' . CONTACT_EMAIL . "\r\nReply-To: $email");
        $sent = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= SITE_NAME ?> — Domains, hosting and VPN, simply done</title>
<meta name="description" content="GhostProvider — domains, hosting, VPN and email with friendly human support.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="nav">
  <a class="brand" href="#"><span class="mark">G</span>GhostProvider</a>
  <nav><a href="#services">Services</a><a href="#plans">Plans</a><a href="#about">About</a><a href="cart.php">Cart<span class="cartCount"></span></a><a class="btn" href="checkout.php">Get started</a></nav>
</header>

<main>
<section class="hero">
  <h1>Everything for your idea online,<br>in one friendly place.</h1>
  <p class="lede">Domain, website, email and privacy — set up for you, with real humans to help.</p>
  <form class="search" onsubmit="return domainGo(event)">
    <input id="domainInput" type="text" placeholder="Type the name you want…" aria-label="Domain search">
    <button type="submit">Search</button>
  </form>
  <p id="domainResult" class="result" role="status"></p>
  <div id="domainResults" class="dresults"></div>
  <p class="hint">Free help moving your site · 30-day money-back promise · Crypto payments only</p>
</section>

<!-- TRUST BLOCK — exact copy of reference; replace content later -->
<section id="trust" class="trust-strip">
  <div class="trust-col"><p class="t-rank">Ranked #1</p><div class="t-stars blue">★★★★★</div><p class="t-logo usa"><span class="usa-dot"></span>USA TODAY</p><p class="t-sub">2023, 2024 &amp; 2025</p></div>
  <div class="trust-col"><p class="t-rank">Ranked #1</p><div class="t-stars gold">★★★★★</div><p class="t-logo forbes">Forbes</p><p class="t-sub">2025 &amp; 2026</p></div>
  <div class="trust-col"><p class="t-rank tp"><span class="tp-star">★</span>Trustpilot</p><div class="t-squares"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div><p class="t-sub left">TrustScore 4.9<br><u><b>27,161</b> reviews</u></p></div>
  <div class="trust-col"><p class="t-rank">4.8 stars</p><div class="t-stars fb">★★★★<span class="half">★</span></div><p class="t-logo facebook">facebook</p></div>
</section>

<section id="services" class="section">
  <h2>Three things, done well.</h2>
  <div class="rows">
    <div class="row"><div><h3>Get found</h3><p>Domain + business email + simple website hosting. We connect it all for you.</p></div><span class="from">from $4.90/mo</span></div>
    <div class="row"><div><h3>Stay safe</h3><p>SSL, backups and security included. Your site just stays up.</p></div><span class="from">included</span></div>
    <div class="row"><div><h3>Stay private</h3><p>Easy VPN apps for all your devices. One tap, you're protected.</p></div><span class="from">from $3.20/mo</span></div>
  </div>
</section>

<section id="plans" class="section tint">
  <h2>Simple plans.</h2>
  <div class="plans">
    <div class="plan"><h3>Start</h3><p class="amt">$4.90<span>/mo</span></p><p>Domain, hosting and SSL for a first site.</p><a class="btn ghost" href="checkout.php?step=details&amp;plan=start">Choose Start</a></div>
    <div class="plan hot"><h3>Plus</h3><p class="amt">$11.90<span>/mo</span></p><p>Everything plus email and VPN. Most popular.</p><a class="btn" href="checkout.php?step=details&amp;plan=plus">Choose Plus</a></div>
    <div class="plan"><h3>Pro</h3><p class="amt">$29<span>/mo</span></p><p> Faster server and personal help.</p><a class="btn ghost" href="checkout.php?step=details&amp;plan=pro">Choose Pro</a></div>
  </div>
</section>

<section id="pay" class="section narrow pay">
  <h2>Pay with crypto. Nothing else.</h2>
  <p>We accept <b>BTC, ETH, USDT and LTC</b> — no cards, no banks, no hassle. You get an invoice with a wallet address, pay, and your service activates after one confirmation.</p>
</section>

<section id="about" class="section narrow">
  <h2>About us</h2>
  <p>We're GhostProvider — a small team that started in 2019 helping friends put their ideas online. Today 40,000+ customers trust us with their domains, sites and email. One account, one bill, and support from real people, day or night.</p>
</section>

<section id="contact" class="section narrow">
  <h2>Say hello.</h2>
  <p>Tell us what you're building — we reply within a day, usually faster. Or write to <a href="mailto:<?= CONTACT_EMAIL ?>"><?= CONTACT_EMAIL ?></a>.</p>
  <?php if ($sent): ?><p class="ok">Thanks — message received. We'll reply shortly.</p>
  <?php elseif ($error): ?><p class="err"><?= htmlspecialchars($error) ?></p><?php endif; ?>
  <form method="post" class="form">
    <input name="name" placeholder="Your name" required>
    <input name="email" type="email" placeholder="Email" required>
    <textarea name="message" rows="4" placeholder="I need…" required></textarea>
    <button class="btn" name="contact" value="1" type="submit">Send message</button>
  </form>
</section>
</main>

<footer><p><b>GhostProvider</b> · Domains, hosting, VPN, email · © <?= date('Y') ?></p></footer>
<script src="assets/app.js"></script>
</body>
</html>
