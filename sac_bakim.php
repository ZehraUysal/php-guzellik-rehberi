<?php
session_start();

require_once "connectDb.php" ;

$sql = "SELECT * FROM sac_onerileri";
$result = $conn->query($sql);

// Saç tiplerine göre önerileri depolamak için boş diziler
$kivircik_sac = [];
$dalgali_sac = [];
$duz_sac = [];

// Eğer veri varsa, her bir satırı kontrol et ve ilgili dizilere yerleştir
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['sac_tipi'] == 'kıvırcık') {
            $kivircik_sac[] = $row;
        } elseif ($row['sac_tipi'] == 'dalgalı') {
            $dalgali_sac[] = $row;
        } elseif ($row['sac_tipi'] == 'düz') {
            $duz_sac[] = $row;
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
<body class="sac_bakim">
    <?php include('menu.php'); ?>

    <div class="site-header">
        <a href="index.php" class="site-title">Güzellik Rehberi: Saç, Makyaj ve Cilt Bakımı İçin Öneriler</a>
    </div>
<div class="content">
    <div class="hair-section">
        <a href="kivircik.php">
            <img src="images/kivircik-sac.jpg" alt="Kıvırcık Saç" class="hair-section-img">
            <h2 class="hair-section-title">KIVIRCIK SAÇ BAKIMI</h2>
            <p class="hair-description">Canlı bukleler için özel bakım önerileri, doğru nemlendirme ve stil tüyolarını keşfedin.</p>
        </a>
    </div>

    <div class="hair-section">
        <a href="dalgali.php">
            <img src="images/dalgali-sac.jpg" alt="Dalgalı Saç" class="hair-section-img">
            <h2 class="hair-section-title">DALGALI SAÇ BAKIMI</h2>
            <p class="hair-description">Dalgalı saçlarınız için etkili şampuan ve şekillendirme önerileri burada!</p>
        </a>
    </div>

    <div class="hair-section">
        <a href="duz.php">
            <img src="images/duz-sac.jpg" alt="Düz Saç" class="hair-section-img">
            <h2 class="hair-section-title">DÜZ SAÇ BAKIMI</h2>
            <p class="hair-description">Pürüzsüz ve parlak düz saçlar için ideal bakım önerilerini okuyun.</p>
        </a>
    </div>
</div>
    <footer class="footer">
        <p>&copy; 2024 Güzellik Rehberi</p>
    </footer>
    <?php include('auth_form.php'); ?>
</body>
</html>