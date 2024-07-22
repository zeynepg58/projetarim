<?php
header('Content-Type: application/json');

// Ülke cep telefonu kodlarını içeren bir assoziatif dizi oluşturun
$countryCodes = array(
    'Türkiye' => '+90', // Türkiye
    'US' => '+1',  // Amerika Birleşik Devletleri
    // Diğer ülkeler ...
    
);

// JSON olarak çıktı ver
echo json_encode($countryCodes);
?>
