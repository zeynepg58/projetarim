<?php 
include("baglanti.php"); 

session_start();

$tarla_adi_err="";
$tarla_adresi="";
$il_err = "";
$ilce_err = "";
$yuzolcumu_err="";
$tapu_tip_err="";
$ts_ad_soyad="";
$ada="";
$pafta="";
$tarla_gorseli="";
$kiralama_belgesi="";
$ad_soyad="";
$kullaniciBilgiler = $_SESSION['kullaniciBilgiler'];
$kullanici_id = $kullaniciBilgiler['id'];

if(isset($_POST["kaydet"]))
{

  //TARLA ADI
  if(empty($_POST["tarla_adi"]))
  {
    $tarla_adi_err="Tarla Adı boş geçilemez !";
  }
  else{
    $tarla_adi=$_POST["tarla_adi"];
  }
  

/// İL
if (empty($_POST["il"])) {
  $il_err = "İl boş geçilemez!";
} else {
  $il = $_POST["il"];
}

// İLCE
if (empty($_POST["ilce"])) {
  $ilce_err = "İlçe boş geçilemez!";
} else {
  $ilce = $_POST["ilce"];
}

//YUZOLCUMU
if (empty($_POST["yuzolcumu"])) {
  $yuzolcumu_err = "Yüzölçümü boş geçilemez!";
} else {
  $yuzolcumu = $_POST["yuzolcumu"];
}

// TAPUTİP
// var_dump($_POST);
$tapu_tip = isset($_POST["tapu_tip"]) ? $_POST["tapu_tip"] : "";
if (empty($tapu_tip) && $tapu_tip != "0"){
  $tapu_tip_err = "Tarla Sahibi boş geçilemez!";
} else {
  $tapu_tip = $_POST["tapu_tip"];
}
  
//TS_AD_SOYAD_ERR
// $ts_ad_soyad = isset($_POST["ts_ad_soyad"]) ? $_POST["ts_ad_soyad"] : "";
// if (empty($_POST["ts_ad_soyad"])) {
//   $ts_ad_soyad_err = "Tarla Sahibi Ad Soyad boş geçilemez!";
// } else {
//   $ts_ad_soyad = $_POST["ts_ad_soyad"];
// }

 $tarla_adi=$_POST["tarla_adi"];
 $tarla_adresi = $_POST["tarla_adresi"];
 $il = $_POST["il"];
 $ilce =$_POST["ilce"];
 $ada = $_POST["ada"]; 
 $pafta = $_POST["pafta"]; 
 $tarla_gorseli = isset($_FILES["tarla_gorseli"]["name"]) ? $_FILES["tarla_gorseli"]["name"] : "";
 
 $yuzolcumu = $_POST["yuzolcumu"];  
//  $tapu_tip = $_POST["tapu_tip"]; 
 $kiralama_belgesi = isset($_POST["kiralama_belgesi"]) ? $_POST["kiralama_belgesi"] : ""; 
 $ts_ad_soyad = $_POST["ts_ad_soyad"]; 
 $ad_soyad = $_POST["ad_soyad"]; 
//  $kullanici_id = $kullaniciBilgiler['id'];

if(empty($tarla_adi_err) && empty($il_err) && empty($ilce_err) && empty($yuzolcumu_err) && empty($tapu_tip_err))
  {
 // Formdan alınan verileri veritabanına kayıt yapılıyor

 $query = $baglanti->query("SELECT * FROM kullanicilar WHERE kullanici_tip='0' ")->fetch(PDO::FETCH_ASSOC);
 if($query != NULL)
 {
  
     $query = $baglanti->prepare("INSERT INTO tarlalar SET
        tarla_adi = ?,
        tarla_adresi = ?,
        il = ?,
        ilce = ?,
        ada = ?,
        pafta=?,
        tarla_gorseli = ?,
        yuzolcumu = ?,
        tapu_tip = ?,
        kiralama_belgesi = ?,
        ts_ad_soyad = ?, 
        ad_soyad = ?,
        kullanici_id = ?");
        
        
     $insert = $query->execute(array(
        $tarla_adi ,
        $tarla_adresi ,
        $il ,
        $ilce ,
        $ada ,
        $pafta,
        $tarla_gorseli ,
        $yuzolcumu ,
        $tapu_tip,
        $kiralama_belgesi ,
        $ts_ad_soyad , 
        $ad_soyad ,
        $kullanici_id ));

    
        if ( $insert ){
    
      
          $last_id = $baglanti->lastInsertId();
          $target_dir = "Tarlalar";
    
        //Kullanıcı Id li dosya yoksa oluşturuyoruz
        if (!file_exists($target_dir.'/'.$last_id)) {
         mkdir($target_dir.'/'.$last_id, 0777, true);
       }
       
        //Dosya Yükleme İşlemleri
        $files = array($_FILES["tarla_gorseli"], $_FILES["kiralama_belgesi"]);
        $file_names = array();
        
        
        
        for ($i=0; $i < 2; $i++)
        {
          if(isset($files[$i]))
          {
            $file_names[$i] = pathinfo($files[$i]["name"], PATHINFO_FILENAME);

            $target_file = $target_dir .'/'.$last_id;
            $landuploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file."/".$files[$i]["name"],PATHINFO_EXTENSION));
           
            $query = $baglanti->prepare("UPDATE tarlalar SET tarla_gorseli = :tarla_gorseli, kiralama_belgesi = :kiralama_belgesi WHERE id = :last_id");
            $tarlaGorseliDosyaAdi = basename($_FILES["tarla_gorseli"]["name"]);
            $query->execute(array(
              ':tarla_gorseli' => "Tarlalar/$last_id/$tarlaGorseliDosyaAdi",
              ':kiralama_belgesi' => "Tarlalar/$last_id/Kiralama-Belgesi.pdf",
              ':last_id' => $last_id
           ));
            // Check file size
            if ($files[$i]["size"] > 500000)
            {
              $file_err = "Dosya Boyutu Çok Yüksek. ";
              $landuploadOk = 0;
            }
      
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf"){
              $file_err =  "Sadece JPG, JPEG, PNG & PDF bu dosya tiplerine İzin verilmektedir.";
              $landuploadOk = 0;
            }
      
            // Check if $uploadOk is set to 0 by an error
            if ($landuploadOk == 1) 
              {
                
               if (!move_uploaded_file($files[$i]["tmp_name"], $target_file . "/" . $file_names[$i] . "." . $imageFileType))
               {$file_err = "Dosya Yükleme Sırasında Bir Hata Oluştu";}
              }  
           }
        }
        
        echo '<div class="alert alert-success" role="alert">
                   Kayıt başarılı bir şekilde eklendi
                 </div>';
                
                 header("Location: ciftci-index.php");   
                  exit;  
      }   else
              {
                echo '<div class="alert alert-danger" role="alert">
                   Kayıt gerçekleştirilemedi
                 </div>';
                 
              }
             if(isset($file_err) && $file_err != "")
             {
               echo '<div class="alert alert-warning" role="alert">
                 '.$file_err.'
               </div>';
             }
      
  }
 }
}



