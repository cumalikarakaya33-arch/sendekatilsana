<?php
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/AdminController.php';

$router->get('/', function(){ echo 'OK'; });

// AUTH GET
$router->get('/giris/uye', [AuthController::class, 'showUserLogin']);
$router->get('/kayit/uye', [AuthController::class, 'showUserRegister']);

// ADMIN
$ADMIN = file_exists(__DIR__ . '/../config/admin.php') ? require __DIR__ . '/../config/admin.php' : ['panel_code' => 'dev'];
$panelPath = '/_panel-' . ($ADMIN['panel_code'] ?? 'dev');

$router->get($panelPath.'/giris', [AdminController::class, 'showLogin']);
$router->post($panelPath.'/giris', [AdminController::class, 'login']);
$router->get($panelPath.'/cikis', [AdminController::class, 'logout']);
$router->get($panelPath,          [AdminController::class, 'dashboard']);
