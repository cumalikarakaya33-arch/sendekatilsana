<?php ?><!doctype html>
<html lang="tr"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($title ?? 'Admin') ?></title>
<style>
:root{
  --bg:#0b1220; --panel:#0f172a; --txt:#e5e7eb; --muted:#94a3b8; --b:#1e293b; --pri:#22c55e;
  --input:#0b1324; --btnTxt:#062312;
}
*{box-sizing:border-box} html,body{height:100%}
body{margin:0;background:var(--bg);color:var(--txt);font:14px/1.5 system-ui,Segoe UI,Inter,Roboto}
.container{max-width:1100px;margin:0 auto;padding:24px}
.header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
.brand{font-weight:700}
.nav a{margin:0 8px;color:var(--muted);text-decoration:none}
.nav a:hover{color:#fff}
.card{background:var(--panel);border:1px solid var(--b);border-radius:14px;padding:18px}
.grid{display:grid;gap:16px}
@media(min-width:900px){.grid{grid-template-columns:220px 1fr}}
.sidebar .item{display:block;padding:10px;border:1px solid var(--b);border-radius:10px;margin-bottom:8px;color:var(--muted);text-decoration:none}
.sidebar .item:hover{color:#fff;border-color:#334155}
label{display:block;margin:10px 0 6px}
input[type=text],input[type=password]{width:100%;padding:10px;border:1px solid var(--b);border-radius:10px;background:var(--input);color:var(--txt)}
button{padding:10px 14px;border-radius:10px;border:1px solid var(--pri);background:var(--pri);color:var(--btnTxt);cursor:pointer;font-weight:700}
.center{max-width:420px;margin:40px auto}
.alert{border:1px solid #fecaca;background:#fee2e2;color:#7f1d1d;border-radius:10px;padding:10px;margin-bottom:10px}
.muted{color:var(--muted);font-size:13px}
</style>
</head>
<body>
<div class="container">
  <header class="header">
    <div class="brand">Admin</div>
    <?php if (empty($hideNav)): ?>
    <nav class="nav">
      <a href="<?= htmlspecialchars($panelPath) ?>">Panel</a>
      <a href="<?= htmlspecialchars($panelPath) ?>/cikis">Çıkış</a>
    </nav>
    <?php endif; ?>
  </header>

  <?php if (empty($hideNav)): ?>
  <div class="grid">
    <aside class="sidebar">
      <a class="item" href="<?= htmlspecialchars($panelPath) ?>">Genel Bakış</a>
      <a class="item" href="#">Site Yönetimi</a>
      <a class="item" href="#">Menüler</a>
      <a class="item" href="#">Reklam Alanları</a>
    </aside>
    <main class="card"><?= $content ?? '' ?></main>
  </div>
  <?php else: ?>
    <main class="card center"><?= $content ?? '' ?></main>
  <?php endif; ?>

  <p class="muted" style="margin-top:14px">© <?= date('Y') ?> sendekatilsana — admin</p>
</div>
</body></html>
