<h2 style="margin:0 0 8px 0">Admin Giriş</h2>
<p class="muted" style="margin:0 0 12px 0">Devam etmek için giriş yapın.</p>
<?php if (!empty($error)): ?>
  <div class="alert"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="post" action="<?= htmlspecialchars($panelPath) ?>/giris" autocomplete="on">
  <label>Kullanıcı Adı</label>
  <input type="text" name="username" required>
  <label>Şifre</label>
  <input type="password" name="password" required>
  <button class="mt" type="submit">Giriş Yap</button>
</form>
