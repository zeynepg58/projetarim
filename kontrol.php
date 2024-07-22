
<?php
include("baglanti.php");

// Tarla ID'sini alalım
$tarla_id = isset($_GET["tarla_id"]) ? $_GET["tarla_id"] : '';

// Tarlada mevcut ürün sayısını sorgulayalım
$query = "SELECT COUNT(*) as urun_sayisi FROM urunler WHERE tarla_id = :tarla_id";
$statement = $baglanti->prepare($query);
$statement->bindValue(':tarla_id', $tarla_id);
$statement->execute();
$urun_sayisi = $statement->fetch(PDO::FETCH_ASSOC)['urun_sayisi'];

// Eğer tarlada zaten bir ürün varsa, bir hata mesajı döndürelim
if ($urun_sayisi > 0) {
    // Hata mesajını döndür
    echo "Bu tarlada zaten bir ürün bulunmaktadır. İkinci bir ürün eklenemez.";
} else {
    // Tarlada ürün yoksa, boş bir yanıt döndür
    echo "";
}
?>





