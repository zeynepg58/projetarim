<?php 
include("baglanti.php");
session_start();

$giris = 0;

if(isset($_POST["email"]) && isset($_POST["parola"])){
    $email = $_POST["email"];
    $parola = md5($_POST["parola"]);

    // Kullanıcıyı e-posta ve parolaya göre sorgula
    $query = $baglanti->prepare("SELECT * FROM kullanicilar WHERE email = :email AND parola = :parola");
    $query->execute(array(":email" => $email, ":parola" => $parola));
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Kullanıcı tipine göre yönlendir
        if ($user["kullanici_tip"] == 0) {
            // Çiftçi ise
            $_SESSION["kullaniciBilgiler"] = $user;
            header("Location: ciftci-index.php");
        } else if ($user["kullanici_tip"] == 1) {
            // Alıcı ise
            $_SESSION["kullaniciBilgiler"] = $user;
            header("Location: alici-index.php");
        }
    } else {
        // Kullanıcı bulunamadı
        $giris = -1;
    }
}


?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş</title>
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="main">
    <div class="form-box">
        <form action="index.php" method="POST" id="Login" class="input-group">
            <input type="text" class="input-field" placeholder="E-Mail" name="email" required>
            <input type="password" class="input-field" placeholder="Password" name="parola" required>
        
            <a href="sifre-sifirla.php" class="forgot-password">Şifreni mi Unuttun?</a> 
            <button type="submit" class="submit-btn">Giriş Yap</button>
            <a href="kullanici_kayit.php" class="signup">Kayıt Ol</a> 
        </form>
    </div>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="public/js/index.js"></script>
</body>
</html>
