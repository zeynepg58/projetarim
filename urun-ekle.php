<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("baglanti.php");


$urun_tip_err="";
$meyve_adi="";
$ekilecek_urun="";
$ekim_tarihi="";
$hasat_zamani_err="";
$urun_miktari_err="";
$tohum_sertifikasi="";
$toprak_analizi="";
// $tarim_teknigi_err="";



if(isset($_POST["kaydet"]))
{

 

  // ÜRÜN TİP
$urun_tip = isset($_POST["urun_tip"]) ? $_POST["urun_tip"] : "";
if ($urun_tip !== "0" && $urun_tip !== "1") {
    $urun_tip_err = "Ürün Tip boş bırakılamaz!";
} else {
    $urun_tip = $_POST["urun_tip"];
}



// MEYVE ADI
    // if (empty($_POST["meyve_adi"])) {
    //     $meyve_adi_err = "Meyve Adı boş bırakılamaz!";
    // } else {
    //     $meyve_adi = $_POST["meyve_adi"];
    // }



// TARIM TEKNİĞİ  
if (empty($_POST["tarim_teknigi"])) {
    $tarim_teknigi_err = "Tarım Tekniği boş bırakılamaz!";
} else {
    $tarim_teknigi = $_POST["tarim_teknigi"];
}




   //ÜRÜN MİKTARI 
   if(empty($_POST["urun_miktari"]))
   {
     $urun_miktari_err=" Ürün Miktarı boş boş geçilemez !";
   }
   else{
     $urun_miktari=$_POST["urun_miktari"];
   }
   
   //HASAT ZAMANI  
   if(empty($_POST["hasat_zamani"]))
   {
     $hasat_zamani_err=" Hasat Zamanı boş boş geçilemez !";
   }
   else{
     $hasat_zamani=$_POST["hasat_zamani"];
   }

   //TARIM TEKNİĞİ  
   if(empty($_POST["tarim_teknigi"]))
   {
     $tarim_teknigi_err=" Tarım Tekniği boş boş geçilemez !";
   }
   else{
     $tarim_teknigi=$_POST["tarim_teknigi"];
   }

    // $urun_tip = $_POST["urun_tip"] ;  
    $meyve_adi = isset($_POST["meyve_adi"]) ? $_POST["meyve_adi"] : "";
    $ekilecek_urun = $_POST["ekilecek_urun"]; 
    $ekim_tarihi = $_POST["ekim_tarihi"]; 

    $hasat_zamani = $_POST["hasat_zamani"]; 
    $urun_miktari = $_POST["urun_miktari"]; 
    $tohum_sertifikasi = isset($_POST["tohum_sertifikasi"]) ? $_POST["tohum_sertifikasi"] : ""; 
    $toprak_analizi = isset($_POST["toprak_analizi"]) ? $_POST["toprak_analizi"] : ""; 
  // //  $tarim_teknigi = $_POST["tarim_teknigi"]; 
 // $tarla_id = isset($_GET['tarla_id']) ? htmlspecialchars($_GET['tarla_id']) : '';
//$tarla_id = isset($_POST['tarla_id']) ? $_POST['tarla_id'] : '';
// Şimdi $tarla_id değişkenini kullanarak istediğiniz işlemleri gerçekleştirebilirsiniz.

  // $tarla_id = $_POST["tarla_id"] ?? "";
   $tarla_id = $_GET["tarla_id"]; 
   //$tarla_id = $_GET["tarla_id"] ?? "";

   // Formdan alınan verileri veritabanına kayıt yapılıyor
if( empty($urun_tip_err) &&empty($hasat_zamani_err) && empty($tarim_teknigi_err))
   {
 $query = $baglanti->query("SELECT * FROM kullanicilar WHERE kullanici_tip='0' ")->fetch(PDO::FETCH_ASSOC);
 if($query != NULL)
 {

  

   $query = $baglanti->prepare("INSERT INTO urunler SET
     urun_tip = ?,
     meyve_adi = ?,
     ekilecek_urun = ?,
     ekim_tarihi = ?,
     hasat_zamani = ?,
     urun_miktari = ?,
     tohum_sertifikasi = ?,
     toprak_analizi = ?,
     tarim_teknigi = ?,
     tarla_id = ?");


     $insert = $query->execute(array(
     $urun_tip,
     $meyve_adi,
     $ekilecek_urun,
     $ekim_tarihi,
     $hasat_zamani, 
     $urun_miktari, 
     $tohum_sertifikasi, 
     $toprak_analizi, 
     $tarim_teknigi, 
     $tarla_id,


     ));

     


     if ( $insert )
    {
    //Dosya Yükleme İşlemleri
    $last_id = $baglanti->lastInsertId();
             
    $target_dir = "Ürünler";

    //Kullanıcı Id li dosya yoksa oluşturuyoruz

    if (!file_exists($target_dir.'/'.$last_id)) {
      mkdir($target_dir.'/'.$last_id, 0777, true);
    }

    $files = array($_FILES["tohum_sertifikasi"], $_FILES["toprak_analizi"]);
    $file_names = array("Tohum-Sertifikası", "Toprak-Analizi");

    for ($i=0; $i < 2; $i++) {
      if(isset($files[$i])){
        
        $target_file = $target_dir .'/'.$last_id;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file."/".$files[$i]["name"],PATHINFO_EXTENSION));

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

          header("Location: ciftci-index.php");
          exit; 
      }  else
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Ekle</title>
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
        <a class="nav-link" href="#">İletişim</a>
      </div>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="ciftci-index.php">Profil</a>
      </div>
    </div>
  </div>
</nav>


<div class="container pt-5">
<form method="POST" action="urun-ekle.php?tarla_id=<?php echo $_GET["tarla_id"]; ?>" enctype="multipart/form-data">
    
<!-- URUN TİP -->
<div class="mb-3">
    <label for="urun_tip" class="form-label">Ekilecek ürün Meyve Ağacı mı? Tek Yıllık mı?</label>
    <select class="form-select <?php if(!empty($urun_tip_err)){echo "is-invalid";} ?>" name="urun_tip" id="urun_tip">
        <option value="" disabled selected>Seçiniz</option>
        <option value="0">Meyve Ağacı</option>
        <option value="1">Tek Yıllık</option>
    </select>
    <div id="urun_tip" class="invalid-feedback"> <?php echo $urun_tip_err; ?> </div>
</div>


      <!-- meyve ağacı -->
      <div class="d-none" id="meyveContent">
        <div class="mb-3">
          <label for="meyve_adi" class="form-label">Meyve Adı</label>
          <select class="form-select " id="meyve_adi" name="meyve_adi">
               <option value=""disabled selected>Seçiniz</option>
               <option value="Elma">Elma</option>
               <option value="Kayısı">Kayısı</option>
               <option value="Armut">Armut</option>
               <option value="Erik">Erik</option>
           </select>
        </div>
      </div>
    <!-- tek yıllık -->
      <div class="d-none" id="tekyillikContent">
         <div class="mb-3">
           <label for="ekilecek_urun" class="form-label ">Ekilecek Ürün</label>
           <input type="text" class="form-control" id= "ekilecek_urun" name="ekilecek_urun">
         </div>

         <div class="mb-3">
           <label for="ekim_tarihi" class="form-label ">Ekim Tarihi </label>
           <input type="date" class="form-control" id= "ekim_tarihi" name="ekim_tarihi">
         </div>
      </div>

        <div class="mb-3">
           <label for="hasat_zamani" class="form-label"> Tahmini Hasat Zamanı  </label>
           <input type="date" class="form-control <?php if(!empty($hasat_zamani_err)){echo "is-invalid";} ?> " id= "hasat_zamani" name="hasat_zamani">
           <div id="HasatZamaniFeedback" class="invalid-feedback"> <?php echo $hasat_zamani_err; ?> </div>
          </div>

         <div class="mb-3">
           <label for="urun_miktari" class="form-label">Tahmini Ürün Miktarı</label>
           <input type="text" class="form-control <?php if(!empty($urun_miktari_err)){echo "is-invalid";} ?>" id= "urun_miktari" name="urun_miktari">
           <div id="UrunMiktariFeedback" class="invalid-feedback"> <?php echo $urun_miktari_err; ?> </div>

          </div>

         <div class="mb-3">
            <label for="tohum_sertifikasi" class="form-label">Tohum Sertifikası</label>
            <input type="file" class="form-control" id= "tohum_sertifikasi" name="tohum_sertifikasi">
        </div>

         <div class="mb-3">
            <label for="toprak_analizi" class="form-label">Toprak Analizi</label>
            <input type="file" class="form-control" id= "toprak_analizi" name="toprak_analizi">
        </div>

        <div class="mb-3">
          <label for="tarim_teknigi" class="form-label">Tarım Tekniği</label>
          <select class="form-select <?php if(!empty($tarim_teknigi_err)){echo "is-invalid";} ?>" id= "tarim_teknigi" name="tarim_teknigi">
               <option value="" disabled selected>Seçiniz</option>
               <option value="Organik Tarım">Organik Tarım</option>
               <option value="Geleneksel Tarım">Geleneksel Tarım</option>
               <option value="Sera">Sera</option>
               <option value="Diğer">Diğer</option>
           </select>
           <div id="validationServerUsernameFeedback" class="invalid-feedback"> <?php echo $tarim_teknigi_err; ?> </div>
         </div>
     
         <button type="submit" name="kaydet" class="btn btn-primary">KAYDET</button>

  </form>

</div>

<script src="https://code.jquery.com/jquery-3.6.4.slim.js" integrity="sha256-dWvV84T6BhzO4vG6gWhsWVKVoa4lVmLnpBOZh/CAHU4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<script>
  $(document).ready(function(){
    // Formun action URL'sinden tarla_id değerini al
    let tarlaId = new URLSearchParams(window.location.search).get("tarla_id");

    // Diğer kodlar buraya gelecek...

    $("select[name='urun_tip']").on("change", function(){
      let urunTip = $(this).val();
      console.log(urunTip);
      if(urunTip == 0){
        $("#meyveContent").removeClass("d-none");
        $("#tekyillikContent").addClass("d-none");
        // Meyve Ağacı seçildiğinde "Meyve Adı" seçimi zorunlu olsun
        $("#meyve_adi").prop('required', true);
        $("#ekilecek_urun").prop('required', false);
        $("#ekim_tarihi").prop('required', false);
      } else  {
        $("#meyveContent").addClass("d-none");
        $("#tekyillikContent").removeClass("d-none");
        // Tek Yıllık seçildiğinde "Ekilecek Ürün" ve "Ekim Tarihi" seçimleri zorunlu olsun
        $("#ekilecek_urun").prop('required', true);
        $("#ekim_tarihi").prop('required', true);
        $("#meyve_adi").prop('required', false);
      }
    });

   
  });
</script>



</body>
</html>