<?php
return [
  // Gizli URL kodu: /_status-<code>/
  'code'       => 's8m3p9',   // <- değiştir (rasgele 6-10 karakter)
  // İsteğe bağlı IP kısıtı (boş bırakırsan herkese açık)
  'ip_whitelist' => [/* '88.xx.xx.xx' */],

  // Görüntülenecek klasörler (güvenli)
  'allow_dirs' => ['app','routes','public'],
  // İzin verilen uzantılar
  'allow_ext'  => ['php','html','css','js','md','txt'],
];
