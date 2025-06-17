<?php
session_start();


require_once "connectDb.php" ;

if (isset($_GET['logout'])) {
    session_destroy();
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'; 
    header("Location: $referer?success_logout=Çıkış başarılı!");
    exit();
}


if (isset($_POST['register'])) {
    $kullanici_adi = $_POST['kullanici_adi'];
    $email = $_POST['email'];
    $sifre = password_hash($_POST['sifre'], PASSWORD_DEFAULT);

    
    $checkUser = $conn->query("SELECT * FROM kullanicilar WHERE kullanici_adi = '$kullanici_adi'");
    if ($checkUser->num_rows > 0) {
        $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
        header("Location: $redirectUrl?error_register=Kullanıcı adı zaten alınmış!");
        exit();
    }

    
    $sql = "INSERT INTO kullanicilar (kullanici_adi, email, sifre) VALUES ('$kullanici_adi', '$email', '$sifre')";
    if ($conn->query($sql) === TRUE) {
        $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
        header("Location: $redirectUrl?success_register=Kayıt başarılı! Giriş yapabilirsiniz.");
    } else {
        $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
        header("Location: $redirectUrl?error_register=Kayıt sırasında bir hata oluştu.");
    }
    exit();
}


if (isset($_POST['login'])) {
    $kullanici_adi = $_POST['kullanici_adi'];
    $sifre = $_POST['sifre'];

    
    $sql = "SELECT * FROM kullanicilar WHERE kullanici_adi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kullanici_adi);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($sifre, $row['sifre'])) {
            $_SESSION['kullanici_adi'] = $row['kullanici_adi'];
            $_SESSION['kullanici_id'] = $row['kullanici_id'];
            session_regenerate_id(true); 
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php'; 
            header("Location: $referer?success_login=Giriş başarılı!");
            exit();
        } else {
            $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
            header("Location: $redirectUrl?error_login=Şifre yanlış!");
            exit();
        }
    } else {
        $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
        header("Location: $redirectUrl?error_login=Kullanıcı bulunamadı!");
        exit();
    }
}

$conn->close();
?>
