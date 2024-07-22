
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Düzenle</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
</head>
<body>


<nav class="navbar navbar-expand-lg bg-body-tertiary  navbar bg-dark" data-bs-theme="dark" >
  <div class="container">
    <a class="navbar-brand" href="#">ÇİFTÇİ ANA SAYFA</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="ciftci-index.php">Sayfam</a>
        <a class="nav-link" href="#">Mesajlar</a>
        <a class="nav-link" href="iletisim.php">İletişim</a>
      </div>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="profil.php">Profil</a>
      </div>
    </div>
  </div>
</nav>
    


<?php
session_start();
include("baglanti.php");


// Değişkenleri başlangıçta boş olarak tanımlayın
$tarla_adi = "";
$tarla_adresi = "";
$il = "";
$ilce = "";
$ada = "";
$pafta = "";
$tarla_gorseli = "";
$yuzolcumu ="";
$tapu_tip ="" ;
$ts_ad_soyad = "";
$ad_soyad = "";

if (isset($_GET['tarla_id'])) {
  $tarlaID = $_GET['tarla_id'];

    try {
        // Veritabanından kaydı çekme
        $query = $baglanti->prepare("SELECT tarla_adi, tarla_adresi, il, ilce, ada, pafta, tarla_gorseli, yuzolcumu, tapu_tip, ts_ad_soyad, ad_soyad  FROM tarlalar WHERE id = :id");
        $query->bindValue(':id', $tarlaID);
        $query->execute();
      
        if ($query->rowCount() > 0) {
            // Kayıt bulundu
            $row = $query->fetch(PDO::FETCH_ASSOC);
            // Mevcut tarla görselini çek
             $gorselYolu = $row['tarla_gorseli'];
             $tarla_adi = $row['tarla_adi'];
             $tarla_adresi = $row['tarla_adresi'];
             $il = $row['il'];
             $ilce = $row['ilce'];
             $ada = $row['ada'];
             $pafta = $row['pafta'];
             $tarla_gorseli = $row['tarla_gorseli'];
             $yuzolcumu =$row["yuzolcumu"];
             $tapu_tip =$row["tapu_tip"];
             $ts_ad_soyad = $row['ts_ad_soyad'];
             $ad_soyad = $row['ad_soyad'];
    
        } else {
            // Kayıt bulunamadı
            echo "Kayıt bulunamadı.";
        }
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Formdan gelen verileri al
  $tarla_adi = $_POST['tarla_adi'];
  $tarla_adresi =$_POST["tarla_adresi"];
  $il = $_POST['il'];
  $ilce = $_POST['ilce'];
  $ada = $_POST['ada'];
  $pafta = $_POST['pafta'];
  $tarla_gorseli = isset($_FILES["tarla_gorseli"]["name"]) ? $_FILES["tarla_gorseli"]["name"] : "";
  $yuzolcumu = $_POST['yuzolcumu'];
  $tapu_tip = $_POST['tapu_tip'];
  $ts_ad_soyad = $_POST['ts_ad_soyad'];
  $ad_soyad = $_POST['ad_soyad'];
  $tarlaID = $_POST['tarla_id'];
  
  // Eğer yeni bir görsel seçildiyse
  if (!empty($_FILES["tarla_gorseli"]["name"])) {
    try {
      // Mevcut tarla görselini çek
      $query = $baglanti->prepare("SELECT tarla_gorseli FROM tarlalar WHERE id = :id");
      $query->bindValue(':id', $tarlaID);
      $query->execute();
      $row = $query->fetch(PDO::FETCH_ASSOC);

      // $row'un değeri kontrol ediliyor
      if ($row !== false) {
        $gorselYolu = $row['tarla_gorseli'];

        // Önceki görsel dosyasını sil
        $existingImagePath = "Tarlalar/$tarlaID/" . basename($gorselYolu);

        if (file_exists($existingImagePath) && is_file($existingImagePath)) {
          // Dosya varsa ve bir dosyaysa sil
          unlink($existingImagePath);
        } else {
          // Dosya bulunamadıysa veya bir dosya değilse hata mesajını göster
          echo "Eski resim bulunamadı veya bir dosya değil.";
        }

        // Yeni görseli yükle ve güncelle
        $target_dir = "Tarlalar/$tarlaID";
        $tarlaGorseliDosyaAdi = basename($_FILES["tarla_gorseli"]["name"]);
        $target_file = $target_dir . '/' . $tarlaGorseliDosyaAdi;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Yükleme işlemleri...
        if (move_uploaded_file($_FILES["tarla_gorseli"]["tmp_name"], $target_file)) {
          // Yükleme başarılı, veritabanındaki yolu güncelle
          $query = $baglanti->prepare("UPDATE tarlalar SET tarla_gorseli = :tarla_gorseli WHERE id = :id");
          $query->bindValue(':tarla_gorseli', "Tarlalar/$tarlaID/$tarlaGorseliDosyaAdi");
          $query->bindValue(':id', $tarlaID);
          $query->execute();
        } else {
          // Yükleme başarısız
          echo "Dosya yüklenirken bir hata oluştu.";
        }
      } else {
        // $row false ise kayıt bulunamadı
        echo "Kayıt bulunamadı.";
      }
    } catch (PDOException $e) {
      echo "Hata: " . $e->getMessage();
    }
  }

  // Güncelleme işlemini gerçekleştir
  try {
    $query = $baglanti->prepare("UPDATE tarlalar SET tarla_adi = :tarla_adi, tarla_adresi = :tarla_adresi, il = :il, ilce = :ilce, ada = :ada, pafta = :pafta, yuzolcumu = :yuzolcumu, tapu_tip = :tapu_tip, ts_ad_soyad = :ts_ad_soyad, ad_soyad = :ad_soyad WHERE id = :id");
    $query->bindValue(':tarla_adi', $tarla_adi);
    $query->bindValue(':tarla_adresi', $tarla_adresi);
    $query->bindValue(':il', $il);
    $query->bindValue(':ilce', $ilce);
    $query->bindValue(':ada', $ada);
    $query->bindValue(':pafta', $pafta);
    $query->bindValue(':yuzolcumu', $yuzolcumu);
    $query->bindValue(':tapu_tip', $tapu_tip);
    $query->bindValue(':ts_ad_soyad', $ts_ad_soyad);
    $query->bindValue(':ad_soyad', $ad_soyad);
    $query->bindValue(':id', $tarlaID);

    $query->execute();

    echo "Kayıt başarıyla güncellendi.";
    header("Location: ciftci-index.php");
    exit; 


  } catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
  }
}
?>




