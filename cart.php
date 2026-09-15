<?php require_once __DIR__ . '/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cart — <?= SITE_NAME ?></title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="nav"><a class="brand" href="index.php"><span class="mark">G</span>GhostProvider</a>
<nav><a href="index.php">← Keep browsing</a></nav></header>
<main class="section narrow">
<h1>Your cart.</h1>
<div id="cartList"></div>
<p id="cartTotal" class="amt"></p>
<div style="display:flex;gap:10px;margin-top:14px">
  <a class="btn ghost" href="index.php">Add more domains</a>
  <a class="btn" id="checkoutBtn" href="checkout.php">Checkout →</a>
</div>
<p class="hint">Domains are yearly. Plans are monthly. Crypto only, no KYC.</p>
</main>
<footer><p><b>GhostProvider</b> · © <?= date('Y') ?></p></footer>
<script src="assets/app.js"></script>
<script>
const list = document.getElementById('cartList');
function render(){
  const c = getCart();
  if(!c.length){list.innerHTML='<p class="hint">Cart is empty — search a domain on the home page.</p>';document.getElementById('cartTotal').textContent='';return}
  let t=0;
  list.innerHTML=c.map((x,i)=>{t+=x.p;return `<div class="drow"><span class="dname">${x.d}</span><span class="dprice">$${x.p.toFixed(2)}/yr</span><button onclick="rm(${i})">Remove</button></div>`}).join('');
  document.getElementById('cartTotal').textContent='Total: $'+t.toFixed(2);
  document.getElementById('checkoutBtn').href='checkout.php?step=details&domains='+encodeURIComponent(c.map(x=>x.d).join(','));
}
function rm(i){const c=getCart();c.splice(i,1);setCart(c);render()}
render();
</script>
</body>
</html>
