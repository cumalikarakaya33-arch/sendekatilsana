<?php ?><!doctype html>
<html lang="tr"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($title ?? 'sendekatilsana') ?></title>
<style>
/* Varsayılan (açık) */
:root{
  --bg:#f7f7fb; --card:#ffffff; --txt:#1f2937; --muted:#6b7280; --pri:#2563eb; --b:#e5e7eb;
  --input:#ffffff; --btnTxt:#ffffff;
}
/* Koyu: :root.dark (class ile) */
:root.dark{
  --bg:#0b1220; --card:#0f172a; --txt:#e5e7eb; --muted:#94a3b8; --pri:#22c55e; --b:#1e293b;
  --input:#0b1324; --btnTxt:#062312;
}

*{box-sizing:border-box} html,body{height:100%}
body{margin:0;background:var(--bg);color:var(--txt);font:15px/1.55 Inter,system-ui,Segoe UI,Roboto}
a{color:inherit}
.container{max-width:1100px;margin:0 auto;padding:24px}
.header{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;gap:14px}
.brand{display:flex;gap:10px;align-items:center}
.badge{font-size:12px;background:#0ea5e9;color:#00121f;border-radius:8px;padding:4px 8px;font-weight:600}
.nav a{margin:0 10px;color:var(--muted);text-decoration:none}.nav a:hover{color:var(--txt)}
.wrap{display:grid;gap:24px;grid-template-columns:1.1fr 0.9fr}
@media(max-width:900px){.wrap{grid-template-columns:1fr}}
.card{background:var(--card);border:1px solid var(--b);border-radius:16px;padding:22px}
.card h2{margin:0 0 6px 0;font-size:22px}
.card p.sub{margin:0 0 16px 0;color:var(--muted)}
label{display:block;margin:12px 0 6px}
input[type=text],input[type=email],input[type=password]{width:100%;padding:12px;border:1px solid var(--b);border-radius:12px;background:var(--input);color:var(--txt)}
button{padding:12px 14px;border-radius:12px;border:1px solid var(--pri);background:var(--pri);color:var(--btnTxt);cursor:pointer;font-weight:700}
.helper{margin-top:10px;color:var(--muted);font-size:13px}
.hero{border:1px solid var(--b);border-radius:16px;padding:22px;background:rgba(0,0,0,.02)}
:root.dark .hero{background:linear-gradient(135deg,#22c55e20,#22c55e05)}
.footer{margin:28px 0 8px;color:var(--muted);text-align:center;font-size:13px}
.theme-toggle{border:1px solid var(--b);background:var(--card);color:var(--txt);padding:8px 12px;border-radius:12px;cursor:pointer}
.theme-toggle:focus{outline:2px solid var(--pri);outline-offset:2px}
</style>
<script>
(function(){ // Sayfa açılırken kaydedilmiş temayı uygula
  try{
    var saved = localStorage.getItem('theme');
    if(saved === 'dark'){ document.documentElement.classList.add('dark'); }
  }catch(e){}
})();
</script>
</head>
<body>
<div class="container">
  <header class="header">
    <div class="brand"><strong>sendekatilsana</strong><span class="badge">beta</span></div>
    <nav class="nav">
      <a href="/giris/uye">Üye Giriş</a>
      <a href="/kayit/uye">Üye Kayıt</a>
      <button id="themeToggle" type="button" class="theme-toggle" aria-label="Tema değiştir">🌙 Koyu</button>
    </nav>
  </header>

  <div class="wrap">
    <aside class="hero card">
      <h1>Ödüllü çekilişlere katıl</h1>
      <p class="sub">Görevleri tamamla, kanıtını yükle, anında şansını dene.</p>
      <ul class="helper"><li>Hızlı kayıt</li><li>Bot koruma</li><li>Şeffaf sonuç</li></ul>
    </aside>
    <main class="card"><?= $content ?? '' ?></main>
  </div>

  <div class="footer">© <?= date('Y') ?> sendekatilsana</div>
</div>

<script>
// Düğme: light <-> dark, kalıcı
(function(){
  var btn = document.getElementById('themeToggle');
  function syncLabel(){
    btn.textContent = document.documentElement.classList.contains('dark') ? '☀️ Aydınlık' : '🌙 Koyu';
  }
  syncLabel();
  btn.addEventListener('click', function(){
    var root = document.documentElement;
    var isDark = root.classList.toggle('dark');
    try{ localStorage.setItem('theme', isDark ? 'dark':'light'); }catch(e){}
    syncLabel();
  });
})();
</script>
</body></html>
