<?php
session_start();
include("baglanti.php");

$ad_err="";
$soyad_err="";
$dogum_tarihi_err = ""; 
$adres_err = ""; 
$il_err = "";
$ilce_err = "";
$email_err="";
$emailtkr_err="";
$parola_err="";
$parolatkr_err="";
$tc_no = ""; 
$tel_no_err = ""; 
$cep_no_err = "";  
$meslek = ""; 
$mezuniyet = ""; 
$bolum = ""; 
$deneyim = ""; 
$firma_unvan = ""; 
$vergi_no = ""; 
$vergi_dairesi = ""; 
$firma_adres = ""; 
$vergi_levhasi = "";   
$oda_sicil_kaydi= "";
$firma_logo = "";
$kullanici_tip = "";
$kullaniciBilgiler = $_SESSION['kullaniciBilgiler'];
$ust_kullanici_id = $kullaniciBilgiler['id'];


if(isset($_POST["kaydet"]))
{

  
  // $ust_kullanici_id = $_SESSION['id'];
  // $ust_kullanici_id = isset($_POST["ust_kullanici_id"]) ? $_POST["ust_kullanici_id"] : $_SESSION['id'];

  // var_dump($ust_kullanici_id);
  // echo $_SESSION['id'];
  
  // Formdan veriler alınıp değişkenlere atılıyor.

  $ust_kullanici_id = $kullaniciBilgiler['id'];

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

//TEL-NO
if(empty($_POST["tel_no"]))
{
  $tel_no_err="Telefon no boş geçilemez!";
}
else{
  $tel_no=$_POST["tel_no"];
}

//cep-NO
if(empty($_POST["cep_no"]))
{
  $cep_no_err="Cep no boş geçilemez!";
}
else{
  $cep_no=$_POST["cep_no"];
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



  // $tel_no = $_POST["tel_no"]; 
  // $cep_no = $_POST["cep_no"];  
  $meslek = $_POST["meslek"]; 
  $mezuniyet = $_POST["mezuniyet"]; 
  $bolum = $_POST["bolum"]; 
  $deneyim = $_POST["deneyim"]; 
  $firma_unvan = $_POST["firma_unvan"]; 
  $vergi_no = $_POST["vergi_no"]; 
  $vergi_dairesi = $_POST["vergi_dairesi"]; 
  $firma_adres = $_POST["firma_adres"]; 
  $vergi_levhasi = isset($_POST["vergi_levhasi"]) ? $_POST["vergi_levhasi"] : ""; 
  $oda_sicil_kaydi = isset($_POST["oda_sicil_kaydi"]) ? $_POST["oda_sicil_kaydi"] : "";
  $firma_logo = isset($_POST["firma_logo"]) ? $_POST["firma_logo"] : ""; 
  $kullanici_tip = $_POST["kullanici_tip"];
  $ust_kullanici_id = $kullaniciBilgiler['id'];

  // Formdan alınan verileri veritabanına kayıt yapılıyor
  if(isset($username) && isset($email) && isset($parola))
  {
    $query = $baglanti->query("SELECT * FROM kullanicilar WHERE kullanici_adi = '{$username}'")->fetch(PDO::FETCH_ASSOC);
    if($query == NULL){
      $query = $baglanti->prepare("INSERT INTO kullanicilar SET
       
        ust_kullanici_id = ?,
        email = ?,
        ad = ?,
        soyad = ?,
        parola = ?,
        cep_no = ?,
        tel_no = ?,
        meslek = ?,
        mezuniyet = ?,
        bolum = ?,
        deneyim = ?,
        firma_unvan = ?,
        vergi_no = ?,
        vergi_dairesi = ?,
        firma_adres = ?,
        vergi_levhasi = ?,
        oda_sicil_kaydi = ?,
        firma_logo = ?,
        kullanici_tip = ?");

        $insert = $query->execute(array(
        
        $ust_kullanici_id,
        $email,
        $name, 
        $surname,
        $parola, 
        $cep_no,  
        $tel_no,
        $meslek, 
        $mezuniyet, 
        $bolum, 
        $deneyim, 
        $firma_unvan, 
        $vergi_no, 
        $vergi_dairesi, 
        $firma_adres, 
        $vergi_levhasi, 
        $oda_sicil_kaydi,  
        $firma_logo,
        $kullanici_tip,
      ));
      if ( $insert ){
        $last_id = $baglanti->lastInsertId();

        //Dosya Yükleme İşlemleri
        
        $target_dir = "uploads";

        //Kullanıcı Id li dosya yoksa oluşturuyoruz

        if (!file_exists($target_dir.'/'.$last_id)) {
          mkdir($target_dir.'/'.$last_id, 0777, true);
        }

        $files = array($_FILES["vergi_levhasi"], $_FILES["oda_sicil_kaydi"] , $_FILES["firma_logo"]);
        $file_names = array("Vergi-Levhasi", "Oda-Sicil-Kaydi", "Logo");

        for ($i=0; $i < 3; $i++) {
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
    }else{
        echo '<div class="alert alert-danger" role="alert">
                Kayıt gerçekleştirilemedi
              </div>';
    }

  }else{
    echo '<div class="alert alert-warning" role="alert">
                Bu Kullanıcı Adı Daha Önce Kullanılmaktadır
              </div>';
  }
  }else{
    
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
    <title>Alt Kullanıcı Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>


  <nav class="navbar navbar-expand-lg bg-body-tertiary  navbar bg-dark" data-bs-theme="dark" >
   <div class="container">
   <a class="navbar-brand" href="alici-index.php">
  <span class="navbar-brand-text">ALICI ANA SAYFA</span>
</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
     <div class=" collapse navbar-collapse" id="navbarNavAltMarkup">
       <div class="navbar-nav">
         <a class="nav-link" href="alici-index.php">Sayfam</a>
         <a class="nav-link" href="#">Mesajlar</a>
         <a class="nav-link" href="alici-iletisim.php">İletişim</a>
       </div>

      
       <form class="d-flex">
         <!-- <input class="form-control me-2" type="search" placeholder="Ara" aria-label="Ara"> -->
        <div class="input-group" style="width: 200px; margin-left:650px; ">
           <input type="text" class="form-control" id="arama" name="arama" placeholder="Tarla Adı Ara" style=" background-color: #fff; border: 4px solid #ccc; border-radius: 5px;">
           <button class="btn btn-outline-light text-white" type="submit"><i class="fas fa-search"></i></button>
        </div>
      </form>
       <div class="navbar-nav ms-auto">
         <a class="nav-link" href="profil.php">Profil</a>
       </div>
     </div>
   </div>
 </nav>
    
    <div class="container p-5"> 
      <div class="card p-5">
        <h4 class="text-center"> Alt Kullanıcı Ekle </h4>
        <form action="" method="POST" enctype="multipart/form-data">

          <div class="mb-3">
                <label for="InputAd" class="form-label">Adı</label>
                <input type="text" class="form-control <?php if(!empty($ad_err)){echo "is-invalid";} ?>" name="ad" >
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $ad_err; ?> </div>
          </div>


          <div class="mb-3">
              <label for="InputSoyad" class="form-label">Soyad</label>
              <input type="text" class="form-control <?php if(!empty($soyad_err)){ echo "is-invalid";} ?>" name="soyad">
              <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $soyad_err; ?> </div>
          </div>

              <div class="mb-3">
                <label for="InputCepNo" class="form-label">Cep Telefon Numarası</label>
                <input type="number" class="form-control  <?php if(!empty($cep_no_err)){ echo "is-invalid";} ?>" name="cep_no" placeholder="0 ( 5_ _ )  _ _ _  _ _   _ _" >
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $cep_no_err; ?> </div>
              </div>

              <div class="mb-3">
                <label for="InputTelNo" class="form-label"> Telefon Numarası</label>
                <input type="number" class="form-control  <?php if(!empty($tel_no_err)){ echo "is-invalid";} ?>" name="tel_no">
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $tel_no_err; ?> </div>
              </div>


              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Biriminizi Giriniz</label>
                <input type="text" class="form-control" name="meslek">
              </div>
              <div class="mb-3">
                <label for="inputCity" class="form-label">Mezuniyet</label>
                <select id="inputState" class="form-select" name="mezuniyet">
                  <option selected>Seçiniz...</option>
                  <option value="Orta Öğretim">Orta Öğretim</option>
                  <option value="Lise">Lise</option>
                  <option value="Lisans">Lisans</option>
                  <option value="Yüksek Lisans">Yüksek Lisans</option>
                  <option value="Diğer">Diğer</option>
                </select>
              </div>
              <div class="mb-3 d-none" id="bolumContent">
                <label for="exampleInputEmail1" class="form-label">Bölüm Giriniz</label>
                <input type="text" class="form-control" name="bolum">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Deneyim</label>
                <input type="text" class="form-control" name="deneyim">
              </div>
              <div class="mb-3"> 
              </div>
              
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Firma Ünvan</label>
                  <input type="text" class="form-control" name="firma_unvan">
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Vergi No</label>
                  <input type="text" class="form-control" name="vergi_no">
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Vergi Dairesi</label>
                  <input type="text" class="form-control" name="vergi_dairesi">
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Firma Adres</label>
                  <input type="text" class="form-control" name="firma_adres">
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Vergi Levhası</label>
                  <input type="file" class="form-control" name="vergi_levhasi">
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Oda Sicil Kaydı</label>
                  <input type="file" class="form-control" name="oda_sicil_kaydi">
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Logo</label>
                  <input type="file" class="form-control" name="firma_logo">
               </div>

              
              <!--Kullanıcı Tip Gönderimi Sağlamak İçin (Çiftçi (0) veya Alıcı (1) )--->
              <div class="mb-3">
                <input type="hidden" class="form-control" value="1" name="kullanici_tip">
              </div>
              

              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control <?php if(!empty($email_err)){echo "is-invalid";} ?>" name="email" placeholder="name@example.com" >
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $email_err; ?> </div>
              </div>
              
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email Tekrar</label>
                <input type="text" class="form-control <?php if(!empty($emailtkr_err)) { echo "is-invalid"; } ?>" name="emailtkr" >
                <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $emailtkr_err; ?> </div>
              </div>

               <!-- Parola alanı -->
               <div id="parola-uyusmazlik-hatasi" class="text-danger"></div>
                  <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Parola</label>
                    <input type="password" class="form-control <?php if(!empty($parola_err)) { echo "is-invalid"; } ?>" name="parola" id="parola" onkeyup="checkPasswordMatch()">
                    <div id="parola_err" class="invalid-feedback"> <?php echo $parola_err; ?> </div>
                </div>

               <!-- Parola Tekrar alanı -->
               <div class="mb-3">
                 <label for="exampleInputPassword1" class="form-label">Parola Tekrar</label>
                 <input type="password" class="form-control <?php if(!empty($parolatkr_err)) { echo "is-invalid"; } ?>" name="parolatkr" id="parolatkr" onkeyup="checkPasswordMatch()">
                 <div id="parolatkr_err" class="invalid-feedback"> <?php echo $parolatkr_err; ?> </div>
               </div>
              
              <!-- <input type="hidden" name="ust_kullanici_id" value="<?php echo $_GET["ust_kullanici_id"]; ?>" -->
            
          <button type="submit" name="kaydet" class="btn btn-primary">KAYDET</button>
        </form>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.slim.js" integrity="sha256-dWvV84T6BhzO4vG6gWhsWVKVoa4lVmLnpBOZh/CAHU4=" crossorigin="anonymous"></script>

    <script>
      $(document).ready(function(){
        $("select[name='mezuniyet']").on("change",function(){
          let bolum = $(this).val();
          if(bolum == "Yüksek Lisans" || bolum == "Lisans"){
            $("#bolumContent").removeClass("d-none")
          }else{
            $("#bolumContent").addClass("d-none")
          }
        })

        $("select[name='firma_tip']").on("change",function(){
          let firmaTip = $(this).val();
          if(firmaTip == 0 || firmaTip == 1){
            $("#sirketContent").removeClass("d-none");
            $("#bireyselContent").addClass("d-none");
          }else{
            $("#sirketContent").addClass("d-none");
            $("#bireyselContent").removeClass("d-none");
          }
        })
      })

      //SAĞ TIK YASAĞI
      document.addEventListener('DOMContentLoaded', function() {
    var emailInput = document.querySelector("input[name='email']");
    
    if (emailInput) {
      emailInput.addEventListener('contextmenu', function(e) {
        e.preventDefault();
        // Sağ tıklama engellendi, burada başka bir işlem yapmak isterseniz ekleyebilirsiniz.
      });
    }
  });
      
    </script>
  </body>
</html>