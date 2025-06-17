<?php
session_start();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Güzellik Rehberi</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <script src="script.js" defer></script>
</head>
<body class="index_bg">
    <!-- Üst Menü -->
<?php include('menu.php'); ?>
    <div class="site-header">
        <a href="index.php" class="site-title">Güzellik Rehberi: Saç, Makyaj ve Cilt Bakımı İçin Öneriler</a>
    </div>
 <!-- İçerik Kısımları -->
    <div class="content-sections">
        <!-- Saç Bakım -->
        <div class="section-div" id="sacBakim">
            <a href="sac_bakim.php">
               <img src="images/sac.jpg" alt="Saç Bakım" class="section-image">
               <h2 class="section-title">SAÇ BAKIM</h2>
            </a>
        </div>

        
        <!-- Cilt Bakım -->
        <div class="section-div" id="ciltBakim">
            <a href="cilt_bakim.php">
            <img src="images/cilt.jpg" alt="Cilt Bakım" class="section-image">
            <h2 class="section-title">CİLT BAKIM</h2>
            </a>
        </div>

        <!-- Makyaj -->
        <div class="section-div" id="makyaj">
            <a href="makyaj.php">
            <img src="images/makyaj.jpg" alt="Makyaj" class="section-image">
            <h2 class="section-title">MAKYAJ</h2>
            </a>
        </div>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Güzellik Rehberi</p>
    </footer>
<?php include('auth_form.php'); ?>

</body>
</html>
