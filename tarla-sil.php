<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<?php
// Tarla ID'sini al
if(isset($_GET['tarla_id'])) {
    $tarlaID = $_GET['tarla_id'];

    // Veritabanı bağlantısı
    include("baglanti.php");

    // Tarla silme sorgusu
    $query = "DELETE FROM tarlalar WHERE id = :tarla_id";
    $statement = $baglanti->prepare($query);
    $statement->bindParam(':tarla_id', $tarlaID);
    
    // Sorguyu çalıştır
    if($statement->execute()) {
        // Silme başarılı oldu, kullanıcıyı yönlendir
        header("Location: ciftci-index.php");
        exit();
    } else {
        // Silme başarısız oldu, hata mesajı göster
        echo "Tarla silinirken bir hata oluştu.";
    }
} else {
    // Tarla ID'si belirtilmedi, hata mesajı göster
    echo "Tarla ID belirtilmedi.";
}
?>

</body>
</html>