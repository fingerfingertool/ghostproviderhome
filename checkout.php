<?php
require_once __DIR__ . '/config.php';
$plans = PLANS; $coins = COINS;

$step = $_GET['step'] ?? 'plan';
$planKey = $_GET['plan'] ?? $_POST['plan'] ?? 'plus';
if (!isset($plans[$planKey])) $planKey = 'plus';
$plan = $plans[$planKey];

$coinKey = $_GET['coin'] ?? $_POST['coin'] ?? 'BTC';
if (!isset($coins[$coinKey])) $coinKey = 'BTC';
$coin = $coins[$coinKey];

$email = trim($_POST['email'] ?? $_GET['email'] ?? '');
$domain = trim(substr($_POST['domain'] ?? $_GET['domain'] ?? '', 0, 100));
$paid = isset($_GET['paid']);

// Step 2 posted details -> go to coin step; coin posted -> invoice
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['details'])) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $step = 'details'; $err = 'Enter a valid email — we send your login there. No account, no KYC.'; }
    else $step = 'coin';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['coin_chosen'])) {
    $step = 'invoice';
    $orderId = 'GP-' . strtoupper(substr(md5($email . $planKey . time()), 0, 8));
} elseif (isset($_GET['step']) && in_array($_GET['step'], ['plan','details','coin','invoice','done'])) {
    $step = $_GET['step'];
    $orderId = $_GET['order'] ?? ('GP-' . strtoupper(substr(md5(($email ?: 'guest') . $planKey . time()), 0, 8)));
} else { $step = 'plan'; }

if ($step === 'done' && !$paid) $paid = true;
$amount = round($plan['price'] / $coin['rate'], 6);
$qr = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' . urlencode($coin['wallet']);
$q = fn($s) => htmlspecialchars($s, ENT_QUOTES);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Get started — <?= SITE_NAME ?></title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="nav"><a class="brand" href="index.php"><span class="mark">G</span>GhostProvider</a>
<nav><a href="index.php">← Back</a></nav></header>
<main class="section narrow">
<p class="steps">1 Plan · 2 Details · 3 Coin · 4 Pay</p>

<?php if ($step === 'plan'): ?>
  <h1>Pick your plan.</h1><p class="lede">No account. No KYC. Pay with crypto.</p>
  <div class="plans col">
  <?php foreach ($plans as $k => $p): ?>
    <div class="plan <?= $k === $planKey ? 'hot' : '' ?>">
      <h3><?= $q($p['name']) ?></h3><p class="amt">$<?= number_format($p['price'], 2) ?><span>/mo</span></p>
      <p><?= $q($p['desc']) ?></p>
      <a class="btn <?= $k === $planKey ? '' : 'ghost' ?>" href="checkout.php?step=details&amp;plan=<?= $k ?>">Continue with <?= $q($p['name']) ?></a>
    </div>
  <?php endforeach; ?>
  </div>

<?php elseif ($step === 'details'): ?>
  <h1>Where do we send it?</h1>
  <p class="lede">Just an email for your login details<?= $domain ? '' : ' and an optional domain' ?>. That's all — no password, no KYC.</p>
  <?php if (!empty($err)): ?><p class="err"><?= $q($err) ?></p><?php endif; ?>
  <form method="post" class="form">
    <input type="hidden" name="plan" value="<?= $q($planKey) ?>">
    <input name="email" type="email" placeholder="Email for delivery" value="<?= $q($email) ?>" required>
    <input name="domain" placeholder="Wanted domain (optional) — e.g. myshop.com" value="<?= $q($domain) ?>">
    <button class="btn" name="details" value="1" type="submit">Continue →</button>
  </form>

<?php elseif ($step === 'coin'): ?>
  <h1>Pay with crypto.</h1>
  <p class="lede"><?= $q($plan['name']) ?> — $<?= number_format($plan['price'], 2) ?>/mo. Cards not accepted, on purpose.</p>
  <form method="post" class="coins">
    <input type="hidden" name="plan" value="<?= $q($planKey) ?>">
    <input type="hidden" name="email" value="<?= $q($email) ?>">
    <input type="hidden" name="domain" value="<?= $q($domain) ?>">
    <?php foreach ($coins as $k => $c): $a = round($plan['price'] / $c['rate'], 6); ?>
      <label class="coin"><input type="radio" name="coin" value="<?= $k ?>" <?= $k === $coinKey ? 'checked' : '' ?> required>
      <b><?= $k ?></b> <span><?= $q($c['name']) ?> · ≈ <?= $a ?></span></label>
    <?php endforeach; ?>
    <button class="btn" name="coin_chosen" value="1" type="submit">Show payment address →</button>
  </form>

<?php elseif ($step === 'invoice'): ?>
  <h1>Send <?= $amount ?> <?= $q($coinKey) ?>.</h1>
  <p class="lede">Order <b><?= $q($orderId ?? '') ?></b> · <?= $q($plan['name']) ?> — $<?= number_format($plan['price'], 2) ?> · to <?= $q($email) ?></p>
  <div class="invoice">
    <img src="<?= $q($qr) ?>" alt="Payment QR" width="220" height="220">
    <p class="addr"><?= $q($coin['wallet']) ?></p>
    <p class="hint">Amount: <b><?= $amount ?> <?= $q($coinKey) ?></b> · one confirmation activates your service. Sent to <?= $q($email) ?>.</p>
    <button class="btn" onclick="navigator.clipboard.writeText('<?= $q($coin['wallet']) ?>');this.textContent='Copied ✓'">Copy address</button>
    <a class="btn ghost" href="checkout.php?step=done&amp;plan=<?= $q($planKey) ?>&amp;coin=<?= $q($coinKey) ?>&amp;email=<?= urlencode($email) ?>&amp;order=<?= $q($orderId ?? '') ?>&amp;paid=1">I've paid →</a>
  </div>
  <p class="hint">Demo wallets — replace with yours in config.php. For live auto-confirmation connect BTCPay Server.</p>

<?php else: ?>
  <h1>Thanks — we're on it. ✓</h1>
  <p class="lede">Order <b><?= $q($_GET['order'] ?? '') ?></b>. Once your payment confirms, we set everything up and email <b><?= $q($_GET['email'] ?? $email) ?></b>. Questions? <a href="mailto:<?= CONTACT_EMAIL ?>"><?= CONTACT_EMAIL ?></a></p>
  <a class="btn" href="index.php">Back to home</a>
<?php endif; ?>
</main>
<footer><p><b>GhostProvider</b> · Crypto only · No KYC · No accounts · © <?= date('Y') ?></p></footer>
</body>
</html>
