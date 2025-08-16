<h2>Üye Kayıt</h2>
<p class="sub">1 dakikada hesabını oluştur.</p>
<form method="post" action="/kayit/uye" autocomplete="on">
  <label>Ad Soyad</label>
  <input type="text" name="name" required>
  <label>Kullanıcı Adı</label>
  <input type="text" name="username" required>
  <label>E-posta</label>
  <input type="email" name="email" required>
  <label>Şifre (min 8)</label>
  <input type="password" name="password" minlength="8" required>
  <label><input type="checkbox" name="kvkk" required> KVKK metnini onaylıyorum</label>
  <button class="mt" type="submit">Kayıt Ol</button>
  <div class="helper">Hesabın var mı? <a class="link" href="/giris/uye">Giriş yap</a></div>
</form>
