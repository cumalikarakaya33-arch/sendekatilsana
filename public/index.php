<?php
declare(strict_types=1);
error_reporting(E_ALL); ini_set('display_errors','1');
session_start();

require_once __DIR__ . '/../app/Core/Router.php';

$router = new Router();

// Rotaları yükle
require_once __DIR__ . '/../routes/web.php';

// İstek yolunu yakala
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = rtrim($path, '/') ?: '/';

// Çalıştır
$router->dispatch($_SERVER['REQUEST_METHOD'], $path);
