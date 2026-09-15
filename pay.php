<?php
require_once __DIR__ . '/config.php';
$plans = PLANS; $coins = COINS;
$planKey = $_GET['plan'] ?? 'plus'; if (!isset($plans[$planKey])) $planKey = 'plus';
$coinKey = $_GET['coin'] ?? 'BTC'; if (!isset($coins[$coinKey])) $coinKey = 'BTC';
$email = trim($_GET['email'] ?? ''); $domain = trim(substr($_GET['domain'] ?? '', 0, 100));
$order = $_GET['order'] ?? ('GP-' . strtoupper(substr(md5(($email ?: 'guest') . $planKey . time()), 0, 8)));
$plan = $plans[$planKey]; $coin = $coins[$coinKey];
$amount = round($plan['price'] / $coin['rate'], 6);
// Real payment URI encoded in QR (e.g. bitcoin:<addr>?amount=<amt>)
$schemes = ['BTC' => 'bitcoin', 'ETH' => 'ethereum', 'USDT' => 'tether', 'LTC' => 'litecoin'];
$uri = ($schemes[$coinKey] ?? strtolower($coinKey)) . ':' . $coin['wallet'] . '?amount=' . $amount;
$qr = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($uri);
$q = fn($s) => htmlspecialchars($s, ENT_QUOTES);
$wallets = [
  ['Trust Wallet', 'trustwallet', 'T', '#1a56db'],
  ['Base Pay', 'basepay', 'B', '#0000ff'],
  ['MetaMask', 'metamask', 'M', '#f6851b'],
  ['Phantom', 'phantom', 'P', '#ab9ff2'],
  ['Rabby', 'rabby', 'R', '#7d8bff'],
  ['Rainbow', 'rainbow', 'R', '#001aff'],
  ['OKX Wallet', 'okx', 'O', '#000000'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pay $<?= number_format($plan['price'], 2) ?> to GhostProvider</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
<style>
.payhead{text-align:center;font-size:30px;font-weight:700;padding:26px 16px;border-bottom:1px solid #e5e5e5;background:#fff;margin:0}
.wcard{max-width:960px;margin:60px auto;background:#fff;border:1px solid #ddd;border-radius:14px;display:grid;grid-template-columns:320px 1fr;overflow:hidden}
.wleft{border-right:1px solid #e5e5e5;padding:22px 0}
.wleft h3{margin:0 0 10px 22px;font-size:21px}
.witem{display:flex;gap:12px;align-items:center;padding:11px 22px;cursor:pointer;border:0;background:none;width:100%;text-align:left;font-size:16px}
.witem.active{background:#e8f0fe}.witem .ic{width:36px;height:36px;border-radius:9px;color:#fff;display:grid;place-items:center;font-weight:700}
.witem small{display:block;color:#1a56db;font-size:12px;font-weight:600}
.witem .sub{font-size:12px;color:#777}
.wright{padding:30px;text-align:center}
.wright p{font-size:19px;max-width:420px;margin:0 auto 18px}
.qrbox{border:1px solid #ddd;border-radius:16px;display:inline-block;padding:14px;position:relative}
.qrbox img{display:block}
.or{display:flex;align-items:center;gap:14px;color:#888;margin:16px auto;max-width:380px;font-size:13px}
.or::before,.or::after{content:"";flex:1;height:1px;background:#ddd}
.launch{border:1px solid #ddd;background:#fff;border-radius:12px;padding:14px 30px;font-size:18px;font-weight:600;color:#1a56db;cursor:pointer}
.wmeta{margin-top:14px;font-size:13px;color:#666}
@media(max-width:760px){.wcard{grid-template-columns:1fr}.wleft{border-right:0;border-bottom:1px solid #e5e5e5}}
</style>
</head>
<body style="background:#fafafa">
<h1 class="payhead">Pay $<?= number_format($plan['price'], 2) ?> to GhostProvider</h1>
<div class="wcard">
  <div class="wleft"><h3>Select a wallet</h3><div id="wlist">
    <?php foreach ($wallets as $i => $w): ?>
    <button class="witem <?= $i === 0 ? 'active' : '' ?>" data-w="<?= $q($w[0]) ?>" data-detect="<?= $q($w[1]) ?>">
      <span class="ic" style="background:<?= $q($w[3]) ?>"><?= $q($w[2]) ?></span>
      <span><?= $q($w[0]) ?><small class="inst" hidden>Installed</small></span>
    </button>
    <?php endforeach; ?>
    <button class="witem" data-w="Other wallets"><span class="ic" style="background:#fff;border:1px solid #ccc;color:#333">▭</span><span>Other wallets<br><span class="sub">480+ wallets via WalletConnect</span></span></button>
  </div></div>
  <div class="wright">
    <p id="qrLabel">Scan with Trust Wallet to connect and confirm payment</p>
    <div class="qrbox"><img src="<?= $q($qr) ?>" alt="Payment QR" width="300" height="300"></div>
    <div class="or">OR</div>
    <button class="launch" onclick="alert('TBA — extension connect coming soon. Please scan the QR to pay.') ">Launch extension ⧉</button>
    <p class="wmeta">Order <?= $q($order) ?> · <?= $q($plan['name']) ?> · <?= $q($amount) ?> <?= $q($coinKey) ?> to <?= $q($email ?: 'your email') ?><br><?= $q($coin['wallet']) ?></p>
    <p><a href="checkout.php?step=done&amp;plan=<?= $q($planKey) ?>&amp;coin=<?= $q($coinKey) ?>&amp;email=<?= urlencode($email) ?>&amp;order=<?= $q($order) ?>&amp;paid=1">I've paid →</a></p>
  </div>
</div>
<script>
// Real detection of injected wallet providers. No extension = no badge.
const found = {
  trustwallet: !!(window.trustwallet || (window.ethereum && window.ethereum.isTrust)),
  metamask: !!(window.ethereum && window.ethereum.isMetaMask),
  phantom: !!(window.phantom || window.solana),
  rabby: !!(window.ethereum && window.ethereum.isRabby),
  rainbow: !!(window.ethereum && window.ethereum.isRainbow),
  okx: !!(window.okxwallet),
  basepay: !!(window.ethereum && window.ethereum.isBasePay)
};
document.querySelectorAll('.witem[data-detect]').forEach(b => {
  if (found[b.dataset.detect]) b.querySelector('.inst').hidden = false;
});
document.querySelectorAll('.witem').forEach(b => b.addEventListener('click', () => {
  document.querySelectorAll('.witem').forEach(x => x.classList.remove('active'));
  b.classList.add('active');
  document.getElementById('qrLabel').textContent = 'Scan with ' + b.dataset.w + ' to connect and confirm payment';
}));
</script>
</body>
</html>
