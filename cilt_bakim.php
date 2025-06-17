<?php
session_start();

require_once "connectDb.php" ;

$sql = "SELECT * FROM cilt_onerileri";
$result = $conn->query($sql);


$yagli_cilt = [];
$karma_cilt = [];
$kuru_cilt = [];


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['cilt_tipi'] == 'yağlı') {
            $yagli_cilt[] = $row;
        } elseif ($row['cilt_tipi'] == 'karma') {
            $karma_cilt[] = $row;
        } elseif ($row['cilt_tipi'] == 'kuru') {
            $kuru_cilt[] = $row;
        }
    }
} else {
    $error_message = "Veri bulunamadı!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saç Bakım</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <script src="script.js" defer></script>
</head>
<body class="cilt_bakim">
    <?php include('menu.php'); ?>

    <div class="site-header">
        <a href="index.php" class="site-title">Güzellik Rehberi: Saç, Makyaj ve Cilt Bakımı İçin Öneriler</a>
    </div>
    <div class="content">
        <div class="hair-section" id="yagli">
            <a href="yagli.php">
            <img src="images/yagli-cilt.jpg" alt="Yağlı Cilt" class="hair-section-img">
            <h2 class="hair-section-title">YAĞLI CİLT BAKIMI</h2>
            <p class="hair-description">Yağlı ciltler için etkili bakım önerileri ve doğru ürün seçimi hakkında bilgilere ulaşın.</p>
            </a>
        </div>
        <div class="hair-section" id="karma">
            <a href="karma.php">
            <img src="images/karma-cilt.jpg" alt="Karma Cilt" class="hair-section-img">
            <h2 class="hair-section-title">KARMA CİLT BAKIMI</h2>
            <p class="hair-description">Karma ciltler için dengeli bakım önerileri ve cildinizin ihtiyaçlarına yönelik ipuçları.</p>
            </a>
        </div>
        <div class="hair-section" id="kuru">
            <a href="kuru.php">
            <img src="images/kuru-cilt.jpg" alt="Kuru Cilt" class="hair-section-img">
            <h2 class="hair-section-title">KURU CİLT BAKIMI BAKIMI</h2>
            <p class="hair-description">Kuru ciltler için derinlemesine nemlendirici bakım ve cilt dostu ürün tavsiyeleri.</p>
            </a>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Güzellik Rehberi</p>
    </footer>
    <?php include('auth_form.php'); ?>
</body>
</html>
