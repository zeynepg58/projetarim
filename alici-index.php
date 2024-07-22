<!DOCTYPE html>
<html lang="en">
<head>
  <title>Alıcı Anasayfa</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="public/css/style.css"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  


<nav class="navbar navbar-expand-lg bg-body-tertiary navbar bg-dark" data-bs-theme="dark">
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
         <a href="alt_kullanici_ekle.php" class="nav-link" style="display: inline-block; ">
            <span style="white-space: nowrap;">Alt Kullanıcı Ekle</span>
         </a>
       </div>

       <form class="d-flex">
         <!-- <input class="form-control me-2" type="search" placeholder="Ara" aria-label="Ara"> -->
        <div class="input-group" style="width: 200px; margin-left:650px; ">
           <input type="text" class="form-control" id="arama" name="arama" placeholder="Tarla Adı Ara" style=" background-color: #fff; border: 4px solid #ccc; border-radius: 5px;">
           <button class="btn btn-outline-light text-white" type="submit"><i class="fas fa-search"></i></button>
        </div>
        </form>
       <div class="navbar-nav ms-auto">
         <a class="nav-link" href="alici-profil.php">Profil</a>
         
       </div>
     </div>
   </div>
 </nav>
 </head>
<body>



            <div class="container ">
              <div class="row">
              <div class="col-lg-3 col-md-4" style="background:#dedede;padding:10px;padding-left: 10px;">
                  <form method="GET" action="alici-index.php" enctype="multipart/form-data">
                 
                          <!-- Ürün Miiktarı -->
                          <label for="miktar" class="form-label" style="font-weight: bold; font-size: 20px; margin-top: 20px;" >Ürün Miktarı (Ton)</label>
                          <div  style=" margin-bottom: 2px;"></div>
                          <input type="number" class="min" name="min" placeholder="min" value="<?php echo $min; ?>" style="width: 100px; height: 40px; border: 4px solid #ccc; border-radius: 5px;">
                          <span style="margin: 1px;">-</span>
                          <input type="number" class="max" name="max" placeholder=" max" value="<?php echo $max; ?>"  style="width: 100px; height: 40px; border: 4px solid #ccc; border-radius: 5px; ">
                          <button type="submit" id="araButton" style="display: none; width: 60px; height: 40px; border: 4px solid #ccc; border-radius: 5px;">Ara</button>
                          
                          <!-- Tarım Tekniği -->
                          <br>
                          <label for="checkbox" style="font-weight: bold; font-size: 20px; margin-top: 25px;">Tarım Tekniği</label>
                          <br>
                          <input type="checkbox" name="tarim_teknigi[]" value="organik" id="organik" style="margin-top: 10px; transform: scale(1.5);">
                          <label for="organik_checkbox" style=" margin-left: 5px;">Organik Tarım</label>
                          <br>
                          <input type="checkbox" name="tarim_teknigi[]" value="geleneksel" id="geleneksel" style="margin-top: 10px; transform: scale(1.5);">
                          <label for="geleneksel_checkbox" style=" margin-left: 5px;">Geleneksel Tarım</label>
                          <br>
                          <input type="checkbox" name="tarim_teknigi[]" value="sera" id="checkbox" style="margin-top: 10px; transform: scale(1.5);">
                          <label for="checkbox" style=" margin-left: 5px;">Sera</label>
                          <br>
                          <input type="checkbox" name="tarim_teknigi[]" value="iyi tarım uygulamaları" id="checkbox" style="margin-top: 10px; transform: scale(1.5);">
                          <label for="checkbox" style=" margin-left: 5px;">İyi Tarım Uygulamaları</label>
                          <br>
                          <input type="checkbox" name="tarim_teknigi[]" value="diger" id="checkbox" style="margin-top: 10px; transform: scale(1.5);">
                          <label for="checkbox" style=" margin-left: 5px;">Diğer</label>
                          
                          <!-- Bölge -->
                          <br>
                          <label for="checkbox" style="font-weight: bold; font-size: 20px; margin-top: 25px;">Bölge</label>
                          <br>
                          <select name="il" id="il" onchange="getIlceler(this.value)" style="width: 200px; height: 40px; border: 4px solid #ccc; border-radius: 5px;" >
                                  <option value="" disabled selected>İl</option>
                                  <option value="adana">Adana</option>
                                  <option value="adıyaman">Adıyaman</option>
                                  <option value="afyonkarahisar">Afyonkarahisar</option>
                                  <option value="ağrı">Ağrı</option>
                                  <option value="amasya">Amasya</option>
                                  <option value="ankara">Ankara</option>
                                  <option value="antalya">Antalya</option>
                                  <option value="artvin">Artvin</option>
                                  <option value="aydın">Aydın</option>
                                  <option value="balıkesir">Balıkesir</option>
                                  <option value="bilecik">Bilecik</option>
                                  <option value="bingöl">Bingöl</option>
                                  <option value="bitlis">Bitlis</option>
                                  <option value="bolu">Bolu</option>
                                  <option value="burdur">Burdur</option>
                                  <option value="bursa">Bursa</option>
                                  <option value="çanakkale">Çanakkale</option>
                                  <option value="çankırı">Çankırı</option>
                                  <option value="çorum">Çorum</option>
                                  <option value="denizli">Denizli</option>
                                  <option value="diyarbakır">Diyarbakır</option>
                                  <option value="edirne">Edirne</option>
                                  <option value="elazığ">Elazığ</option>
                                  <option value="erzincan">Erzincan</option>
                                  <option value="erzurum">Erzurum</option>
                                  <option value="eskişehir">Eskişehir</option>
                                  <option value="gaziantep">Gaziantep</option>
                                  <option value="giresun">Giresun</option>
                                  <option value="gümüşhane">Gümüşhane</option>
                                  <option value="hakkari">Hakkari</option>
                                  <option value="hatay">Hatay</option>
                                  <option value="ısparta">Isparta</option>
                                  <option value="mersin">Mersin</option>
                                  <option value="istanbul">İstanbul</option>
                                  <option value="izmir">İzmir</option>
                                  <option value="kars">Kars</option>
                                  <option value="kastamonu">Kastamonu</option>
                                  <option value="kayseri">Kayseri</option>
                                  <option value="kırklareli">Kırklareli</option>
                                  <option value="kırşehir">Kırşehir</option>
                                  <option value="kocaeli">Kocaeli</option>
                                  <option value="konya">Konya</option>
                                  <option value="kütahya">Kütahya</option>
                                  <option value="malatya">Malatya</option>
                                  <option value="manisa">Manisa</option>
                                  <option value="kahramanmaraş">Kahramanmaraş</option>
                                  <option value="mardin">Mardin</option>
                                  <option value="muğla">Muğla</option>
                                  <option value="muş">Muş</option>
                                  <option value="nevşehir">Nevşehir</option>
                                  <option value="niğde">Niğde</option>
                                  <option value="ordu">Ordu</option>
                                  <option value="rize">Rize</option>
                                  <option value="sakarya">Sakarya</option>
                                  <option value="samsun">Samsun</option>
                                  <option value="siirt">Siirt</option>
                                  <option value="sinop">Sinop</option>
                                  <option value="sivas">Sivas</option>
                                  <option value="tekirdağ">Tekirdağ</option>
                                  <option value="tokat">Tokat</option>
                                  <option value="trabzon">Trabzon</option>
                                  <option value="tunceli">Tunceli</option>
                                  <option value="şanlıurfa">Şanlıurfa</option>
                                  <option value="uşak">Uşak</option>
                                  <option value="van">Van</option>
                                  <option value="yozgat">Yozgat</option>
                                  <option value="zonguldak">Zonguldak</option>
                                  <option value="aksaray">Aksaray</option>
                                  <option value="bayburt">Bayburt</option>
                                  <option value="karaman">Karaman</option>
                                  <option value="kırıkkale">Kırıkkale</option>
                                  <option value="batman">Batman</option>
                                  <option value="şırnak">Şırnak</option>
                                  <option value="bartın">Bartın</option>
                                  <option value="ardahan">Ardahan</option>
                                  <option value="ığdır">Iğdır</option>
                                  <option value="yalova">Yalova</option>
                                  <option value="karabük">Karabük</option>
                                  <option value="kilis">Kilis</option>
                                  <option value="osmaniye">Osmaniye</optio>
                                  <option value="düzce">Düzce</option>
                          </select>
                
                          <select name="ilce" id="ilce" style="width: 200px; height: 40px; border: 4px solid #ccc; border-radius: 5px;" >
                                  <option value="" disabled selected>İlçe</option>
                          </select>
                              <br>
                              <input type="text" class="form-control" id="koy" name="koy" placeholder=" Köy" style="width: 200px; height: 40px; border: 4px solid #ccc; border-radius: 5px;" >
                              <!-- <input type="text" class="form-control" id="arama" name="arama" placeholder=" Tarla Adı Ara" style="width: 200px; height: 40px; border: 4px solid #ccc; border-radius: 5px;" > -->
                          
                            <!-- Sözleşmeli Tarım -->
                          <br>
                          <label for="checkbox" style="font-weight: bold; font-size: 20px; ">Sözleşmeli Tarım </label>
                          <br>
                          <input type="checkbox" name="checkbox" id="checkbox" style="margin-top: 10px; transform: scale(1.5);">
                          <label for="checkbox" style=" margin-left: 5px;">Evet </label>
                          <br>
                          <input type="checkbox" name="checkbox" id="checkbox" style="margin-top: 10px; transform: scale(1.5);">
                          <label for="checkbox" style=" margin-left: 5px;">Hayır </label> 
                                
                          <!-- Hasat Tarihi -->
                          <br>
                          <label for="checkbox" style="font-weight: bold; font-size: 20px; margin-top :10px">Hasat Zamanı  </label>
                          <input type="month" class="form-control" name="hasat_zamani" id="hasat_zamani">
                        
                          <!-- Belgeler -->
                          <br>
                          <label for="checkbox" style="font-weight: bold; font-size: 20px; ">Sertifika </label>
                          <br>
                          <input type="checkbox" name="checkbox" id="checkbox" style="margin-top: 10px; transform: scale(1.5);">
                          <label for="checkbox" style=" margin-left: 5px;">Tohum Sartifikası </label>
                          <br>
                          <input type="checkbox" name="checkbox" id="checkbox" style="margin-top: 10px; transform: scale(1.5);">
                          <label for="checkbox" style=" margin-left: 5px;">Toprak Analiz Sertifikası </label> 
                        
                          <br>
                          <button class= "btn btn-dark" type="submit" id="ara" name="ara" style="width: 270px; height: 50px; border: 4px solid #ccc; border-radius: 5px; margin-top :20px;" >Ara</button>
                    
                  </form>
                   </div>  
                      <div class="col-lg-3 col-md-4" style="margin-top:50px;">
                        <?php
                          @session_start();
                          include("baglanti.php");
                          $min = "";
                          $max = "";
                          $tarlaSorgusu = "";
                          
                          if (isset($_GET)) {
                          
                          $hasat_zamani = isset($_GET['hasat_zamani']) ? $_GET['hasat_zamani'] : "";
                          $hasat_zamani = $hasat_zamani != "" ? date('Y-m', strtotime($hasat_zamani)) : "";
                          $min = isset($_GET['min']) ? $_GET['min'] : "";
                          $max = isset($_GET['max']) ? $_GET['max'] : "";
                          $il = isset($_GET['il']) ? $_GET['il'] : "";
                          $ilce = isset($_GET['ilce']) ? $_GET['ilce'] : "";
                          $koy = isset($_GET['koy']) ? $_GET['koy'] : "";
                          $arama = isset($_GET['arama']) ? $_GET['arama'] : "";
                          $secilenTarimTeknigi = isset($_GET['tarim_teknigi']) ? (array) $_GET['tarim_teknigi'] : [];
                          
                          
                          if (!empty($secilenTarimTeknigi)) {
                              $tarimTeknikleri = [];
                          
                              foreach ($secilenTarimTeknigi as $tarimTeknigi) {
                                  if ($tarimTeknigi === 'organik') {
                                      $tarimTeknikleri[] = "urunler.tarim_teknigi = 'Organik Tarım'";
                                  } elseif ($tarimTeknigi === 'geleneksel') {
                                      $tarimTeknikleri[] = "urunler.tarim_teknigi = 'Geleneksel Tarım'";
                                  } elseif ($tarimTeknigi === 'sera') {
                                      $tarimTeknikleri[] = "urunler.tarim_teknigi = 'Sera'";
                                  } elseif ($tarimTeknigi === 'diger') {
                                      $tarimTeknikleri[] = "urunler.tarim_teknigi = 'Diğer'";
                                  }
                              }
                              $tarlaSorgusu = '(' . implode(' OR ', $tarimTeknikleri) . ') AND';
                          }
                          
                          if($min != ""){
                            $tarlaSorgusu .= "(urunler.urun_miktari <= ".$max." AND urunler.urun_miktari >= ".$min.") AND";
                          }
                          
                          if($il != ""){
                            $tarlaSorgusu .= "(tarlalar.tarla_adresi LIKE '%".$il."%') AND";
                          }
                          if($ilce != ""){
                            $tarlaSorgusu .= "(tarlalar.tarla_adresi LIKE '%".$ilce."%') AND";
                          }
                          if($koy != ""){
                            $tarlaSorgusu .= "(tarlalar.tarla_adresi LIKE '%".$koy."%') AND";
                          }
                          if($arama != ""){
                            $tarlaSorgusu .= "(tarlalar.tarla_adi LIKE '%".$arama."%') AND";
                           }
                          
                           if($tarlaSorgusu != ""){
                            $tarlaSorgusu = " WHERE ".rtrim($tarlaSorgusu, "AND");
                           }
                          
                           if ($hasat_zamani != "") {
                            // Girilen yıl ve ay bilgisini ayrıştır
                            $hasat_tarihi = strtotime($hasat_zamani);
                            $yil = date('Y', $hasat_tarihi);
                            $ay = date('m', $hasat_tarihi);
                           } else {
                            $yil = "";
                            $ay = "";
                           }
                          
                           $sorgu = "SELECT urunler.*, tarlalar.* 
                                    FROM urunler 
                                    INNER JOIN tarlalar ON urunler.tarla_id = tarlalar.id" . $tarlaSorgusu;
                          
                           if ($hasat_zamani != "") {
                           $sorgu .= " AND DATE_FORMAT(urunler.hasat_zamani, '%Y-%m') = '$hasat_zamani'";
                           }
                          
                          
                          
                           //TARLA CARDs
                            // $sonuclar = $baglanti->query($sorgu);
                            // echo '<div class="col-lg-9 col-md-8 row">';
                            // while ($row = $sonuclar->fetch(PDO::FETCH_ASSOC)) {
                            //     $tarlaID = $row['tarla_id'];
                            //     $gorselYolu = '/uyelik/Tarlalar/' . $tarlaID . '/Tarla-Gorseli.jpg';
                            //     echo '<div class="col-lg-6 col-md-6">';
                            //     echo '<div class="tarla-bilgileri" style="width: 200px; margin-right:100px;">';
                            //     echo '<a href="' . $gorselYolu . '" target="_blank">'; // Yeni sekme için tarla resmini açan link
                            //     echo '<div class="tarla-ad">' . $row['tarla_adi'] . '</div>';
                            //     echo '<div class="img-container">';
                            //     echo '<img src="' . $gorselYolu . '" class="card" style="width: 18rem;" "' . $tarlaID . '" width="5" height="100">';
                            //     echo '</div>';
                            //     echo '</a>';
                            //     echo '<div class="tarim-teknigi">Tarım Tekniği: ' . $row['tarim_teknigi'] . '</div>';
                            //     echo '<div class="tarla-adresi">Tarla Adresi: ' . $row['tarla_adresi'] . '</div>';
                            //     echo '</div>';
                            //     echo '</div>';
                            //     echo "<br>";
                            // }
                            // echo '</div>';
                            // }
                          
                          
                         
                           //Tarlalar tablo halinde 
                           $sonuclar = $baglanti->query($sorgu);
                           echo '<div class="container">';
                           echo '<div class="row">';
                           echo '<div class="col-lg-3 col-md-4">';
                           echo '<!-- Filtreleme Bölümü -->';
                           echo '<form method="GET" action="alici-index.php" enctype="multipart/form-data">';
                           echo '</form>';
                           echo '</div>';
                           echo '<div class="col-lg-9 col-md-8">';
                           echo '<table class="table table-bordered">';
                           echo '<thead>';
                           echo '<tr>';
                           echo '<th>Tarla Adı</th>';
                           echo '<th>Görsel</th>'; 
                           echo '<th>Tarım Tekniği</th>';
                           echo '<th>Tarla Adresi</th>';
                           echo '<th>Hasat Zamanı</th>';
                           echo '</tr>';
                           echo '</thead>';
                           echo '<tbody>';

                        
                          
                           while ($row = $sonuclar->fetch(PDO::FETCH_ASSOC)) {
                               $tarlaID = $row['tarla_id'];
                               $gorselYolu = '/uyelik/Tarlalar/' . $tarlaID . '/Tarla-Gorseli.jpg';
                               echo '<tr>';
                               echo '<td><a href="' . $gorselYolu . '" target="_blank">' . $row['tarla_adi'] . '</a></td>';
                               echo '<td><img src="' . $gorselYolu . '" alt="' . $row['tarla_adi'] . ' Görsel" style="max-width: 100px; max-height: 100px;"></td>';
                               echo '<td>' . $row['tarim_teknigi'] . '</td>';
                               echo '<td>' . $row['tarla_adresi'] . '</td>';
                               echo '<td>' . $row['hasat_zamani'] . '</td>';
                               echo '</tr>';
                           }
                          
                          echo '</tbody>';
                          echo '</table>';
                          echo '</div>';
                          echo '</div>';
                          echo '</div>';
                             }
                         ?>
                      </div>
                  </div>
             </div>
    
 <script>

 function showDetails(tarlaID) {
 // Tarla detaylarını yeni sekmede görüntüle
 var url = '/uyelik/Tarlalar/' + tarlaID + '/Tarla-Gorseli.jpg';
 var newWindow = window.open(url, '_blank');
 newWindow.focus();
}

    var minInput = document.querySelector('.min');
    var maxInput = document.querySelector('.max');
    var araButton = document.querySelector('#araButton');

    minInput.addEventListener('focus', function() {
        araButton.style.display = 'inline-block';
    });

    maxInput.addEventListener('focus', function() {
        araButton.style.display = 'inline-block';
    });


    function getIlceler(selectedIl) {
    var ilceler = document.getElementById("ilce");
    ilceler.innerHTML = ""; // Mevcut ilçe seçeneklerini temizliyoruz

    if (selectedIl === "ankara") {
      ilceler.innerHTML += "<option value='' disabled selected>İlçe</option>";
      ilceler.innerHTML += "<option value='ceylanpınar'>Ceylanpınar</option>";
      ilceler.innerHTML += "<option value='kızılay'>Kızılay</option>";
      ilceler.innerHTML += "<option value='ulus'>Ulus</option>";
    } else if (selectedIl === "İstanbul") {
      ilceler.innerHTML = "<option value='kadıköy'>Kadıköy</option>";
      ilceler.innerHTML = "<option value='beşiktaş'>Beşiktaş</option>";
      ilceler.innerHTML = "<option value='şişli'>Şişli</option>";
    } else if (selectedIl === "İzmir") {
      ilceler.innerHTML = "<option value='karşıyaka'>Karşıyaka</option>";
      ilceler.innerHTML = "<option value='bornova'>Bornova</option>";
      ilceler.innerHTML = "<option value='konak'>Konak</option>";
    }
  }


  document.getElementById("ara").addEventListener("click", function() {
    var seciliTarih = document.getElementById("hasatTarihi").value;
    var ay = seciliTarih.split("-")[1];
    var yil = seciliTarih.split("-")[0];

    // Tarla verilerini tarihe göre filtrele
    var filtreliTarlaVerileri = tarlaVerileri.filter(function(tarla) {
      var tarlaTarihi = tarla.hasatTarihi;
      var tarlaAy = tarlaTarihi.split("-")[1];
      var tarlaYil = tarlaTarihi.split("-")[0];
      
      // Ay ve yıl eşleşmesini kontrol et
      return tarlaAy === ay && tarlaYil === yil;
    });

    // Filtrelenen tarla verilerini işle veya görüntüle
    console.log(filtreliTarlaVerileri);
  });
  </script>



<script src="public/js/main.js"></script>

</body>
</html>
