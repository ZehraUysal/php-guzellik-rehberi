<?php
session_start();
require_once "connectDb.php" ;
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Konu Ekle</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include('menu.php'); ?>
    
    <div class="konu-ekle-container">
<h2>Yeni Konu Ekle</h2>

<form class="konu-ekle-form">
    <div class="form-group">
        <label for="konu_baslik">Konu Başlığı:</label>
        <input type="text" name="konu_baslik" id="konu_baslik" required>
    </div>

    <div class="form-group">
        <label for="konu_aciklama">Konu Açıklaması:</label>
        <textarea name="konu_aciklama" id="konu_aciklama" required></textarea>
    </div>

    <button type="submit" class="submit-btn">Konuyu Ekle</button>
</form>


    </div>
    <footer class="footer">
        <p>&copy; 2024 Güzellik Rehberi</p>
    </footer>
    <?php include('auth_form.php'); ?>
    <script src="script.js?v=<?php echo time(); ?>"></script>
</body>
</html>

