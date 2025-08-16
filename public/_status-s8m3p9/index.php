<?php
declare(strict_types=1);
header('X-Robots-Tag: noindex, nofollow');

$cfgFile = __DIR__ . '/../../config/status.php';
$cfg = file_exists($cfgFile) ? require $cfgFile : ['code'=>'dev','ip_whitelist'=>[], 'allow_dirs'=>['app','routes','public'], 'allow_ext'=>['php','html','css','js','md','txt']];

// IP kısıtı
$ips = $cfg['ip_whitelist'] ?? [];
if (!empty($ips)) {
  $ip = $_SERVER['REMOTE_ADDR'] ?? '';
  if (!in_array($ip, $ips, true)) { http_response_code(404); exit('404 Not Found'); }
}

// Güvenli temel dizin (proje kökü = public_html)
$BASE = dirname(__DIR__, 2);

// Yardımcılar
function rel(string $abs, string $base): string {
  $abs = str_replace('\\','/',$abs); $base = rtrim(str_replace('\\','/',$base),'/');
  return ltrim(substr($abs, strlen($base)), '/');
}
function inAllowed(string $path, array $allowedRoots): bool {
  $p = realpath($path); if ($p===false) return false;
  foreach ($allowedRoots as $root) {
    if (strpos($p, $root . DIRECTORY_SEPARATOR) === 0 || $p === $root) return true;
  }
  return false;
}

// İzinli kök yollar
$allowedRoots = [];
foreach (($cfg['allow_dirs'] ?? []) as $d) {
  $rp = realpath($BASE . DIRECTORY_SEPARATOR . $d);
  if ($rp) $allowedRoots[] = $rp;
}
$allowExt = array_map('strtolower', $cfg['allow_ext'] ?? []);

// Dosya görüntüleme
if (isset($_GET['f'])) {
  $rel = ltrim(str_replace('..','', $_GET['f']), '/');
  $abs = realpath($BASE . DIRECTORY_SEPARATOR . $rel);
  if (!$abs || !inAllowed($abs, $allowedRoots)) { http_response_code(403); exit('403'); }
  $ext = strtolower(pathinfo($abs, PATHINFO_EXTENSION));
  if (!in_array($ext, $allowExt, true)) { http_response_code(415); exit('415'); }
  $code = file_get_contents($abs);
  $safe = htmlspecialchars($code, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
  $lines = explode("\n", $safe);
  echo "<!doctype html><meta charset='utf-8'><title>Görüntüle: ".htmlspecialchars($rel)."</title>";
  echo "<style>body{font:13px/1.5 ui-monospace,Consolas,Menlo,monospace;margin:16px;background:#0b1220;color:#e5e7eb}
  a{color:#93c5fd;text-decoration:none}a:hover{text-decoration:underline}
  .path{margin-bottom:10px}.code{background:#0f172a;border:1px solid #1e293b;border-radius:10px;padding:12px;overflow:auto}
  .ln{color:#64748b;padding-right:12px;text-align:right;display:inline-block;min-width:42px}
  </style>";
  echo "<div class='path'><a href='./'>&larr; Dosya listesi</a> • ".htmlspecialchars($rel)."</div>";
  echo "<pre class='code'>";
  foreach ($lines as $i=>$ln) { echo "<span class='ln'>".($i+1)."</span> ".$ln."\n"; }
  echo "</pre>";
  exit;
}

// Dosya ağacı + son değişenler
$items = [];
$recent = [];
foreach ($allowedRoots as $root) {
  $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));
  foreach ($it as $file) {
    /** @var SplFileInfo $file */
    if ($file->isDir()) continue;
    $ext = strtolower($file->getExtension());
    if (!in_array($ext, $allowExt, true)) continue;
    $abs = $file->getRealPath();
    $relative = rel($abs, $BASE);
    $items[] = [
      'rel' => $relative,
      'mtime' => $file->getMTime(),
      'size' => $file->getSize(),
    ];
  }
}
usort($items, fn($a,$b)=>strcmp($a['rel'],$b['rel']));
$recent = $items;
usort($recent, fn($a,$b)=>$b['mtime']<=>$a['mtime']);
$recent = array_slice($recent, 0, 20);

// Aktif modül (README.md içinden)
$active = '';
$readme = $BASE.'/README.md';
if (is_file($readme)) {
  foreach (file($readme) as $line) {
    if (stripos($line, 'Aktif Modül:') !== false) { $active = trim($line); break; }
  }
}

// Çıktı
?><!doctype html>
<html lang="tr"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Status (salt-okunur)</title>
<style>
:root{--bg:#0b1220;--card:#0f172a;--txt:#e5e7eb;--muted:#94a3b8;--b:#1e293b;--pri:#22c55e}
*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--txt);font:14px/1.6 system-ui,Segoe UI,Inter,Roboto}
.wrap{max-width:1100px;margin:0 auto;padding:20px}
.card{background:var(--card);border:1px solid var(--b);border-radius:14px;padding:16px;margin-bottom:16px}
h1{margin:0 0 8px 0;font-size:18px}
small{color:var(--muted)}
table{width:100%;border-collapse:collapse;font-size:13px}
td,th{border-bottom:1px solid var(--b);padding:8px}
a{color:#93c5fd;text-decoration:none}a:hover{text-decoration:underline}
.tag{display:inline-block;padding:2px 8px;border:1px solid var(--b);border-radius:999px;font-size:12px;color:var(--muted)}
</style></head><body>
<div class="wrap">
  <div class="card">
    <h1>Proje Durumu <small class="tag"><?= htmlspecialchars($active ?: 'Aktif Modül: (belirtilmedi)') ?></small></h1>
    <div><small>Bu sayfa salt-okunurdur. Gizli dosyalar listelenmez.</small></div>
  </div>

  <div class="card">
    <h2 style="margin:0 0 8px 0">Son Değişen 20 Dosya</h2>
    <table>
      <tr><th>Dosya</th><th>Boyut</th><th>Güncelleme</th></tr>
      <?php foreach ($recent as $r): ?>
      <tr>
        <td><a href="?f=<?= urlencode($r['rel']) ?>"><?= htmlspecialchars($r['rel']) ?></a></td>
        <td><?= number_format($r['size']) ?> B</td>
        <td><?= date('Y-m-d H:i:s', $r['mtime']) ?></td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>

  <div class="card">
    <h2 style="margin:0 0 8px 0">Tüm Dosyalar (izinli dizinler)</h2>
    <table>
      <tr><th>Dosya</th><th>Boyut</th><th>Güncelleme</th></tr>
      <?php foreach ($items as $it): ?>
      <tr>
        <td><a href="?f=<?= urlencode($it['rel']) ?>"><?= htmlspecialchars($it['rel']) ?></a></td>
        <td><?= number_format($it['size']) ?> B</td>
        <td><?= date('Y-m-d H:i:s', $it['mtime']) ?></td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</div>
</body></html>
