<?php
session_start();

require_once "connectDb.php" ;

$sql = "SELECT * FROM sac_onerileri";
$result = $conn->query($sql);


$dalgali_sac = [];


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row['sac_tipi'] == 'dalgalı') {
            $dalgali_sac[] = $row;
        }
    }
} else {
    $error_message = "Veri bulunamadı!";
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dalgalı Bakım</title>
	<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <script src="script.js" defer></script>
</head>
<body class="dalgali_bg">
	<?php include('menu.php'); ?>
	<div class="site-header">
        <a href="index.php" class="site-title">Güzellik Rehberi: Saç, Makyaj ve Cilt Bakımı İçin Öneriler</a>
    </div>
    <div class="content-detay">
        <h1>Dalgalı Saç Bakım Önerileri</h1>

        <?php if (isset($dalgali_sac) && !empty($dalgali_sac)): ?>
            <ul class="sac-onerileri-list">
                <?php foreach ($dalgali_sac as $oneriler): ?>
                    <li>
                        <a href="detay.php?sac_id=<?php echo $oneriler['sac_id']; ?>" class="oneriler-link">
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
