<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>


<nav class="navbar navbar-expand-lg bg-body-tertiary  navbar bg-dark" data-bs-theme="dark" >
  <div class="container">
  <a class="navbar-brand" href="#">
  <span class="navbar-brand-text">ALİCİ ANA SAYFA</span>
</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="alici-index.php">Sayfam</a>
        <a class="nav-link" href="#">Mesajlar</a>
        <a class="nav-link" href="alici-iletisim.php">İletişim</a>
      </div>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="alici-profil.php">Profil</a>
      </div>
    </div>
  </div>
</nav>

<?php
include("baglanti.php");

session_start();
$kullaniciBilgiler = $_SESSION["kullaniciBilgiler"];

// Kullanıcının ID'sini oturum bilgisinden alıyoruz
if (isset($kullaniciBilgiler)) {
    $id = $kullaniciBilgiler["id"];

    // Kullanıcı bilgilerini veritabanından çekiyoruz
    $query = $baglanti->prepare("SELECT email, ad, soyad, tel_no FROM kullanicilar WHERE id = :id");
    $query->bindValue(':id', $id);
    $query->execute();
    $kullanici = $query->fetch(PDO::FETCH_ASSOC);

    // Kullanıcı bilgilerini ekrana yazdırıyoruz
   
    $email = $kullanici['email'];
    $ad = $kullanici['ad'];
    $soyad = $kullanici['soyad'];
    $tel_no = $kullanici['tel_no'];

    // Formu gösteriyoruz
    ?>

    <div class="container pt-5">
    <form method="POST" action="profil.php">
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
        </div>

        <div class="mb-3">
            <label for="ad" class="form-label">Adı</label>
            <input type="text" class="form-control" id="ad" name="ad" value="<?php echo $ad; ?>">
        </div>

        <div class="mb-3">
            <label for="soyad" class="form-label">Soyadı</label>
            <input type="text" class="form-control" id="soyad" name="soyad" value="<?php echo $soyad; ?>">
        </div>


        <div class="mb-3">
            <label for="tel_no" class="form-label">Telefon Numarası</label>
            <input type="number" class="form-control" id="tel_no" name="tel_no" value="<?php echo $tel_no; ?>">
        </div>

        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>
</div>
    <?php

} else {
    echo "Kullanıcı oturumu bulunamadı."; // Kullanıcı oturumu yoksa hata mesajını ekrana yazdırıyoruz
}

?>




</body>
</html>