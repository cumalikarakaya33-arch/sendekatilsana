<?php
class AdminController {
  private function settings(): array {
    $file = __DIR__ . '/../../config/admin.php';
    return file_exists($file) ? require $file : ['panel_code'=>'dev','ip_whitelist'=>[]];
  }
  private function panelPath(): string {
    $s = $this->settings();
    return '/_panel-' . ($s['panel_code'] ?? 'dev');
  }
  private function isLoggedIn(): bool {
    return !empty($_SESSION['admin_ok']);
  }
  private function guard(): void {
    // IP kısıtı
    $s = $this->settings();
    $ips = $s['ip_whitelist'] ?? [];
    if (!empty($ips)) {
      $ip = $_SERVER['REMOTE_ADDR'] ?? '';
      if (!in_array($ip, $ips, true)) { http_response_code(404); exit('404 Not Found'); }
    }
    // Giriş kontrolü
    if (!$this->isLoggedIn()) {
      header('Location: '.$this->panelPath().'/giris');
      exit;
    }
  }
  private function render(string $view, array $vars = []): void {
    extract($vars);
    ob_start();
    include __DIR__ . '/../Views/' . $view . '.php';
    $content = ob_get_clean();
    $title = $title ?? 'Admin';
    $panelPath = $this->panelPath();
    // admin görünümü mü? => admin/layout.php kullan
    $isAdminView = (strpos($view, 'admin/') === 0);
    include __DIR__ . '/../Views/' . ($isAdminView ? 'admin/layout.php' : 'layout.php');
  }

  // ---------- Sayfalar ----------
  public function showLogin(): void {
    if ($this->isLoggedIn()) { header('Location: '.$this->panelPath()); exit; }
    $title = 'Admin Giriş';
    $panelPath = $this->panelPath();
    $hideNav = true; // login ekranında üst menüyü gizle
    $this->render('admin/login', compact('title','panelPath','hideNav'));
  }
  public function login(): void {
    $s = $this->settings();
    $u = trim($_POST['username'] ?? '');
    $p = (string)($_POST['password'] ?? '');
    $ok = ($u === ($s['admin_username'] ?? '')) && password_verify($p, $s['admin_password_hash'] ?? '');
    if ($ok) {
      $_SESSION['admin_ok'] = true;
      header('Location: '.$this->panelPath());
      exit;
    }
    $title = 'Admin Giriş';
    $panelPath = $this->panelPath();
    $hideNav = true;
    $error = 'Hatalı kullanıcı adı veya şifre';
    $this->render('admin/login', compact('title','panelPath','hideNav','error'));
  }
  public function logout(): void {
    unset($_SESSION['admin_ok']);
    header('Location: '.$this->panelPath().'/giris');
    exit;
  }
  public function dashboard(): void {
    $this->guard();
    $title = 'Admin Paneli';
    $panelPath = $this->panelPath();
    $this->render('admin/index', compact('title','panelPath'));
  }
}
