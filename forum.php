<?php
session_start();

require_once "connectDb.php" ;

$sql = "SELECT * FROM forum_konulari";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body class="forum-page">
    <?php include('menu.php'); ?>
    <div class="site-header">
        <a href="index.php" class="site-title">Güzellik Rehberi: Saç, Makyaj ve Cilt Bakımı İçin Öneriler</a>
    </div>
    <div class="forum-container">
        <h2>FORUM KONULARI</h2>
        <?php
        if ($result->num_rows == 0) {
            echo "<p class='no-topics'>Forumda henüz konu yok!</p>";
        } else {
            echo "<div class='forum-topics'>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='forum-topic'>";
                echo "<h3><a href='forum_detay.php?konu_id=" . $row['konu_id'] . "'>" . htmlspecialchars($row['konu_baslik']) . "</a></h3>";
                echo "</div>";
            }
            echo "</div>";
        }

        if (isset($_SESSION['kullanici_adi'])) {
            echo "<a href='forum_konu_ekle.php' class='konu-ekle-btn'>Yeni Konu Ekle</a>";
        }
        ?>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Güzellik Rehberi</p>
    </footer>
<?php include('auth_form.php'); ?>
</body>
</html>
