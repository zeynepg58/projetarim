
<?php

// ini_set('display_errors','1');
// ini_set('display_startup_errors','1');
// error_reporting(E_ALL);

include("baglanti.php");

$ad_err="";
$soyad_err="";
$dogum_tarihi_err = ""; 
$adres_err = ""; 
$il_err = "";
$ilce_err = "";
$deneyim_err = "";
$firma_tip_err = "";
$email_err="";
$parola_err="";
$parolatkr_err="";
$emailtkr_err="";
$meslek_err="";
$tc_no = ""; 
$tel_no = ""; 
$cep_no_err = "";  
$mezuniyet = ""; 
$bolum = ""; 
$firma_unvan = ""; 
$vergi_no = ""; 
$vergi_dairesi = ""; 
$firma_adres = ""; 
$vergi_levhasi = ""; 
$firma_faaliyet_belgesi = "";  
$firma_logo = "";
$firma_marka = "";
$kullanici_tip = "";

if(isset($_POST["kaydet"]))
{
  
  
  //AD
  if(empty($_POST["ad"]))
  {
     $ad_err="İsim boş geçilemez !";
  }
  else{
    $ad=$_POST["ad"];
  }

  //SOYAD
  if(empty($_POST["soyad"]))
  {
    $soyad_err="Soyisim boş geçilemez !";
  }
  else{
    $soyad=$_POST["soyad"];
  }
   
  //DOGUM TARİHİ
  if(empty($_POST["dogum_tarihi"]))
  {
    $dogum_tarihi_err="Doğum Tarihi boş geçilemez !";
  }
  else{
    $dogum_tarihi=$_POST["dogum_tarihi"];
  }

  //ADRES
  if(empty($_POST["adres"]))
  {
    $adres_err="Adres boş geçilemez !";
  }
  else{
    $adres=$_POST["adres"];
  }
   
  //İL
  if(empty($_POST["il"]))
  {
    $il_err="İL boş geçilemez !";
  }
  else{
    $il=$_POST["il"];
  }
   
  //İLCE
  if(empty($_POST["ilce"]))
  {
    $ilce_err="İiçe boş geçilemez !";
  }
  else{
    $ilce=$_POST["ilce"];
  }
  
 
  //DENEYİM
  if(empty($_POST["deneyim"]))
  {
    $deneyim_err="Deneyim boş geçilemez !";
  }
  else{
    $deneyim=$_POST["deneyim"];
  }
 
  //cep-NO
if(empty($_POST["cep_no"]))
{
  $cep_no_err="Cep no boş geçilemez!";
}
else{
  $cep_no=$_POST["cep_no"];
}


// // Firma tipi kontrolü
// if (empty($_POST['firma_tip'])) {
//     $firma_tip_err = "Firma tipi seçilmelidir.";
// } else {
//     $firma_tip = $_POST['firma_tip'];
//     if ($firma_tip == 0 || $firma_tip==1) {
//         // Şirket ve Şahıs tipi için diğer kontrolleri ekleyebilirsiniz.
//         if (empty($_POST['firma_unvan'])) {
//             $firma_tip_err = "Firma ünvanı boş geçilemez.";
//         } elseif (empty($_POST['vergi_no'])) {
//             $firma_tip_err = "Vergi no boş geçilemez.";
//         } elseif (empty($_POST['vergi_dairesi'])) {
//             $firma_tip_err = "Vergi dairesi boş geçilemez.";
//         } elseif (empty($_POST['firma_adres'])) {
//             $firma_tip_err = "Firma adresi boş geçilemez.";
//         } elseif (empty($_FILES['vergi_levhasi']['name'])) {
//             $firma_tip_err = "Vergi levhası eklemelisiniz.";
//         } elseif (empty($_FILES['firma_faaliyet_belgesi']['name'])) {
//             $firma_tip_err = "Firma faaliyet belgesi eklemelisiniz.";
//         }
//     } elseif ($firma_tip == 2) {
//         // Bireyasel tipi için gerekli kontrolleri ekleyebilirsiniz.
//         if (empty($_POST['firma_marka'])) {
//             $firma_tip_err = "Firma marka boş geçilemez.";
//         }
//     } else {
//         // Bireysel tipi için gerekli kontrolleri ekleyebilirsiniz.
//         // Şu an için bireysel tipi için herhangi bir kontrol eklenmemiş.
//     }
// }


//FİRMA TİP
if (empty($_POST["firma_tip"])) {
  $firma_tip_err = "Firma Tip boş geçilemez";
} else {
  $firma_tip = $_POST["firma_tip"];

}

//EMAİL DOĞRULAMA
if (empty($_POST["email"])) {
  $email_err = "Email boş geçilemez";
} else {
  $email = $_POST["email"];
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Lütfen geçerli bir email adresi giriniz.";
  }
}


  //EMAİL TEKRAR DOĞRULAMA
  if(empty($_POST["emailtkr"]))
  {
    $emailtkr_err="Email tekrar boş geçilemez! ";
  }
  else if($_POST["email"]!=$_POST["emailtkr"])
  {
    $emailtkr_err="Email eşleşmiyor.";
  }
  else{
    $emailtkr=$_POST["emailtkr"];
  }

   //PAROLA DOĞRULAMA
   if(empty($_POST["parola"]))
   {
     $parola_err="Parola boş geçilemez !";
   }
   else{
     $parola = md5($_POST["parola"]);
   }

  //PAROLA TEKRAR DOĞRULAMASI
  if(empty($_POST["parolatkr"]))
  {
    $parolatkr_err="Parola tekrar boş geçilemez! ";
  }
  else if($_POST["parola"]!=$_POST["parolatkr"])
  {
    $parolatkr_err="Parolalar eşleşmiyor.";
  }
  else{
    $parolatkr=$_POST["parolatkr"];
  }
  
   //MESLEK DOĞRULAMA
  if(empty($_POST["meslek"]))
  {
     $meslek_err="meslek boş geçilemez !";
  }
  else{
    $meslek=$_POST["meslek"];
  }

  


  $tc_no = $_POST["tc_no"]; 
  $dogum_tarihi = $_POST["dogum_tarihi"]; 
  $adres =$_POST["inputCityKoy"]."/". $_POST["adres"]; 
  $il =$_POST["inputCityIl"];
  $ilce =$_POST["inputCityIlce"];
  $tel_no = $_POST["tel_no"]; 
  $cep_no = $_POST["cep_no"];  
  $meslek = $_POST["meslek"]; 
  $mezuniyet = $_POST["mezuniyet"]; 
  $bolum = $_POST["bolum"]; 
  // $deneyim = $_POST["deneyim"]; 
  // $firma_tip = $_POST["firma_tip"]; 
  $firma_unvan = $_POST["firma_unvan"]; 
  $vergi_no = $_POST["vergi_no"]; 
  $vergi_dairesi = $_POST["vergi_dairesi"]; 
  $firma_adres = $_POST["firma_adres"]; 
  $vergi_levhasi = isset($_POST["vergi_levhasi"]) ? $_POST["vergi_levhasi"] : ""; 
  $firma_faaliyet_belgesi = isset($_POST["firma_faaliyet_belgesi"]) ? $_POST["firma_faaliyet_belgesi"] : ""; 
  $firma_logo = isset($_POST["firma_logo"]) ? $_POST["firma_logo"] : ""; 
  $firma_marka = $_POST["firma_marka"];
  $kullanici_tip = $_POST["kullanici_tip"];

  // Formdan alınan verileri veritabanına kayıt yapılıyor
  if(isset($email) && isset($parola))
  {
    $query = $baglanti->query("SELECT * FROM kullanicilar WHERE email = '{$email}'")->fetch(PDO::FETCH_ASSOC);
    if($query == NULL)
    {
      $query = $baglanti->prepare("INSERT INTO kullanicilar SET
        
        ad = ?,
        soyad = ?,
        email = ?,
        parola = ?,
        tc_no = ?,
        dogum_tarihi=?,
        adres = ?,
        il = ?,
        ilce = ?,
        tel_no = ?,
        cep_no = ?, 
        meslek = ?,
        mezuniyet = ?,
        bolum = ?,
        deneyim = ?,
        firma_tip = ?,
        firma_unvan = ?,
        vergi_no = ?,
        vergi_dairesi = ?,
        firma_adres = ?,
        vergi_levhasi = ?,
        firma_faaliyet_belgesi = ?,
        firma_logo = ?,
        firma_marka = ?,
        kullanici_tip = ?");

        $insert = $query->execute(array(
       
      
        $ad, 
        $soyad,
        $email,
        $parola, 
        $tc_no, 
        $dogum_tarihi, 
        $adres, 
        $il,
        $ilce,
        $tel_no, 
        $cep_no,  
        $meslek, 
        $mezuniyet, 
        $bolum, 
        $deneyim, 
        $firma_tip, 
        $firma_unvan, 
        $vergi_no, 
        $vergi_dairesi, 
        $firma_adres, 
        $vergi_levhasi, 
        $firma_faaliyet_belgesi,  
        $firma_logo,
        $firma_marka,
        $kullanici_tip));


      if ( $insert )
      {
          //Dosya Yükleme İşlemleri
          $last_id = $baglanti->lastInsertId();
             
          $target_dir = "Çiftçi Kullanıcıları";

          //Kullanıcı Id li dosya yoksa oluşturuyoruz

          if (!file_exists($target_dir.'/'.$last_id)) {
            mkdir($target_dir.'/'.$last_id, 0777, true);
          }

          $files = array($_FILES["vergi_levhasi"], $_FILES["firma_faaliyet_belgesi"] , $_FILES["firma_logo"]);
          $file_names = array();

          for ($i=0; $i < 3; $i++) {
            if(isset($files[$i])){
              $file_names[$i] = pathinfo($files[$i]["name"], PATHINFO_FILENAME);
              
              $target_file = $target_dir .'/'.$last_id;
              $uploadOk = 1;
              $imageFileType = strtolower(pathinfo($target_file."/".$files[$i]["name"],PATHINFO_EXTENSION));

              $query = $baglanti->prepare("UPDATE Çiftçi Kullanıcıları SET vergi_levhasi = :vergi_levhasi, firma_faaliyet_belgesi = :firma_faaliyet_belgesi, firma_logo=firma_logo WHERE id = :last_id");
            $VergiLevhasi = basename($_FILES["vergi_levhasi"]["name"],["firma_faaliyet_belgesi"]["name"],["firma_logo"]["name"]);
            $query->execute(array(
              ':vergi_levhasi' => "Çiftçi Kullanıcıları/$last_id/$VergiLevhasi",
              ':firma_faaliyet_belgesi' => "Çiftçi Kullanıcıları/$last_id/Firma-Faaliyet-Belgesi",
              ':firma_logo' => "Çiftçi Kullanıcıları/$last_id/firma_logo",
              ':last_id' => $last_id
           ));

              // Check file size
              if ($files[$i]["size"] > 500000) 
              { 
                $file_err = "Dosya Boyutu Çok Yüksek. ";
                $uploadOk = 0;
              }

              // Allow certain file formats
              if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf") {
                $file_err =  "Sadece JPG, JPEG, PNG & PDF bu dosya tiplerine İzin verilmektedir.";
                $uploadOk = 0;

              }

              // Check if $uploadOk is set to 0 by an error
              if ($uploadOk == 1)
               {
                if (!move_uploaded_file($files[$i]["tmp_name"], $target_file."/". $file_names[$i].".".$imageFileType)) 
                {$file_err = "Dosya Yükleme Sırasında Bir Hata Oluştu";}
              }
            }
          }

          echo '<div class="alert alert-success" role="alert">
                  Kayıt başarılı bir şekilde eklendi
                </div>';

                header("Location: index.php");
                exit; 
       }   else
           {
          echo '<div class="alert alert-danger" role="alert">
                  Kayıt gerçekleştirilemedi
                </div>';
            }
    }
       if(isset($file_err) && $file_err != "")
       {
         echo '<div class="alert alert-warning" role="alert">
           '.$file_err.'
         </div>';
        }
  }
}


