<?php
session_start();
require_once "connectDb.php" ;

header('Content-Type: application/json');

// Konu başlığını ve açıklamasını POST ile alıyoruz
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $konu_baslik = $_POST['konu_baslik'];
    $konu_aciklama = $_POST['konu_aciklama'];
    $kullanici_id = $_SESSION['kullanici_id'];

    $sql = "INSERT INTO forum_konulari (konu_baslik, konu_aciklama, kullanici_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Sorgu hazırlanırken hata oluştu: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param("ssi", $konu_baslik, $konu_aciklama, $kullanici_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Konu başarıyla eklendi!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Sorgu çalıştırılırken hata oluştu: ' . $stmt->error]);
    }
    exit();
}
?>
