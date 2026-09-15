<?php
define('SITE_NAME', 'GhostProvider');
define('CONTACT_EMAIL', 'hello@ghostprovider.com');

// Plans (USD per month). Checkout links use these keys.
define('PLANS', [
  'start' => ['name' => 'Start', 'price' => 4.90,  'desc' => 'Domain, hosting and SSL for a first site.'],
  'plus'  => ['name' => 'Plus',  'price' => 11.90, 'desc' => 'Everything plus email and VPN. Most popular.'],
  'pro'   => ['name' => 'Pro',   'price' => 29.00, 'desc' => 'Faster server and personal help.'],
]);

// Coins accepted. Rate = USD per 1 coin (placeholder — replace with live rates or BTCPay).
// Wallet = address shown on the invoice. REPLACE with your real wallets before launch.
define('COINS', [
  'BTC'  => ['name' => 'Bitcoin',  'rate' => 67000, 'wallet' => 'bc1QREPLACE_WITH_YOUR_BTC_ADDRESS'],
  'ETH'  => ['name' => 'Ethereum', 'rate' => 3500,  'wallet' => '0xREPLACE_WITH_YOUR_ETH_ADDRESS'],
  'USDT' => ['name' => 'Tether',   'rate' => 1,     'wallet' => 'TREPLACE_WITH_YOUR_TRON_USDT_ADDRESS (TRC20)'],
  'LTC'  => ['name' => 'Litecoin', 'rate' => 82,    'wallet' => 'ltc1REPLACE_WITH_YOUR_LTC_ADDRESS'],
]);
