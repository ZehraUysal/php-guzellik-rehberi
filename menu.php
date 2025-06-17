<nav>
    <ul>
        <li><a href="index.php">Anasayfa</a></li>
        <li class="dropdown">
            <a href="sac_bakim.php">Saç Bakım</a>
            <ul class="dropdown-menu">
                <li><a href="kivircik.php?kategori=kivircik">Kıvırcık</a></li>
                <li><a href="duz.php?kategori=duz">Düz</a></li>
                <li><a href="dalgali.php?kategori=dalgalı">Dalgalı</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="cilt_bakim.php">Cilt Bakım</a>
            <ul class="dropdown-menu">
                <li><a href="yagli.php?kategori=yagli">Yağlı</a></li>
                <li><a href="kuru.php?kategori=kuru">Kuru</a></li>
                <li><a href="karma.php?kategori=karma">Karma</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="makyaj.php">Makyaj</a>
            <ul class="dropdown-menu">
                <li><a href="gunluk.php?kategori=gunluk">Günlük</a></li>
                <li><a href="gece.php?kategori=gece">Gece</a></li>
                <li><a href="dogal.php?kategori=dogal">Doğal</a></li>
            </ul>
        </li>
        <li><a href="forum.php">Forum</a></li>
        <?php if (isset($_SESSION['kullanici_adi'])): ?>
            <li><a href="favoriler.php">Favoriler</a></li>
        <?php endif; ?>
    </ul>
    <div class="user-controls">
        <?php if (isset($_SESSION['kullanici_adi'])): ?>
            <span>Hoşgeldiniz, <?php echo htmlspecialchars($_SESSION['kullanici_adi']); ?></span>
            <a href="auth.php?logout=true" class="button">Çıkış Yap</a>
        <?php else: ?>
            <button id="loginButton">Giriş Yap</button>
        <?php endif; ?>
    </div>
</nav>