?>

<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ÜYE KAYIT İŞLEMİ</title>
    <link rel="stylesheet" href="public/css/ciftcikayit.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>
    <div class="container p-5">
      <div class="card p-5">
        <h4 class="text-center"> Çiftçi Kayıt Sayfası </h4>
        <form action="ciftci-kayit.php" method="post" enctype="multipart/form-data">
        

          <div class="mb-3">
                <label for="ad" class="form-label">Adı</label>
                <input type="text" class="form-control <?php if(!empty($ad_err)){echo "is-invalid";} ?>" id="ad" name="ad" >
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $ad_err; ?> </div>
          </div>
          
          <div class="mb-3">
              <label for="soyad" class="form-label">Soyad</label>
              <input type="text" class="form-control <?php if(!empty($soyad_err)){ echo "is-invalid";} ?>" id="soyad" name="soyad">
              <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $soyad_err; ?> </div>
          </div>
          
            <div class="mb-3"><label for="tc_no" class="form-label">TC Kimlik No</label><input type="number" class="form-control" id="tc_no" name="tc_no"></div>
          
             <div class="mb-3">
                <label for="dogum_tarihi" class="form-label">Doğum Tarihi</label> 
                <input type="date" class="form-control <?php if(!empty($dogum_tarihi_err)){echo "is-invalid";} ?>" id="dogum_tarihi" name="dogum_tarihi" >
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $dogum_tarihi_err; ?> </div>
             </div>
 
          
             <div class="mb-3">
                <label for="adres" class="form-label">Adres</label>
                <input type="text" class="form-control <?php if(!empty($adres_err)){echo "is-invalid";} ?>" id="adres" name="adres" >
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $adres_err; ?> </div>
             </div>

             <div class="col-12">
               <div class="row g-3">
                    <!-- İL -->
                    <div class="col-md-4">
                        <label for="inputCityIl" class="form-label">İl *</label>
                       <select class="form-select <?php if(!empty($il_err)){echo "is-invalid";} ?>" id="inputCityIl" name="inputCityIl">
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
                       <label for="inputCityIlce" class="form-label">İlçe *</label>
                       <select class="form-select <?php if(!empty($ilce_err)){echo "is-invalid";} ?>" id="inputCityIlce" name="inputCityIlce" >
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
                <label for="tel_no" class="form-label">Telefon Numarası</label>
                <input type="number" class="form-control" id="tel_no" name="tel_no" placeholder="0 ( 5_ _ )  _ _ _  _ _   _ _">
              </div>



              <!-- CEP NO  -->
                  <div class="mb-3" >
                  <label for="cep_no" class="form-label">Cep Telefon Numarası</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <label class="input-group-text"  for="countrySelect">Ülke</label>
                    </div>
                    <select class="form-select"  id="countrySelect" name="countrySelect">
                      <option value="" disabled selected>Seçiniz</option>
                      <option value="90">Türkiye</option>
                      <option value="1">Amerika Birleşik Devletleri</option>
                      <!-- Diğer ülkeler eklenecek  -->
                    </select>
                    <div style="width: 10px;"></div>
                    <input type="text" style="width:500px;" class="form-control <?php if(!empty($cep_no_err)){echo "is-invalid";} ?>" id="cep_no" name="cep_no"  > 
                    <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $cep_no_err; ?> </div>
                  </div>
               </div>


              <div class="mb-3">   
                <label for="meslek" class="form-label">Mesleğinizi Giriniz</label>
                <input type="text" class="form-control <?php if(!empty($meslek_err)){echo "is-invalid";} ?>" id="meslek" name="meslek" >
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $meslek_err; ?> </div>
              </div>

              <div class="mb-3">
                <label for="mezuniyet" class="form-label">Mezuniyet</label>
                <select class="form-select" id="mezuniyet" name="mezuniyet">
                  <option selected>Seçiniz...</option>
                  <option value="Orta Öğretim">Orta Öğretim</option>
                  <option value="Lise">Lise</option>
                  <option value="Lisans">Lisans</option>
                  <option value="Yüksek Lisans">Yüksek Lisans</option>
                  <option value="Diğer">Diğer</option>
                </select>
              </div>

              <div class="mb-3 d-none" id="bolumContent">
                <label for="bolum" class="form-label">Bölüm Giriniz</label>
                <input type="text" class="form-control" id="bolum" name="bolum">
              </div>

              <div class="mb-3">
                <label for="deneyim" class="form-label">Deneyim</label>
                <select class="form-select <?php if(!empty($deneyim_err)){echo "is-invalid";} ?>" id="deneyim" name="deneyim" >
                  <option value="" disabled selected>Seçiniz</option>
                  <option value="0-1">0-1 Yıl</option>
                  <option value="1-2">1-2 Yıl</option>
                  <option value="2-3">2-3 Yıl</option>
                </select>
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $deneyim_err; ?> </div>
              </div>

              <!-- FİRMA TİP -->
              <div class="mb-3">
                <label for="firma_tip" class="form-label">Firma Tip</label>
                <select class="form-select <?php if(!empty($firma_tip_err)){echo "is-invalid";} ?>" id="firma_tip" name="firma_tip" >
                  <option value=""disabled selected>Seçiniz...</option>
                  <option value="0">Şirket</option>
                  <option value="1">Şahıs</option>
                  <option value="2">Bireysel</option>
                </select>
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $firma_tip_err; ?> </div>
              </div>
              <!-- sirket -->
              <div class="d-none" id="sirketContent">
                <div class="mb-3">
                  <label for="firma_unvan" class="form-label">Firma Ünvan</label>
                  <input type="text" class="form-control" id="firma_unvan" name="firma_unvan">
                </div>
                <div class="mb-3">
                  <label for="vergi_no" class="form-label">Vergi No</label>
                  <input type="text" class="form-control" id="vergi_no" name="vergi_no">
                </div>
                <div class="mb-3">
                  <label for="vergi_dairesi" class="form-label">Vergi Dairesi</label>
                  <input type="text" class="form-control" id="vergi_dairesi" name="vergi_dairesi">
                </div>
                <div class="mb-3">
                  <label for="firma_adres" class="form-label">Firma Adres</label>
                  <input type="text" class="form-control" id="firma_adres" name="firma_adres">
                </div>
                <div class="mb-3">
                  <label for="vergi_levhasi" class="form-label">Vergi Levhası</label>
                  <input type="file" class="form-control" id="vergi_levhasi" name="vergi_levhasi">
                </div>
                <div class="mb-3">
                  <label for="firma_faaliyet_belgesi" class="form-label">Firma Faaliyet Belgesi</label>
                  <input type="file" class="form-control" id="firma_faaliyet_belgesi" name="firma_faaliyet_belgesi">
                </div>
              </div>
              <!-- bireysel -->
              <div class="d-none" id="bireyselContent">
                <div class="mb-3">
                  <label for="firma_marka" class="form-label">Firma Marka</label>
                  <input type="text" class="form-control" id="firma_marka" name="firma_marka">
                </div>
              </div>
              
              <!-- LOGO -->
              <div class="mb-3">
                <label for="firma_logo" class="form-label">Logo</label>
                <input type="file" class="form-control" id="firma_logo" name="firma_logo">
              </div>
              <!--Kullanıcı Tip Gönderimi Sağlamak İçin (Çiftçi (0) veya Alıcı (1) )--->
              <div class="mb-3">
                <input type="hidden" class="form-control" value="0" name="kullanici_tip">
              </div>
             


              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control <?php if(!empty($email_err)){echo "is-invalid";} ?>" id="email" name="email" placeholder="name@example.com" >
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $email_err; ?> </div>
                
              </div>
              <div class="mb-3">
                <label for="emailtkr" class="form-label">Email Tekrar</label>
                <input type="email" class="form-control <?php if(!empty($emailtkr_err)) { echo "is-invalid"; } ?>" id="emailtkr" name="emailtkr" >
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $emailtkr_err; ?> </div>
              </div>

              
              <!-- Parola alanı -->
              <div id="parola-uyusmazlik-hatasi" class="text-danger"></div>
                <div class="mb-3">
                  <label for="parola" class="form-label">Parola</label>
                  <input type="password" class="form-control <?php if(!empty($parola_err)) { echo "is-invalid"; } ?>" name="parola" id="parola" onkeyup="checkPasswordMatch()">
                  <div id="parola_err" class="invalid-feedback"> <?php echo $parola_err; ?> </div>
              </div>

             <!-- Parola Tekrar alanı -->
             <div class="mb-3">
               <label for="parolatkr" class="form-label">Parola Tekrar</label>
               <input type="password" class="form-control <?php if(!empty($parolatkr_err)) { echo "is-invalid"; } ?>" name="parolatkr" id="parolatkr" onkeyup="checkPasswordMatch()">
               <div id="parolatkr_err" class="invalid-feedback"> <?php echo $parolatkr_err; ?> </div>
             </div>
          <button type="submit" name="kaydet" class="btn btn-primary">KAYDET</button>
        </form>
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.slim.js" integrity="sha256-dWvV84T6BhzO4vG6gWhsWVKVoa4lVmLnpBOZh/CAHU4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

   
// İl seçildiğinde
$(document).ready(function(){
     $("select[name='inputCityIl']").on("change", function(){
     let ilId = $(this).val();

    // AJAX isteği oluşturma
    $.ajax({ 
      url: 'get_ilceler.php',
      method: 'POST',
      data: { il: ilId },
      dataType: 'json',
      success: function(response){
        // Başarılı yanıt işleme
        let ilceSelect = $("select[name='inputCityIlce']");
        ilceSelect.empty();

        $.each(response, function(key, value){
          ilceSelect.append("<option value='" + value.ilce_adi + "'>" + value.ilce_adi + "</option>");
        });
      },
      error: function(xhr, status, error){
        // Hata durumunda işleme
        console.error(error);
      }
    });
  });

        $("select[name='mezuniyet']").on("change",function(){
          let bolum = $(this).val();
          if(bolum == "Yüksek Lisans" || bolum == "Lisans")
          {
            $("#bolumContent").removeClass("d-none")
          }
          else{
            $("#bolumContent").addClass("d-none")
          }
        })

        $("select[name='firma_tip']").on("change",function(){
          let firmaTip = $(this).val();
          if(firmaTip == 0 || firmaTip == 1)
          {
            $("#sirketContent").removeClass("d-none");
            $("#bireyselContent").addClass("d-none");
          }
          else{
            $("#sirketContent").addClass("d-none");
            $("#bireyselContent").removeClass("d-none");
          }
        })

       // Parola eşleşme kontrolü işlevi
       function checkPasswordMatch() {
       var parola = document.getElementById("parola").value;
       var parolaTekrar = document.getElementById("parolatkr").value;
       var uyusmazlikHatasiDiv = document.getElementById("parola-uyusmazlik-hatasi");

       if (parola === parolaTekrar) {
        uyusmazlikHatasiDiv.innerHTML = ""; // Parolalar eşleşiyorsa hata mesajını temizle
       } else {
          uyusmazlikHatasiDiv.innerHTML = "Parolalar eşleşmiyor.";
       }
     }

      // Parola alanlarının değişiklik izleyicisi
      // document.getElementById("parola").addEventListener("input", checkPasswordMatch);
      document.getElementById("parolatkr").addEventListener("input", checkPasswordMatch);


      // Ülke seçildiğinde cep telefonu kodunu güncelleyen işlev
      document.getElementById('countrySelect').addEventListener('change', function() {
      // Seçilen ülkenin değerini al
      var selectedCountryCode = this.value;

      // Cep telefonu kodu alanını bul
      var cepNoInput = document.getElementById('cep_no');

      // Seçilen ülkenin cep telefonu kodunu cepNoInput değerine ekle
     cepNoInput.value = '+' + selectedCountryCode;
      });
        

    //SAĞ TIK YASAĞI
      document.addEventListener('DOMContentLoaded', function() {
    var emailInput = document.querySelector("input[name='email']");
    
    if(emailInput){
      emailInput.addEventListener('contextmenu', function(e){
        e.preventDefault();

      });
    }
  });
});

    </script>
  </body>
</html>


