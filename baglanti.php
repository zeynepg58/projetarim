<?php

$host="localhost";
$kullanici="root";
$parola="";
$vt="ciftcidb";

try{

   $baglanti = new PDO("mysql:host=".$host.";dbname=".$vt, $kullanici, $parola);
   $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
   
    
} catch (PDOException $e) 
   {
    die($e->getMessage());
   }   
?>


                    