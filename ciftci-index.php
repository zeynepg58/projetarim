
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Çiftçi Anasayfa</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="public/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <script src="public/js/main.js"></script>
 
</head>
<body>

 <nav class="navbar navbar-expand-lg bg-body-tertiary  navbar bg-dark" data-bs-theme="dark" >
   <div class="container">
     <a class="navbar-brand" href="ciftci-index.php">ÇİFTÇİ ANA SAYFA</a>
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
   <div>
     <h1 style="font-size: 24px;">tarlam</h1>
      <div >
        <a class="btn btn-dark" href="tarla-ekle.php" style="width: 70px; height: 28x;">
        <i class='far fa-plus' style='font-size:30px; color:white'></i></a>
      </div>
   </div>
 </div>

 <div class="container pt-5">
  
 <?php
     
include("baglanti.php");
session_start();

try {
  $kullaniciBilgiler = $_SESSION['kullaniciBilgiler'];
  $kullanici_id = $kullaniciBilgiler['id'];

  $query = "SELECT * FROM tarlalar WHERE kullanici_id = :kullanici_id";
  $statement = $baglanti->prepare($query);
  $statement->bindValue(':kullanici_id', $kullanici_id);
  $statement->execute();

  $result = $statement->fetchAll(PDO::FETCH_ASSOC);

  if (count($result) > 0) {
    echo '<div class="table-responsive">
    <table class="table table-striped">
    <thead>  
          <tr>
              <th>Tarla Resmi</th>
              <th>Tarla Adı</th>
              <th>Ürünler</th>
              <th>İşlemler</th>
           </tr>
          </thead>
          <tbody>
          </div>';

    foreach ($result as $row) {
      $tarlaAdi = $row['tarla_adi'];
      $tarlaID = $row['id'];
      $target_file = "Tarlalar/" . $tarlaID;
      $tarlaGorseliDosyaAdi = basename($row["tarla_gorseli"]);

      $query = "SELECT * FROM urunler WHERE tarla_id = :tarla_id";
      $statement = $baglanti->prepare($query);
      $statement->bindValue(':tarla_id', $tarlaID);
      $statement->execute();
      $urunler = $statement->fetchAll(PDO::FETCH_ASSOC);
      
      $urunlerHtml = '';
      foreach ($urunler as $urun) {
        if ($urun["urun_tip"] == 0) {
          $urunAd = $urun["meyve_adi"];
        } else {
          $urunAd = $urun["ekilecek_urun"];
        }
        $urunlerHtml .= '<a href="urun-duzenle.php?urun_id=' . $urun['urun_id'] . '" class="btn btn-dark">' . $urunAd . '</a>';
      }
     
      
      echo '<tr>
              <td><img src="' . $target_file . "/" . $tarlaGorseliDosyaAdi . '" alt="' . $tarlaAdi . '" width="150" height="100"></td>
              <td style="vertical-align: middle;">' . $tarlaAdi . '</td>
              <td style="vertical-align: middle;">' . $urunlerHtml . '</td>
              <td style="vertical-align: middle;">
              <a href="urun-ekle.php?tarla_id=' . $tarlaID . '"   class="urunEkleBtn btn btn-dark">Ürün Ekle</a>
               
               
               
                <!-- Modal -->
                <div class="modal fade" id="uyariModal" tabindex="-1" aria-labelledby="uyariModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="uyariModalLabel">Uyarı</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body" id="uyariMesaji">
                        <!-- Uyarı mesajı buraya gelecek -->
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                      </div>
                    </div>
                  </div>
                </div>
                
             
                <a href="tarla-duzenle.php?tarla_id=' . $tarlaID . '" class="btn btn-dark">Tarla Düzenle</a>
                <a href="tarla-sil.php?tarla_id=' . $tarlaID . '" class="btn btn-dark" onclick="return confirmDelete();">Tarla Sil</a>
                
                </td>
            </tr>';
    }

    echo '</tbody></table>';
  } else {
    echo "Kayıt bulunamadı.";
  }
} catch (PDOException $e) {
  die($e->getMessage());
}
$baglanti = null;
?>

</div>

<!-- <style>
 


    .img-container {
        width: 100%;
        height: 200px; /* İstediğiniz boyutu burada belirleyebilirsiniz */
        overflow: hidden;
    }

    .img-container img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
</style> -->
 

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

function confirmDelete() {
    return confirm('Bu tarlayı silmek istediğinizden emin misiniz?');
}


$(document).ready(function() {
  function showUyariModal(mesaj) {
    $('#uyariMesaji').text(mesaj);
    $('#uyariModal').modal('show');
  }

  // AJAX isteği
  $('.urunEkleBtn').click(function(e) {
    e.preventDefault();
    var tarla_id = $(this).attr('href').split('=')[1];
    
    $.ajax({
      type: 'GET',
      url: 'kontrol.php',
      data: { tarla_id: tarla_id },
      success: function(response) {
        if (response.trim() !== '') {
          showUyariModal(response); // Uyarı modalını göster
        } else {
          window.location.href = 'urun-ekle.php?tarla_id=' + tarla_id;
        }
      }
    });
  });
}); 
 
</script>
</body>
</html>