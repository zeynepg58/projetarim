
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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

$urun_tip = "";
$meyve_adi = "";
$ekilecek_urun = "";
$ekim_tarihi = "";
$hasat_zamani = "";
$urun_miktari = "";
$tohum_sertifikasi = "";
$tarim_teknigi = "";

if (isset($_GET['urun_id'])) 
{
  $urunID = $_GET['urun_id'];
    
    
    try {
        // Veritabanından kaydı çekme
        $query = $baglanti->prepare("SELECT urun_tip, meyve_adi, ekilecek_urun, ekim_tarihi, hasat_zamani, urun_miktari, tohum_sertifikasi, tarim_teknigi  FROM urunler WHERE urun_id = :urun_id");
        $query->bindValue(':urun_id', $urunID);
        $query->execute();
      

        if ($query->rowCount() > 0) {
            // Kayıt bulundu
            $row = $query->fetch(PDO::FETCH_ASSOC);

            // Kaydı kullanarak forma ön tanımlı değerleri ekliyoruz
            $urun_tip = $row['urun_tip'];
            $meyve_adi = $row['meyve_adi'];
            $ekilecek_urun = $row['ekilecek_urun'];
            $ekim_tarihi = $row['ekim_tarihi'];
            $hasat_zamani = $row['hasat_zamani'];
            $urun_miktari = $row['urun_miktari'];
            $tohum_sertifikasi = $row['tohum_sertifikasi'];
            $tarim_teknigi = $row['tarim_teknigi'];

            // İlgili form alanlarını çekme
            if ($urun_tip == 0) {
              // Meyve ağacı seçiliyse sadece meyve adı alanını çek
              $query = $baglanti->prepare("SELECT meyve_adi FROM urunler WHERE urun_id = :urun_id");
              $query->bindValue(':urun_id', $urunID);
              $query->execute();

              if ($query->rowCount() > 0) {
                  $row = $query->fetch(PDO::FETCH_ASSOC);
                  $meyve_adi = $row['meyve_adi'];
              }
          } else {
              // Tek yıllık seçiliyse sadece ekilecek ürün ve ekim tarihi alanlarını çek
              $query = $baglanti->prepare("SELECT ekilecek_urun, ekim_tarihi FROM urunler WHERE urun_id = :urun_id");
              $query->bindValue(':urun_id', $urunID);
              $query->execute();

              if ($query->rowCount() > 0) {
                  $row = $query->fetch(PDO::FETCH_ASSOC);
                  $ekilecek_urun = $row['ekilecek_urun'];
                  $ekim_tarihi = $row['ekim_tarihi'];
              }
          }
        } 
        
        else {
            // Kayıt bulunamadı
            echo "Kayıt bulunamadı.";
        }
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Formdan gelen verileri al
  $urun_tip = $_POST['urun_tip'];
  $meyve_adi = $_POST['meyve_adi'];
  $ekilecek_urun =$_POST["ekilecek_urun"];
  $ekim_tarihi = $_POST['ekim_tarihi'];
  $hasat_zamani = $_POST['hasat_zamani'];
  $urun_miktari = $_POST['urun_miktari'];
  $tohum_sertifikasi = isset($_FILES["tohum_sertifikasi"]["name"]) ? $_FILES["tohum_sertifikasi"]["name"] : "";
  $tarim_teknigi = $_POST['tarim_teknigi'];
  $urunID = $_POST['urun_id'];
  $tarlaID = $_POST['tarla_id']; // Formdan tarla_id değerini al
  
  
  // Güncelleme işlemini gerçekleştir
  try {

    // Önceki ürün tipine göre ilgili alanları boşaltma
    if ($urun_tip == 0) {
      $ekilecek_urun = "";
      $ekim_tarihi = "";
  } else {
      $meyve_adi = "";
  }
  
    $query = $baglanti->prepare("UPDATE urunler SET urun_tip = :urun_tip, meyve_adi = :meyve_adi, ekilecek_urun = :ekilecek_urun, ekim_tarihi = :ekim_tarihi, hasat_zamani = :hasat_zamani, urun_miktari = :urun_miktari, tohum_sertifikasi = :tohum_sertifikasi, tarim_teknigi = :tarim_teknigi WHERE urun_id = :urun_id");
    $query->bindValue(':urun_tip', $urun_tip);
    $query->bindValue(':meyve_adi', $meyve_adi);
    $query->bindValue(':ekilecek_urun', $ekilecek_urun);
    $query->bindValue(':ekim_tarihi', $ekim_tarihi);
    $query->bindValue(':hasat_zamani', $hasat_zamani);
    $query->bindValue(':urun_miktari', $urun_miktari);
    $query->bindValue(':tohum_sertifikasi', $tohum_sertifikasi);
    $query->bindValue(':tarim_teknigi', $tarim_teknigi);
    $query->bindValue(':urun_id', $urunID);

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
   <form method="POST" action="urun-duzenle.php" enctype="multipart/form-data">


   <!-- URUN TİP -->
<div class="mb-3">
    <label for="urun_tip" class="form-label">Ekilecek ürün Meyve Ağacı mı? Tek Yıllık mı?</label>
    <select class="form-select <?php if(!empty($urun_tip_err)){echo "is-invalid";} ?>" name="urun_tip" id="urun_tip">
        <option value="" disabled selected>Seçiniz</option>
        <option value="0" <?php if($urun_tip == 0) echo "selected"; ?>>Meyve Ağacı</option>
        <option value="1" <?php if($urun_tip == 1) echo "selected"; ?>>Tek Yıllık</option>
    </select>
    <div id="urun_tip" class="invalid-feedback"> <?php echo $urun_tip_err; ?> </div>
</div>

    <!-- meyve ağacı -->
<div class="mb-3 <?php if($urun_tip != 0) echo "d-none"; ?>" id="meyveContent">
    <div class="mb-3">
        <label for="meyve_adi" class="form-label">Meyve Adı</label>
        <select class="form-select " id="meyve_adi" name="meyve_adi">
            <option value="<?php echo $meyve_adi; ?>"><?php echo $meyve_adi; ?></option>
            <option value="Elma">Elma</option>
               <option value="Kayısı">Kayısı</option>
               <option value="Armut">Armut</option>
               <option value="Erik">Erik</option>
          </select>
    </div>
</div>

<!-- tek yıllık -->
<div class="mb-3 <?php if($urun_tip != 1) echo "d-none"; ?>" id="tekyillikContent">
    <div class="mb-3">
        <label for="ekilecek_urun" class="form-label ">Ekilecek Ürün</label>
        <input type="text" class="form-control" id="ekilecek_urun" name="ekilecek_urun" value="<?php echo htmlspecialchars($ekilecek_urun); ?>">
    </div>

    <div class="mb-3">
        <label for="ekim_tarihi" class="form-label ">Ekim Tarihi </label>
        <input type="date" class="form-control" id="ekim_tarihi" name="ekim_tarihi" value="<?php echo htmlspecialchars($ekim_tarihi); ?>">
    </div>
</div>


   <div class="mb-3">
        <label for="hasat_zamani" class="form-label">Tahmini Hasat Zamanı</label>
        <input type="date" class="form-control" id="hasat_zamani" name="hasat_zamani" value="<?php echo htmlspecialchars($hasat_zamani); ?>">
   </div>

   <div class="mb-3">
        <label for="urun_miktari" class="form-label">Tahmini Ürün Miktarı</label>
        <input type="text" class="form-control"  id="urun_miktari" name="urun_miktari" value="<?php echo htmlspecialchars($urun_miktari); ?>">
   </div>

   <div class="mb-3">
        <label for="tohum_sertifikasi" class="form-label">Tohum Sertifikası </label>
        <input type="file" class="form-control" id="tohum_sertifikasi" name="tohum_sertifikasi" value="<?php echo htmlspecialchars($tohum_sertifikasi); ?>">
   </div>

   <div class="mb-3">
        <label for="tarim_teknigi" class="form-label">Tarım Tekniği </label>
        <input type="text" class="form-control" id="tarim_teknigi" name="tarim_teknigi" value="<?php echo htmlspecialchars($tarim_teknigi); ?>">
   </div>

        <input type="hidden" name="urun_id" value="<?php echo $urunID ?>">
        <button type="submit" class="btn btn-primary">Kaydet</button>
   </form>
 </div>
 


<script src="https://code.jquery.com/jquery-3.6.4.slim.js" integrity="sha256-dWvV84T6BhzO4vG6gWhsWVKVoa4lVmLnpBOZh/CAHU4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

<script>
  $(document).ready(function(){
    // Formun action URL'sinden tarla_id değerini al
    let tarlaId = new URLSearchParams(window.location.search).get("tarla_id");

    // urun_tip değerine göre ilgili form alanlarını göster veya gizle
    function toggleFormFields(urunTip) {
        if(urunTip == 0) {
            $("#meyveContent").removeClass("d-none");
            $("#tekyillikContent").addClass("d-none");
        } else {
            $("#meyveContent").addClass("d-none");
            $("#tekyillikContent").removeClass("d-none");
        }
    }

    // urun_tip değeri değiştiğinde ilgili form alanlarını güncelle
    $("select[name='urun_tip']").on("change", function(){
        let urunTip = $(this).val();
        console.log(urunTip);
        toggleFormFields(urunTip);
    });

    // Sayfa yüklendiğinde de urun_tip değerine göre form alanlarını güncelle
    let urunTip = "<?php echo $urun_tip; ?>";
    toggleFormFields(urunTip);
});

</script>



</body>
</html>