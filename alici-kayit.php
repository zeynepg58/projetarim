<?php
session_start();
include("baglanti.php");

$email_err="";
$parola_err="";
$parolatkr_err="";
$ad_err="";
$soyad_err="";
$emailtkr_err="";
$tel_no = ""; 
$cep_no_err= "";  
$firma_tip_err= "";
$vergi_levhasi = "";
$firma_logo = "";
$kullanici_tip = "";



if(isset($_POST["kaydet"]))
{
  
  // $email = $_POST["email"];
  // $query = $baglanti->query("SELECT email FROM kullanicilar WHERE email = '{$email}'");
  // $existingEmail = $query->fetch(PDO::FETCH_ASSOC);
  // if ($existingEmail) {
  //     $email_err = "Bu email adresi zaten kullanılmakta.";
  // }
  
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
   

  //FİRMA TİP
  if (empty($_POST["firma_tip"])) {
    $firma_tip_err = "Firma Tip boş geçilemez";
  } else {
    $firma_tip = $_POST["firma_tip"];
  
  }

  //cep-NO
if(empty($_POST["cep_no"]))
{
  $cep_no_err="Cep no boş geçilemez!";
}
else{
  $cep_no=$_POST["cep_no"];
}

   
   // EMAİL DOĞRULAMA
if (empty($_POST["email"])) {
  $email_err = "Email boş geçilemez";
} else {
  $email = $_POST["email"];
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Lütfen geçerli bir email adresi giriniz.";
  }
}

// EMAİL TEKRAR DOĞRULAMA
if (empty($_POST["emailtkr"])) {
  $emailtkr_err = "Email tekrar boş geçilemez! ";
} else if ($_POST["email"] != $_POST["emailtkr"]) {
  $emailtkr_err = "Email eşleşmiyor.";
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

 
  $tel_no = $_POST["tel_no"]; 
  $cep_no = $_POST["cep_no"];  
  $vergi_levhasi = isset($_POST["vergi_levhasi"]) ? $_POST["vergi_levhasi"] : ""; 
  $firma_logo = isset($_POST["firma_logo"]) ? $_POST["firma_logo"] : ""; 
  $kullanici_tip = $_POST["kullanici_tip"];



  // Formdan alınan verileri veritabanına kayıt yapılıyor
  if(empty($email_err) && isset($email) && isset($parola))
  {
    $query = $baglanti->query("SELECT * FROM kullanicilar WHERE email = '{$email}'")->fetch(PDO::FETCH_ASSOC);
    if($query == NULL){
      $query = $baglanti->prepare("INSERT INTO kullanicilar SET
        
        email = ?,
        ad = ?,
        soyad = ?,
        parola = ?,
        tel_no = ?,
        cep_no = ?,
        firma_tip = ?;
        vergi_levhasi =?;
        firma_logo =?;
        kullanici_tip = ?");

        $insert = $query->execute(array(
        $email,
        $ad, 
        $soyad,
        $parola, 
        $tel_no, 
        $cep_no,  
        $firma_tip,
        $vergi_levhasi,
        $firma_logo,
        $kullanici_tip
      ));

     if ( $insert ){
          $last_id = $baglanti->lastInsertId();
             
          //Dosya Yükleme İşlemleri
          
          $target_dir = "Alici Kullanıcıları";

          //Kullanıcı Id li dosya yoksa oluşturuyoruz

          if (!file_exists($target_dir.'/'.$last_id)) {
            mkdir($target_dir.'/'.$last_id, 0777, true);
          }

          $files = array($_FILES["vergi_levhasi"], $_FILES["firma_logo"]);
          $file_names = array("Vergi-Levhasi", "Logo");

          for ($i=0; $i < 2; $i++) {
            if(isset($files[$i])){
              
              $target_file = $target_dir .'/'.$last_id;
              $uploadOk = 1;
              $imageFileType = strtolower(pathinfo($target_file."/".$files[$i]["name"],PATHINFO_EXTENSION));

              // Check file size
              if ($files[$i]["size"] > 500000) {
                $file_err = "Dosya Boyutu Çok Yüksek. ";
                $uploadOk = 0;
              }

              // Allow certain file formats
              if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf") {
                $file_err =  "Sadece JPG, JPEG, PNG & PDF bu dosya tiplerine İzin verilmektedir.";
                $uploadOk = 0;

              }

              // Check if $uploadOk is set to 0 by an error
              if ($uploadOk == 1) {
                if (!move_uploaded_file($files[$i]["tmp_name"], $target_file."/". $file_names[$i].".".$imageFileType)) {
                  $file_err = "Dosya Yükleme Sırasında Bir Hata Oluştu";
                }
              }
            }
          }
         
         echo '<div class="alert alert-success" role="alert">
                Kayıt başarılı bir şekilde eklendi
              </div>';

              header("Location: index.php");
              exit; 
    }else{
        echo '<div class="alert alert-danger" role="alert">
                Kayıt gerçekleştirilemedi
              </div>';
    }
     
  }
  }
  else{
   
    
    if(isset($file_err) && $file_err != ""){
      echo '<div class="alert alert-warning" role="alert">
        '.$file_err.'
      </div>';
    }
  }
}

