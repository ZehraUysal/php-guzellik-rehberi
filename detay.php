<?php
session_start();

require_once "connectDb.php" ;

// Parametreleri ve tablo adlarını eşleştirme
$table_map = [
    'sac_id' => ['table' => 'sac_onerileri', 'favori_table' => 'sac_favoriler'],
    'makyaj_id' => ['table' => 'makyaj_onerileri', 'favori_table' => 'makyaj_favoriler'],
    'cilt_id' => ['table' => 'cilt_onerileri', 'favori_table' => 'cilt_favoriler']
];

$current_table = null;
$current_id = null;
$current_key = null;

foreach ($table_map as $key => $info) {
    if (isset($_GET[$key])) {
        $current_table = $info['table'];
        $favori_table = $info['favori_table'];
        $current_id = (int)$_GET[$key];
        $current_key = $key; // Dinamik sütun ismi
        break;
    }
}

// Geçersiz parametre kontrolü
if (!$current_table || !$current_id) {
    die("Geçersiz istek, gerekli parametre eksik!");
}

// Veritabanı sorgusu
$sql = "SELECT * FROM $current_table WHERE $current_key = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Sorgu hazırlama hatası: " . $conn->error);
}

$stmt->bind_param("i", $current_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $oneriler = $result->fetch_assoc();
} else {
    die("Bu ID ile ilgili öneri bulunamadı!");
}

// Favori kontrolü
$is_favori = false;
if (isset($_SESSION['kullanici_adi'])) {
    $kullanici_id = $_SESSION['kullanici_id'];
    $favori_sql = "SELECT * FROM $favori_table WHERE kullanici_id = ? AND $current_key = ?";
    $favori_stmt = $conn->prepare($favori_sql);
    if ($favori_stmt) {
        $favori_stmt->bind_param("ii", $kullanici_id, $current_id);
        $favori_stmt->execute();
        $favori_result = $favori_stmt->get_result();
        if ($favori_result->num_rows > 0) {
            $is_favori = true;
        }
    }
}

$icerik = $oneriler['icerik'];

// Vurgulamak istenilen kelimeler
$anahtar_kelime = ['doğal', 'bakım', 'etkili', 'güzel','ince','bukle','dalga'];

foreach ($anahtar_kelime as $kelime) {
    $icerik = str_replace($kelime, "<strong>$kelime</strong>", $icerik);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($oneriler['baslik'] ?? 'Öneri Detayı'); ?></title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <script src="script.js" defer></script>
</head>
<body class="detay">
    <?php include('menu.php'); ?>

    <header class="site-header">
        <a href="index.php" class="site-title">Güzellik Rehberi: Saç, Makyaj ve Cilt Bakımı İçin Öneriler</a>
    </header>

    <main class="content-container">
        <?php if (!empty($oneriler)) : ?>
            <div class="card">
                <div class="card-header">
                    <h1><?php echo htmlspecialchars($oneriler['baslik']); ?></h1>
                </div>
                <div class="card-body">
                    <p><?php echo nl2br($icerik); ?></p>
                </div>
                <div class="card-footer">
                    <?php if (isset($_SESSION['kullanici_adi'])): ?>
                        <button 
                            class="favori-btn <?php echo $is_favori ? 'active' : ''; ?>" 
                            data-id="<?php echo $current_id; ?>" 
                            data-type="<?php echo $current_key; ?>">
                            <?php echo $is_favori ? 'Favorilerden Çıkar' : 'Favorilere Ekle'; ?>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php else : ?>
            <div class="message-container">
                <p>İçerik bulunamadı veya yüklenirken bir hata oluştu.</p>
            </div>
        <?php endif; ?>
    </main>
    <footer class="footer">
        <p>&copy; 2024 Güzellik Rehberi</p>
    </footer>
    <?php include('auth_form.php'); ?>
</body>
</html>
