<?php
session_start();
require_once "connectDb.php" ;
$konu_id = isset($_GET['konu_id']) ? intval($_GET['konu_id']) : 0;


$sql = "SELECT konu_baslik, konu_aciklama FROM forum_konulari WHERE konu_id = $konu_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Konu bulunamadı.");
}

$konu = $result->fetch_assoc();


$yorum_sql = "
    SELECT 
        y.yorum_id,
        y.yorum_metni, 
        y.yorum_tarihi, 
        k.kullanici_adi, 
        k.kullanici_id 
    FROM 
        forum_yorumlari y 
    INNER JOIN 
        kullanicilar k 
    ON 
        y.kullanici_id = k.kullanici_id 
    WHERE 
        y.konu_id = $konu_id 
    ORDER BY 
        y.yorum_tarihi DESC";
$yorum_result = $conn->query($yorum_sql);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['kullanici_id'])) {
    if (isset($_POST['yorum_id'])) {
        
        $yorum_id = intval($_POST['yorum_id']);
        $yorum_metni = $conn->real_escape_string($_POST['yorum_metni']);
        $kullanici_id = intval($_SESSION['kullanici_id']);

        if (!empty($yorum_metni)) {
            $update_sql = "UPDATE forum_yorumlari SET yorum_metni = '$yorum_metni' WHERE yorum_id = $yorum_id AND kullanici_id = $kullanici_id";
            $conn->query($update_sql);
            header("Location: forum_detay.php?konu_id=$konu_id");
            exit();
        }
    } else {
        
        $yorum_metni = $conn->real_escape_string($_POST['yorum_metni']);
        $kullanici_id = intval($_SESSION['kullanici_id']);

        if (!empty($yorum_metni)) {
            $insert_sql = "INSERT INTO forum_yorumlari (konu_id, kullanici_id, yorum_metni) VALUES ($konu_id, $kullanici_id, '$yorum_metni')";
            $conn->query($insert_sql);
            header("Location: forum_detay.php?konu_id=$konu_id");
            exit();
        }
    }
}


if (isset($_GET['sil_yorum_id']) && isset($_SESSION['kullanici_id'])) {
    $sil_yorum_id = intval($_GET['sil_yorum_id']);
    $kullanici_id = intval($_SESSION['kullanici_id']);

   
    $sil_sql = "SELECT kullanici_id FROM forum_yorumlari WHERE yorum_id = $sil_yorum_id";
    $sil_result = $conn->query($sil_sql);

    if ($sil_result->num_rows > 0) {
        $yorum = $sil_result->fetch_assoc();
        if ($yorum['kullanici_id'] == $kullanici_id) {
           
            $delete_sql = "DELETE FROM forum_yorumlari WHERE yorum_id = $sil_yorum_id";
            $conn->query($delete_sql);
            header("Location: forum_detay.php?konu_id=$konu_id");
            exit();
        }
    }
}


$yorum_id_guncelle = isset($_GET['guncelle_yorum_id']) ? intval($_GET['guncelle_yorum_id']) : 0;
$yorum_metni_guncelle = '';
if ($yorum_id_guncelle) {
    $yorum_guncelle_sql = "SELECT yorum_metni FROM forum_yorumlari WHERE yorum_id = $yorum_id_guncelle AND kullanici_id = " . $_SESSION['kullanici_id'];
    $guncelle_result = $conn->query($yorum_guncelle_sql);

    if ($guncelle_result->num_rows > 0) {
        $yorum = $guncelle_result->fetch_assoc();
        $yorum_metni_guncelle = $yorum['yorum_metni'];
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($konu['konu_baslik']); ?></title>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include('menu.php'); ?>
    <div class="forum-detail-container">
        <h2><?php echo htmlspecialchars($konu['konu_baslik']); ?></h2>
        <p><?php echo nl2br(htmlspecialchars($konu['konu_aciklama'])); ?></p>

        <h3>Yorumlar</h3>
        <div class="yorumlar">
            <?php
            if ($yorum_result->num_rows > 0) {
    while ($yorum = $yorum_result->fetch_assoc()) {
        echo "<div class='yorum'>";
        
        echo "<div class='sol-taraf'>";
        echo "<p><strong>" . htmlspecialchars($yorum['kullanici_adi']) . ":</strong> " . htmlspecialchars($yorum['yorum_metni']) . "</p>";
        echo "<span class='tarih'>" . htmlspecialchars($yorum['yorum_tarihi']) . "</span>";
        echo "</div>";

        echo "<div class='sag-taraf'>";
        if (isset($_SESSION['kullanici_id']) && $_SESSION['kullanici_id'] == $yorum['kullanici_id']) {
            echo "<a href='forum_detay.php?konu_id=$konu_id&sil_yorum_id=" . $yorum['yorum_id'] . "' class='sil-yorum'>Yorumu Sil</a>";
            echo "<a href='forum_detay.php?konu_id=$konu_id&guncelle_yorum_id=" . $yorum['yorum_id'] . "' class='guncelle-yorum'>Yorumu Güncelle</a>";
        }
        echo "</div>";
        
        echo "</div>";
    }

            } else {
                echo "<p>Henüz yorum yapılmamış.</p>";
            }
            ?>
        </div>

        <?php if (isset($_SESSION['kullanici_id'])): ?>
            <form action="" method="post" class="yorum-form">
                <textarea name="yorum_metni" rows="4" placeholder="Yorumunuzu yazın..." required><?php echo htmlspecialchars($yorum_metni_guncelle); ?></textarea>
                <?php if ($yorum_id_guncelle): ?>
                    <input type="hidden" name="yorum_id" value="<?php echo $yorum_id_guncelle; ?>">
                    <button type="submit">Yorum Güncelle</button>
                <?php else: ?>
                    <button type="submit">Yorum Yap</button>
                <?php endif; ?>
            </form>
        <?php else: ?>
            <p>Yorum yapabilmek için giriş yapmalısınız</p>
        <?php endif; ?>
    </div>
    <footer class="footer">
        <p>&copy; 2024 Güzellik Rehberi</p>
    </footer>
    <?php include('auth_form.php'); ?>
</body>
</html>
