<?php
session_start();
header('Content-Type: application/json');

// Giriş kontrolü
if (!isset($_SESSION['kullanici_id'])) {
    echo json_encode(["success" => false, "message" => "Giriş yapmalısınız."]);
    exit;
}

$kullanici_id = $_SESSION['kullanici_id'];

// JSON formatında gelen veriyi alıyoruz
$data = json_decode(file_get_contents("php://input"), true);

// Gelen parametreleri al
$id = isset($data['id']) ? (int)$data['id'] : null;
$type = isset($data['type']) ? $data['type'] : null;
$action = isset($data['action']) ? $data['action'] : null;

// Favori tablosu eşlemesi
$table_map = [
    'sac_id' => 'sac_favoriler',
    'makyaj_id' => 'makyaj_favoriler',
    'cilt_id' => 'cilt_favoriler'
];

// Geçerli parametrelerin kontrolü
if (!array_key_exists($type, $table_map) || !$id) {
    echo json_encode(["success" => false, "message" => "Geçersiz istek."]);
    exit;
}

// Veritabanı bağlantısı
require_once 'connectDb.php'; // Artık burada şifre yazmana gerek yok

// Favori tablosunu seçiyoruz
$favori_table = $table_map[$type];

// Favori durumunu kontrol et
$check_sql = "SELECT * FROM $favori_table WHERE kullanici_id = ? AND {$type} = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $kullanici_id, $id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

// Eğer favori zaten ekliyse, çıkarma işlemi yapılacak, değilse ekleme işlemi yapılacak
if ($check_result->num_rows > 0) {
    // Favoriden çıkarma
    $sql = "DELETE FROM $favori_table WHERE kullanici_id = ? AND {$type} = ?";
    $action = 'remove';
} else {
    // Favoriye ekleme
    $sql = "INSERT INTO $favori_table (kullanici_id, {$type}, eklenme_tarihi) VALUES (?, ?, NOW())";
    $action = 'add';
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $kullanici_id, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "action" => $action]);
} else {
    echo json_encode(["success" => false, "message" => "Veritabanı hatası: " . $conn->error]);
}

$conn->close();
?>
