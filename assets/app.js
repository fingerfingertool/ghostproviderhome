const TLDS = [
  ['.com', 8.49], ['.net', 9.99], ['.io', 32.00], ['.co', 24.00],
  ['.dev', 12.00], ['.app', 14.00], ['.org', 9.49], ['.xyz', 2.99]
];
function hash(s){let h=0;for(let i=0;i<s.length;i++)h=(h*31+s.charCodeAt(i))>>>0;return h}
function getCart(){try{return JSON.parse(localStorage.getItem('gp_cart')||'[]')}catch(e){return[]}}
function setCart(c){localStorage.setItem('gp_cart',JSON.stringify(c));updateBadge()}
function updateBadge(){const n=getCart().length;document.querySelectorAll('.cartCount').forEach(el=>el.textContent=n>0?' ('+n+')':'')}
function domainGo(e){
  e.preventDefault();
  const raw=document.getElementById('domainInput').value.trim().toLowerCase().replace(/[^a-z0-9-]/g,'');
  const box=document.getElementById('domainResults');
  if(!raw){box.innerHTML='<p class="err">Type a name first.</p>';return false}
  const names=[raw, raw+'hq', 'get'+raw, raw+'app'].slice(0,3);
  let html='';
  names.forEach(n=>{
    TLDS.forEach(([tld,price])=>{
      const avail=hash(n+tld)%3!==0;
      const d=n+tld;
      html+=`<div class="drow ${avail?'':'taken'}"><span class="dname">${d}</span>`
        + (avail
          ? `<span class="dprice">$${price.toFixed(2)}/yr</span><button onclick="addToCart('${d}',${price})">Add to cart</button>`
          : `<span class="dtaken">taken</span>`);
        + `</div>`;
    });
  });
  box.innerHTML=html
    + `<div class="dfoot"><a class="btn" href="cart.php">Go to cart →</a>
       <span class="hint">Mock availability — connect registrar API for live data.</span></div>`;
  return false;
}
function addToCart(d,p){
  const c=getCart();
  if(!c.find(x=>x.d===d)){c.push({d,p});setCart(c)}
  updateBadge();
  alert(d+' added to cart ✓');
}
document.addEventListener('DOMContentLoaded',updateBadge);
