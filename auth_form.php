<?php if (!isset($_SESSION['kullanici_adi'])): ?>
<div id="authModal" class="modal">
    <div class="modal-content">
        <!-- Kapatma Butonu -->
        <span class="close" id="closeModal">&times;</span>
        
        <div id="authForms">
            <!-- Giriş Formu -->
            <div id="loginForm">
                <h2>Giriş Yap</h2>
                <form method="POST" action="auth.php">
                    <input type="text" name="kullanici_adi" placeholder="Kullanıcı Adı" required>
                    <input type="password" name="sifre" placeholder="Şifre" required>
                    <button type="submit" name="login" class="button">Giriş Yap</button>
                    <!-- Giriş hataları burada görünecek -->
                    <?php if (isset($_GET['error'])): ?>
                        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
                    <?php endif; ?>
                    <p>Hesabınız yok mu? <a href="#" id="registerSwitch">Kayıt Ol</a></p>
                </form>
            </div>

            <!-- Kayıt Formu -->
            <div id="registerForm" style="display: none;">
                <h2>Kayıt Ol</h2>
                <form method="POST" action="auth.php">
                    <input type="text" name="kullanici_adi" placeholder="Kullanıcı Adı" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="sifre" placeholder="Şifre" required>
                    <button type="submit" name="register" class="button">Kayıt Ol</button>
                </form>
                <p>Zaten bir hesabınız var mı? <a href="#" id="loginSwitch">Giriş Yap</a></p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

