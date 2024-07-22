<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\uyelik\PHPMailer\src\Exception.php';
require 'C:/xampp/htdocs/uyelik/PHPMailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/uyelik/PHPMailer/src/SMTP.php';

include("baglanti.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];

    // E-posta adresiyle kayıtlı kullanıcıyı bulun
    $query = $baglanti->prepare("SELECT * FROM kullanicilar WHERE email = ?");
    $query->execute([$email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        // Rastgele bir şifre oluşturun
        $newPassword = generateRandomPassword(); // Özelleştirmeniz gerekebilir

        // Yeni şifreyi veritabanına kaydedin
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery = $baglanti->prepare("UPDATE kullanicilar SET parola = ? WHERE email = ?");
        $updateQuery->execute([$hashedNewPassword, $email]);

        // Kullanıcıya yeni şifresini e-posta ile gönderin (örnek olarak SwiftMailer gibi bir e-posta kütüphanesi kullanabilirsiniz)

        // Kullanıcıyı bilgilendirin
        echo '<div class="alert alert-success" role="alert">Yeni şifre e-posta adresinize gönderildi.</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Bu e-posta adresiyle kayıtlı kullanıcı bulunamadı.</div>';
    }
} 

function generateRandomPassword($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <form action="sifre-sifirla.php" method="POST" id="SifreSifirla" class="input-group">
    <input type="text" class="input-field" placeholder="E-Mail" name="email" required>
    <button type="submit" class="submit-btn">Şifremi Sıfırla</button>
</form>

</head>
<body>
    
</body>
</html>