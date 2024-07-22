<?php
include("baglanti.php");

if (isset($_POST["il"])) {
    $il_adi = $_POST["il"];

    // Veritabanından il id'sini çek
    $queryIl = $baglanti->prepare("SELECT il_id FROM iller WHERE il_adi = ?");
    $queryIl->execute([$il_adi]);
    $il_id = $queryIl->fetchColumn();

    // Veritabanından ilçeleri çek
    $ilceler = array();
    $queryIlce = $baglanti->prepare("SELECT ilce_adi FROM ilceler WHERE il_id = ?");
    $queryIlce->execute([$il_id]);
    while ($row = $queryIlce->fetch(PDO::FETCH_ASSOC)) {
        $ilceler[] = $row;
    }

    // Sonuçları JSON formatında döndür
    echo json_encode($ilceler);
}
?>




