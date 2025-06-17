<?php
session_start();

require_once "connectDb.php" ;

$sql = "SELECT * FROM makyaj_onerileri WHERE makyaj_tipi = 'doğal'";
$result = $conn->query($sql);


$dogal_makyaj = [];


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $dogal_makyaj[] = $row;
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
    <title>Doğal Makyaj Önerileri</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <script src="script.js" defer></script>
</head>
<body class="dogal_bg">
    <?php include('menu.php'); ?>
    <div class="site-header">
        <a href="index.php" class="site-title">Güzellik Rehberi: Saç, Makyaj ve Cilt Bakımı İçin Öneriler</a>
    </div>
    
    <div class="content-detay">
        <h1>Doğal Makyaj Önerileri</h1>

        <?php if (isset($dogal_makyaj) && !empty($dogal_makyaj)): ?>
            <ul class="sac-onerileri-list">
                <?php foreach ($dogal_makyaj as $oneriler): ?>
                    <li>
                        <a href="detay.php?makyaj_id=<?php echo $oneriler['makyaj_id']; ?>" class="oneriler-link">
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
