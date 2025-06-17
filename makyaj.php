<?php
session_start();
require_once "connectDb.php" ;
$sql = "SELECT * FROM makyaj_onerileri";
$result = $conn->query($sql);


$gece_makyaj = [];
$gunluk_makyaj = [];
$dogal_makyaj = [];


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['makyaj_tipi'] == 'gece') {
            $gece_makyaj[] = $row;
        } elseif ($row['makyaj_tipi'] == 'günlük') {
            $gunluk_makyaj[] = $row;
        } elseif ($row['makyaj_tipi'] == 'doğal') {
            $dogal_makyaj[] = $row;
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
<body class="makyaj_bakim">
    <?php include('menu.php'); ?>

    <div class="site-header">
        <a href="index.php" class="site-title">Güzellik Rehberi: Saç, Makyaj ve Cilt Bakımı İçin Öneriler</a>
    </div>
    <div class="content">
        <div class="hair-section" id="gece">
            <a href="gece.php">
            <img src="images/gece-makyaj.jpg" alt="Kıvırcık Saç" class="hair-section-img">
            <h2 class="hair-section-title">GECE MAKYAJI</h2>
             <p class="hair-description">Gece dışarı çıkarken cildinizi ışıldatan, uzun süre kalıcı makyaj tüyoları ve teknikleri.</p>
            </a>
        </div>
        <div class="hair-section" id="gunluk">
            <a href="gunluk.php">
            <img src="images/gunluk-makyaj.jpg" alt="Dalgalı Saç" class="hair-section-img">
            <h2 class="hair-section-title">GÜNLÜK MAKYAJ</h2>
            <p class="hair-description">Pratik ve doğal bir günlük makyaj rutini oluşturmanıza yardımcı olacak öneriler.</p>
            </a>
        </div>
        <div class="hair-section" id="dogal">
            <a href="dogal.php">
            <img src="images/dogal-makyaj.jpg" alt="Düz Saç" class="hair-section-img">
            <h2 class="hair-section-title">DOĞAL MAKYAJ</h2>
            <p class="hair-description">Yüz hatlarınızı ön plana çıkaran ve doğal bir görünüm sağlayan makyaj ipuçları.</p>
            </a>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Güzellik Rehberi</p>
    </footer>
    <?php include('auth_form.php'); ?>
</body>
</html>