<div class="container pt-5">
   <form method="POST" action="tarla-duzenle.php" enctype="multipart/form-data">

   <div class="mb-3">
        <label for="tarla_adi" class="form-label">Tarla Adı</label>
        <input type="text" class="form-control" id="tarla_adi" name="tarla_adi" value="<?php echo htmlspecialchars($tarla_adi); ?>">
   </div>

   <div class="mb-3">
        <label for="tarla_adresi" class="form-label">Tarla Adresi</label>
        <input type="text" class="form-control" id="tarla_adresi" name="tarla_adresi" value="<?php echo htmlspecialchars($tarla_adresi); ?>">
   </div>

   <div class="col-12">
               <div class="row g-3">
                    <!-- İL -->
                    <div class="col-md-4">
                        <label for="il" class="form-label">İl *</label>
                       <select class="form-select <?php if(!empty($il_err)){echo "is-invalid";} ?>" id="il" name="il">
                       <option value="<?php echo $il; ?>"><?php echo $il; ?></option>
                        <?php
                       $iller = $baglanti->query("SELECT * FROM iller")->fetchAll(PDO::FETCH_ASSOC);
                       foreach ($iller as $il) {
                       $il_id = $il['il_id'];
                       $il_adi = $il['il_adi'];
                       ?>
                       <option value="<?php echo $il_adi; ?>">
                         <?php echo $il_adi; ?>
                        </option>
                        <?php } ?>
                       </select>
                       <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $il_err; ?> </div>
                     </div>
               

                     
                   <!-- İLCE  -->
                   <div class="col-md-4">
                       <label for="ilce" class="form-label">İlçe *</label>
                       <select class="form-select <?php if(!empty($ilce_err)){echo "is-invalid";} ?>" id="ilce" name="ilce" >
                       <option value="<?php echo $ilce; ?>"><?php echo $ilce; ?></option>
                       </select>
                       <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $ilce_err; ?> </div>
                   </div>


                    <!-- KÖY  -->
                   <div class="col-md-4">
                     <div class="mb-3">
                       <label for="inputCityKoy" class="form-label">Köy</label>
                       <input type="text" class="form-control" id="inputCityKoy" name="inputCityKoy">
                     </div>
                   </div>
                 </div>
              </div>

   <div class="mb-3">
        <label for="ada" class="form-label">Ada</label>
        <input type="text" class="form-control" id="ada" name="ada" value="<?php echo htmlspecialchars($ada); ?>">
   </div>

   <div class="mb-3">
        <label for="pafta" class="form-label">Pafta </label>
        <input type="text" class="form-control" id="pafta" name="pafta" value="<?php echo htmlspecialchars($pafta); ?>">
   </div>

   <div class="mb-3">
    <label for="tarla_gorseli" class="form-label">Tarla Görseli</label>
    <img src="<?php echo $gorselYolu; ?>" alt="Tarla Görseli" style="max-width: 200px;">
    <input type="file" class="form-control" id="tarla_gorseli" name="tarla_gorseli" >