?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tarla Ekle</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

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


<div class="container pt-5">
  <div class="d-flex">
    <h1>Tarla Ekle</h1>
     <div class="ms-auto">
       <a class="btn btn-dark" href="ciftci-index.php">
        <i class="fa-solid fa-backward"></i> Geri Gel 
       </a>
     </div>
  </div>
  <form action="tarla-ekle.php" method="post" enctype="multipart/form-data">

  <div class="mb-3">
    <label for="tarla_adi" class="form-label">Tarla Adı</label>
    <input type="text" class="form-control <?php if(!empty($tarla_adi_err)) echo 'is-invalid'; ?>" id="tarla_adi" name="tarla_adi">
    <div id="validationServerUsernameFeedback" class="invalid-feedback"><?php echo $tarla_adi_err; ?></div>
</div>

        <div class="mb-3">
              <label for="tarla_adresi" class="form-label">Tarla Adresi</label>
              <input type="text" class="form-control" id="tarla_adresi" placeholder="Cad. , Mah. , Sk." name="tarla_adresi">
        </div>
        
        <div class="col-12">
               <div class="row g-3">
                    <!-- İL -->
                    <div class="col-md-4">
                        <label for="il" class="form-label">İl *</label>
                       <select class="form-select <?php if(!empty($il_err)){echo "is-invalid";} ?>" id="il" name="il">
                         <option value="0">Şehir Seçiniz</option>
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
                           <option value="0">İlçe Seçiniz</option>
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
              <label for="ada" class="form-label">Ada Bilgisi</label>
              <input type="text" class="form-control" id="ada" name="ada">
           </div>

          <div class="mb-3">
              <label for="pafta" class="form-label">Pafta Bilgisi</label>
              <input type="text" class="form-control" id="pafta" name="pafta">
           </div>

          <div class="mb-3">
            <label for="tarla_gorseli" class="form-label">Tarla Görseli</label>
            <input type="file" class="form-control" id="tarla_gorseli" name="tarla_gorseli">
          </div>

          <div class="mb-3">
                <label for="yuzolcumu" class="form-label">Tarla Yüzölçümü</label>
                <input type="text" class="form-control <?php if(!empty($yuzolcumu_err)){echo "is-invalid";} ?>"id="yuzolcumu" name="yuzolcumu" >
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $yuzolcumu_err; ?> </div>
          </div>
<!--TAPU TİP -->
          <div class="mb-3">
           <label for="tapu_tip" class="form-label">Tarla sahibi mi? Kiralık mı?</label>
            <select class="form-select <?php if(!empty($tapu_tip_err)){echo "is-invalid";} ?>" id="tapu_tip" name="tapu_tip" >
              <option value=""disabled selected>Seçiniz</option>
              <option value="0">kiralik</option>
              <option value="1">kendim</option>
            </select>
            <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $tapu_tip_err; ?> </div>
          </div>

          <div class="d-none" id="kiralikContent">
            <div class="mb-3">
             <label for="kiralama_belgesi" class="form-label">Kiralama Belgesi</label>
             <input type="file" class="form-control" id="kiralama_belgesi" name="kiralama_belgesi">
            </div>
    
            <div class="mb-3">
             <label for="ts_ad_soyad" class="form-label">Tarla sahibi Ad Soyad</label>
             <input type="text" class="form-control" id="ts_ad_soyad" name="ts_ad_soyad" >
            </div>
          </div>
   
          <div class="d-none" id="kendimContent">
            <div class="mb-3">
                <label for="ad_soyad" class="form-label">Ad Soyad</label>
                <input type="text" class="form-control" name="ad_soyad" id ="ad_soyad">
            </div>
          </div>
          <button type="submit" name="kaydet" class="btn btn-primary">KAYDET</button>
   </form>
</div>


<script src="https://code.jquery.com/jquery-3.6.4.slim.js" integrity="sha256-dWvV84T6BhzO4vG6gWhsWVKVoa4lVmLnpBOZh/CAHU4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

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

    $("select[name='tapu_tip']").on("change", function(){
        let tapuTip = $(this).val();
        if(tapuTip == 0 ){
            $("#kiralikContent").removeClass("d-none");
            $("#kendimContent").addClass("d-none");
        } else {
            $("#kiralikContent").addClass("d-none");
            $("#kendimContent").removeClass("d-none");
        }
    });
});
     </script>
  </body>
</html>

