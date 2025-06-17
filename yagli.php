<?php
session_start();

require_once "connectDb.php" ;
$sql = "SELECT * FROM cilt_onerileri WHERE cilt_tipi = 'yağlı'";
$result = $conn->query($sql);

// Saç tiplerine göre önerileri depolamak için boş diziler
$yagli_cilt = [];

// Eğer veri varsa, her bir satırı kontrol et ve ilgili dizilere yerleştir
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $yagli_cilt[] = $row;
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
    <title>Yağlı Cilt Bakım Önerileri</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

    <script src="script.js" defer></script>
</head>
<body class="yagli_bg">
    <?php include('menu.php'); ?>
    <div class="site-header">
        <a href="index.php" class="site-title">Güzellik Rehberi: Saç, Makyaj ve Cilt Bakımı İçin Öneriler</a>
    </div>
    
    <div class="content-detay">
        <h1>Yağlı Cilt Bakım Önerileri</h1>

        <?php if (isset($yagli_cilt) && !empty($yagli_cilt)): ?>
            <ul class="sac-onerileri-list">
                <?php foreach ($yagli_cilt as $oneriler): ?>
                    <li>
                        <a href="detay.php?cilt_id=<?php echo $oneriler['cilt_id']; ?>" class="oneriler-link">
                            <?php echo htmlspecialchars($oneriler['baslik']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Öneri bulunamadı!</p>
        <?php endif; ?>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Güzellik Rehberi</p>
    </footer>
    <?php include('auth_form.php'); ?>
</body>
</html>
