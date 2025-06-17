<?php
session_start();


if (!isset($_SESSION['kullanici_adi'])) {
    header("Location: index.php");
    exit();
}

$kullanici_id = $_SESSION['kullanici_id'];

require_once "connectDb.php" ;


$favoriler_var_mi = false;

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorilerim</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
 
</head>
<body class="favori_bg">
	<?php include('menu.php'); ?>
    <div class="site-header">
        <a href="index.php" class="site-title">Güzellik Rehberi: Saç, Makyaj ve Cilt Bakımı İçin Öneriler</a>
    </div>
    <header>
        <h1>Favorilerim</h1>
    </header>
    <main>
        <div class="favoriler-container">
            <?php
            
            $sql_sac = "SELECT sac_onerileri.baslik, sac_onerileri.sac_id 
                        FROM sac_favoriler 
                        JOIN sac_onerileri ON sac_favoriler.sac_id = sac_onerileri.sac_id 
                        WHERE sac_favoriler.kullanici_id = ?";
            $stmt_sac = $conn->prepare($sql_sac);
            $stmt_sac->bind_param("i", $kullanici_id);
            $stmt_sac->execute();
            $result_sac = $stmt_sac->get_result();

            if ($result_sac->num_rows > 0) {
                $favoriler_var_mi = true;
                echo "<h2>Saç Favorileri</h2>";
                while ($row = $result_sac->fetch_assoc()) {
                    echo "<div class='favori-item'>
                            <a href='detay.php?sac_id=" . $row['sac_id'] . "'>" . htmlspecialchars($row['baslik']) . "</a>
                          </div>";
                }
            }

            
            $sql_makyaj = "SELECT makyaj_onerileri.baslik, makyaj_onerileri.makyaj_id 
                           FROM makyaj_favoriler 
                           JOIN makyaj_onerileri ON makyaj_favoriler.makyaj_id = makyaj_onerileri.makyaj_id 
                           WHERE makyaj_favoriler.kullanici_id = ?";
            $stmt_makyaj = $conn->prepare($sql_makyaj);
            $stmt_makyaj->bind_param("i", $kullanici_id);
            $stmt_makyaj->execute();
            $result_makyaj = $stmt_makyaj->get_result();

            if ($result_makyaj->num_rows > 0) {
                $favoriler_var_mi = true;
                echo "<h2>Makyaj Favorileri</h2>";
                while ($row = $result_makyaj->fetch_assoc()) {
                    echo "<div class='favori-item'>
                            <a href='detay.php?makyaj_id=" . $row['makyaj_id'] . "'>" . htmlspecialchars($row['baslik']) . "</a>
                          </div>";
                }
            }

           
            $sql_cilt = "SELECT cilt_onerileri.baslik, cilt_onerileri.cilt_id 
                         FROM cilt_favoriler 
                         JOIN cilt_onerileri ON cilt_favoriler.cilt_id = cilt_onerileri.cilt_id 
                         WHERE cilt_favoriler.kullanici_id = ?";
            $stmt_cilt = $conn->prepare($sql_cilt);
            $stmt_cilt->bind_param("i", $kullanici_id);
            $stmt_cilt->execute();
            $result_cilt = $stmt_cilt->get_result();

            if ($result_cilt->num_rows > 0) {
                $favoriler_var_mi = true;
                echo "<h2>Cilt Favorileri</h2>";
                while ($row = $result_cilt->fetch_assoc()) {
                    echo "<div class='favori-item'>
                            <a href='detay.php?cilt_id=" . $row['cilt_id'] . "'>" . htmlspecialchars($row['baslik']) . "</a>
                          </div>";
                }
            }

            
            if (!$favoriler_var_mi) {
                echo "<p class='message'>Favorileriniz bulunmamaktadır.</p>";
            }
            ?>
        </div>
    </main>
    <footer class="footer">
        <p>&copy; 2024 Güzellik Rehberi</p>
    </footer>
    <?php include('auth_form.php'); ?>
</body>
</html>
