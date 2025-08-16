<?php
class AuthController {
  private function render(string $view, array $vars = []): void {
    extract($vars);
    ob_start();
    include __DIR__ . '/../Views/' . $view . '.php';
    $content = ob_get_clean();
    $title = $title ?? 'sendekatilsana';
    include __DIR__ . '/../Views/layout.php';
  }

  public function showUserLogin(): void   { $title = 'Üye Girişi';  $this->render('auth/login-user', compact('title')); }
  public function showUserRegister(): void{ $title = 'Üye Kayıt';   $this->render('auth/register-user', compact('title')); }
}
