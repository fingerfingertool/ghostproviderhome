<?php
require_once __DIR__ . '/config.php';
$sent = false; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact'])) {
    $name = trim(substr($_POST['name'] ?? '', 0, 100));
    $email = trim(substr($_POST['email'] ?? '', 0, 150));
    $service = trim(substr($_POST['service'] ?? '', 0, 60));
    $msg = trim(substr($_POST['message'] ?? '', 0, 2000));
    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $msg === '') {
        $error = 'Please fill in your name, a valid email and a message.';
    } else {
        $subject = 'New inquiry — ' . SITE_NAME . ' (' . $service . ')';
        $body = "Name: $name\nEmail: $email\nService: $service\n\n$msg";
        @mail(CONTACT_EMAIL, $subject, $body, 'From: ' . CONTACT_EMAIL . "\r\nReply-To: $email");
        $sent = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= SITE_NAME ?> — Domains, Hosting, VPN & Digital Infrastructure</title>
<meta name="description" content="GhostProvider — domains, hosting, VPS, VPN, SSL and business email. One account, one invoice, human support.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='22' fill='%230B1D2A'/><text x='50' y='68' font-size='52' text-anchor='middle' fill='%23FFB224'>G</text></svg>">
</head>
<body>
<div class="grain"></div>
<header class="nav">
  <a class="brand" href="#"><span class="brand-mark">G</span><span class="brand-word">Ghost<em>Provider</em></span></a>
  <nav class="links">
    <a href="#services">Services</a><a href="#about">About</a><a href="#network">Network</a><a href="#pricing">Bundles</a><a href="#contact" class="btn small">Get started</a>
  </nav>
</header>

<section class="hero">
  <div class="hero-left">
    <p class="kicker"><span class="dot"></span> Friendly support · since 2019 · 40,000+ happy customers</p>
    <h1>Your website, email &amp; privacy — <span class="warm">simply taken care of.</span></h1>
    <p class="lede">Domain, hosting, email, security and VPN in one friendly place. One account, one bill, and real humans who reply in minutes — no tech skills needed.</p>
    <form class="domainbar" action="#pricing" method="get" onsubmit="return domainGo(event)">
      <span class="tld-icon">◈</span>
      <input id="domainInput" type="text" placeholder="Pick your name — like sunnyside…" aria-label="Domain search">
      <select aria-label="TLD"><option>.com</option><option>.net</option><option>.io</option><option>.co</option><option>.dev</option></select>
      <button type="submit">Search</button>
    </form>
    <p id="domainResult" class="domain-result" role="status"></p>
    <div class="hero-cta">
      <a href="#pricing" class="btn big">See simple plans</a>
      <a href="#about" class="ghost-link">How we help ↓</a>
    </div>
    <div class="hero-meta">
      <div><strong>30-day</strong><span>money-back promise</span></div>
      <div><strong>14 min</strong><span>friendly reply time</span></div>
      <div><strong>24/7</strong><span>real human help</span></div>
    </div>
  </div>
  <div class="hero-right">
    <div class="care-card">
      <div class="care-head"><span class="avatar">A</span><div><b>Anna from support</b><span>online now · replies in ~14 min</span></div><span class="online">●</span></div>
      <div class="chat">
        <p class="bubble in">Hi! I just bought a domain — what now? 🙂</p>
        <p class="bubble out">Hi Emma! We connected it to hosting, added SSL and email for you. All done ✓</p>
        <p class="bubble in">Wow, that was fast. Thank you!</p>
      </div>
      <div class="care-list">
        <div><i>✓</i> Free move of your site in 24h</div>
        <div><i>✓</i> SSL + backups included</div>
        <div><i>✓</i> We set up your email for you</div>
      </div>
    </div>
  </div>
</section>

<div class="marquee"><div class="track">
  <span>Domains</span><span>Shared Hosting</span><span>VPS &amp; Dedicated</span><span>VPN &amp; Privacy</span><span>SSL Certificates</span><span>Business Email</span><span>Site Care</span>
  <span>Domains</span><span>Shared Hosting</span><span>VPS &amp; Dedicated</span><span>VPN &amp; Privacy</span><span>SSL Certificates</span><span>Business Email</span><span>Site Care</span>
</div></div>

<!-- TRUST BLOCK — exact copy of reference; replace content later -->
<section id="trust" class="trust-strip">
  <div class="trust-col">
    <p class="t-rank">Ranked #1</p>
    <div class="t-stars blue">★★★★★</div>
    <p class="t-logo usa"><span class="usa-dot"></span>USA TODAY</p>
    <p class="t-sub">2023, 2024 &amp; 2025</p>
  </div>
  <div class="trust-col">
    <p class="t-rank">Ranked #1</p>
    <div class="t-stars gold">★★★★★</div>
    <p class="t-logo forbes">Forbes</p>
    <p class="t-sub">2025 &amp; 2026</p>
  </div>
  <div class="trust-col">
    <p class="t-rank tp"><span class="tp-star">★</span>Trustpilot</p>
    <div class="t-squares"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
    <p class="t-sub left">TrustScore 4.9<br><u><b>27,161</b> reviews</u></p>
  </div>
  <div class="trust-col">
    <p class="t-rank">4.8 stars</p>
    <div class="t-stars fb">★★★★<span class="half">★</span></div>
    <p class="t-logo facebook">facebook</p>
  </div>
</section>

<section id="services" class="section">
  <div class="sec-head"><h2>One team, six crafts.</h2><p>Each service has its own dedicated engineers — with one support desk and one bill.</p></div>
  <div class="grid">
    <article class="card tall"><div class="tag">01 · Registry</div><h3>Domains</h3><p>400+ TLDs at registry cost, free WHOIS privacy, bulk tools and easy transfers in.</p><div class="price">from <b>$8.49</b>/yr</div><a href="#contact">Claim a domain →</a></article>
    <article class="card"><div class="tag">02 · Cloud</div><h3>Web Hosting</h3><p>NVMe + LiteSpeed, free migration in under 24h, daily backups kept 30 days.</p><div class="price">from <b>$2.99</b>/mo</div><a href="#contact">Start hosting →</a></article>
    <article class="card"><div class="tag">03 · Compute</div><h3>VPS &amp; Servers</h3><p>KVM with dedicated vCPU, DDoS shield, snapshots and hourly billing. Scale in one click.</p><div class="price">from <b>$5.50</b>/mo</div><a href="#contact">Spin a server →</a></article>
    <article class="card"><div class="tag">04 · Privacy</div><h3>VPN</h3><p>WireGuard network in 32 cities, no-logs, kill-switch apps for every device, 5 seats included.</p><div class="price">from <b>$3.20</b>/mo</div><a href="#contact">Browse privately →</a></article>
    <article class="card"><div class="tag">05 · Trust</div><h3>SSL &amp; Security</h3><p>DV to EV certificates, WAF, malware removal and uptime monitoring with real alerts.</p><div class="price">from <b>$0</b> · free DV</div><a href="#contact">Secure a site →</a></article>
    <article class="card"><div class="tag">06 · Work</div><h3>Business Email</h3><p>you@yourbrand with 50 GB, calendar, drive and one-click migration from Gmail.</p><div class="price">from <b>$1.80</b>/mo</div><a href="#contact">Get work mail →</a></article>
  </div>
</section>

<section id="about" class="section about">
  <div class="about-box">
    <div><p class="kicker dark"><span class="dot"></span> About us</p>
    <h2>We handle the boring,<br>so you skip it.</h2>
    <p>GhostProvider started as two freelancers reselling hosting. Today we're one team running <strong>domains, hosting, VPN</strong> and <strong>site care</strong> — four groups, one roof. We run our own hardware in 3 data centers and work directly with registries, so there is no middleman between you and the metal.</p>
    <ul class="ticks"><li>✓ One account, one invoice, one support thread</li><li>✓ Real engineers on chat — 24/7, median 14 min reply</li><li>✓ 30-day money-back, no questions, no tickets maze</li></ul></div>
    <div class="stats">
      <div><b data-count="42000">0</b><span>active services</span></div>
      <div><b data-count="99">0</b><span>% renewal rate</span></div>
      <div><b>24/7</b><span>human support</span></div>
      <div><b>3</b><span>owned data centers</span></div>
    </div>
  </div>
</section>

<section id="network" class="section">
  <div class="sec-head"><h2>Latency you can feel.</h2><p>Anycast DNS + edge VPN exits. Pick the city closest to your customers.</p></div>
  <div class="pills"><span>Frankfurt 12ms</span><span>Amsterdam 18ms</span><span>Warsaw 21ms</span><span>London 24ms</span><span>New York 68ms</span><span>Singapore 142ms</span><span>+ 26 more</span></div>
</section>

<section id="pricing" class="section">
  <div class="sec-head"><h2>Bundles beat à la carte.</h2><p>Most clients land for a domain and stay for the bundle. Switch anytime.</p></div>
  <div class="plans">
    <div class="plan"><h3>Launch</h3><p class="p">Domain + hosting + SSL for a first site.</p><div class="amount">$4.90<span>/mo</span></div><ul><li>1× .com domain free 1st yr</li><li>10 GB NVMe hosting</li><li>Free SSL + backups</li></ul><a class="btn" href="#contact">Choose Launch</a></div>
    <div class="plan hot"><div class="flag">Most popular</div><h3>Studio</h3><p class="p">For freelancers &amp; shops: everything, plus VPN.</p><div class="amount">$11.90<span>/mo</span></div><ul><li>Everything in Launch</li><li>Business email (5 seats)</li><li>VPN (5 devices) + WAF</li></ul><a class="btn big" href="#contact">Choose Studio</a></div>
    <div class="plan"><h3>Fleet</h3><p class="p">VPS + team VPN + priority care.</p><div class="amount">$29.00<span>/mo</span></div><ul><li>4 vCPU / 8 GB VPS</li><li>Team VPN, 25 seats</li><li>Dedicated engineer</li></ul><a class="btn" href="#contact">Choose Fleet</a></div>
  </div>
</section>

<section id="contact" class="section contact">
  <div class="contact-box">
    <div><h2>Tell us what you're building.</h2><p>We reply within one business day — usually much faster. Or write to <a href="mailto:<?= CONTACT_EMAIL ?>"><?= CONTACT_EMAIL ?></a>.</p>
    <?php if ($sent): ?><p class="ok-box">✓ Message received — we'll reply shortly.</p>
    <?php elseif ($error): ?><p class="err-box"><?= htmlspecialchars($error) ?></p><?php endif; ?></div>
    <form method="post" class="form">
      <div class="row"><input name="name" placeholder="Your name" required><input name="email" type="email" placeholder="Email" required></div>
      <select name="service"><option>Domains</option><option>Hosting</option><option>VPS</option><option>VPN</option><option>Bundle / Other</option></select>
      <textarea name="message" rows="4" placeholder="I need a domain + hosting for…" required></textarea>
      <button class="btn big" name="contact" value="1" type="submit">Send message</button>
    </form>
  </div>
</section>

<footer><div class="foot">
  <div><span class="brand-mark">G</span> <b>GhostProvider</b><p>Domains · Hosting · VPS · VPN · SSL · Email<br>© <?= date('Y') ?> GhostProvider. All rights reserved.</p></div>
  <div class="fl"><a href="#services">Services</a><a href="#about">About</a><a href="#pricing">Bundles</a><a href="#contact">Contact</a></div>
</div></footer>
<script src="assets/app.js"></script>
</body>
</html>