</div>



   <div class="mb-3">
        <label for="yuzolcumu" class="form-label">Tarla Yüzölçümü</label>
        <input type="text" class="form-control" id="yuzolcumu" name="yuzolcumu" value="<?php echo htmlspecialchars($yuzolcumu); ?>">
    </div>

    <!-- TAPU TİP -->
    <div class="mb-3">
    <label for="tapu_tip" class="form-label">Tarla Sahibi mi? Kiralık mı?</label>
    <select class="form-select <?php if(!empty($tapu_tip_err)){echo "is-invalid";} ?>" id="tapu_tip" name="tapu_tip">
        <option value="" disabled selected>Seçiniz</option>
        <option value="0" <?php if($tapu_tip == 0) echo "selected"; ?>>Kiralık</option>
        <option value="1" <?php if($tapu_tip == 1) echo "selected"; ?>>Kendim</option>
    </select>
    <div id="validationServerUsernameFeedback" class="invalid-feedback"><?php echo $tapu_tip_err; ?></div>
</div>


  <?php if ($tapu_tip == 0): ?>
    <div class="d-none" id="kiralikContent">
        <div class="mb-3">
            <label for="ts_ad_soyad" class="form-label">Tarla Sahibi Ad Soyad </label>
            <input type="text" class="form-control" id="ts_ad_soyad" name="ts_ad_soyad" value="<?php echo htmlspecialchars($ts_ad_soyad); ?>">
        </div>
    </div>

    <?php elseif ($tapu_tip == 1): ?>
    <div class="d-none" id="kendimContent">
        <div class="mb-3">
            <label for="ad_soyad" class="form-label">Ad Soyad </label>
            <input type="text" class="form-control" id="ad_soyad" name="ad_soyad" value="<?php echo htmlspecialchars($ad_soyad); ?>">
        </div>
    </div>
    
    <?php endif; ?>


        <input type="hidden" name="tarla_id" value="<?php echo $tarlaID ?>">
        <button type="submit" class="btn btn-primary">Kaydet</button>
     
                     
                  
   </form>
 </div>

<script src="https://code.jquery.com/jquery-3.6.4.slim.js" integrity="sha256-dWvV84T6BhzO4vG6gWhsWVKVoa4lVmLnpBOZh/CAHU4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<script>
$(document).ready(function(){
  $("select[name='il']").on("change", function(){
        let ilId = $(this).val();
        
        // AJAX isteği oluşturma
        $.ajax({
            url: 'get_ilceler.php', 
            method: 'POST',
            data: { il: ilId },
            dataType: 'json',
            success: function(response){
                // Başarılı yanıt işleme
                console.log('AJAX İsteği Başarılı', response);
                let ilceSelect = $("select[name='ilce']");
                ilceSelect.empty();

                $.each(response, function(key, value){
                    ilceSelect.append("<option value='" + value.ilce_adi + "'>" + value.ilce_adi + "</option>");
                });
            },
            error: function(xhr, status, error){
                // Hata durumunda işleme
                console.error('AJAX Hatası',error);
            }
        });
    });
  
   // "Tapu Tipi" alanının değişimini dinle
   $("select[name='tapu_tip']").on("change", function(){
        // Seçilen tapu tipi değerini al
        let tapuTip = $(this).val();
        
        // Seçilen değere göre ilgili form alanlarını göster veya gizle
        if(tapuTip == 0 ){ // Kiralık
            $("#kiralikContent").removeClass("d-none");
            $("#kendimContent").addClass("d-none");
        } else if(tapuTip == 1){ // Kendim
            $("#kiralikContent").addClass("d-none");
            $("#kendimContent").removeClass("d-none");
        }
    });
    
    });
</script>


</body>
</html>