?>
<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ÜYE KAYIT İŞLEMİ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>
    <div class="container p-5">
      <div class="card p-5">
        <h4 class="text-center"> Alıcı Kayıt Sayfası </h4>
        <form action="" method="POST" enctype="multipart/form-data">
        
          <div class="mb-3">
            <label for="ad" class="form-label">Adı</label>
            <input type="text" class="form-control <?php if(!empty($ad_err)) { echo "is-invalid"; } ?>" id="ad" name="ad"></div>
          <div class="mb-3"><label for="soyad" class="form-label">Soyadı</label>
          <input type="text" class="form-control <?php if(!empty($soyad_err)){ echo "is-invalid";} ?>" id="soyad" name="soyad"></div>
        
          <div class="col-12">
            
              <!--- TODO: Option valueler şehir isimleri ile değişilecek -->
              
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
                  <label for="vergi_levhasi" class="form-label">Vergi Levhası</label>
                  <input type="file" class="form-control" id="vergi_levhasi" name="vergi_levhasi">
                </div>
              </div>
              <!-- bireysel -->
              <!-- <div class="d-none" id="bireyselContent">
                <div class="mb-3">
                  <label for="firma_marka" class="form-label">Firma Marka</label>
                  <input type="text" class="form-control" id="firma_marka" name="firma_marka">
                </div>
              </div> -->
              

              
               <!-- LOGO  -->
               <div class="mb-3">
                 <label for="firma_logo" class="form-label">Logo</label>
                 <input type="file" class="form-control" id="firma_logo" name="firma_logo">
               </div>

              <!--Kullanıcı Tip Gönderimi Sağlamak İçin (Çiftçi (0) veya Alıcı (1) )--->
              <div class="mb-3">
                <input type="hidden" class="form-control" value="1" name="kullanici_tip">
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

              
              <div class="mb-3">
                <label for="parola" class="form-label">Parola</label>
                <input type="password" class="form-control <?php if(!empty($parola_err)) { echo "is-invalid"; } ?>" id="parola" name="parola">
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $parola_err; ?> </div>
              </div>
              <div class="mb-3">
                <label for="parolatkr" class="form-label">Parola Tekrar</label>
                <input type="password" class="form-control <?php if(!empty($parolatkr_err)) { echo "is-invalid"; } ?>" id="parolatkr" name="parolatkr">
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $parolatkr_err; ?> 
              </div>
               <!-- <input type="hidden" name="ust_kullanici_id" value="<?php echo $_SESSION['id']; ?>"> -->
          <button type="submit" name="kaydet" class="btn btn-primary">KAYDET</button>
        </form>
      </div>
    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.slim.js" integrity="sha256-dWvV84T6BhzO4vG6gWhsWVKVoa4lVmLnpBOZh/CAHU4=" crossorigin="anonymous"></script>
 
    <script>
      // Ülke seçildiğinde cep telefonu kodunu güncelleyen işlev
      document.getElementById('countrySelect').addEventListener('change', function() {
      // Seçilen ülkenin değerini al
      var selectedCountryCode = this.value;

      // Cep telefonu kodu alanını bul
      var cepNoInput = document.getElementById('cep_no');

      // Seçilen ülkenin cep telefonu kodunu cepNoInput değerine ekle
     cepNoInput.value = '+' + selectedCountryCode;
      });
 
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
     
    </script>
   
  </body>
</html>