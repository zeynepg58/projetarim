<?php

if ( $insert ){
    
      
    $last_id = $baglanti->lastInsertId();

   $target_dir = "Tarlalar";

  
 //  $target_file = $target_dir . '/' . $last_id;

  //Kullanıcı Id li dosya yoksa oluşturuyoruz
  if (!file_exists($target_dir.'/'.$last_id)) {
   mkdir($target_dir.'/'.$last_id, 0777, true);
 }
  //Dosya Yükleme İşlemleri
  $files = array($_FILES["tarla_gorseli"], $_FILES["kiralama_belgesi"]);
  $file_names = array("Tarla-Gorseli", "Kiralama-Belgesi");

  
  for ($i=0; $i < 2; $i++)
  {
    if(isset($files[$i]))
    {
      
      $target_file = $target_dir .'/'.$last_id;
      $landuploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file."/".$files[$i]["name"],PATHINFO_EXTENSION));
      $query = $baglanti->prepare("UPDATE tarlalar SET tarla_gorseli = :tarla_gorseli, kiralama_belgesi = :kiralama_belgesi WHERE id = :last_id");
      $query->execute(array(':tarla_gorseli' => "Tarlalar/$last_id/Tarla-Gorseli.jpg", ':kiralama_belgesi' => "Tarlalar/$last_id/Kiralama-Belgesi.pdf", ':last_id' => $last_id));
      // Check file size
      if ($files[$i]["size"] > 500000)
      {
        $file_err = "Dosya Boyutu Çok Yüksek. ";
        $landuploadOk = 0;
      }

      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf"){
        $file_err =  "Sadece JPG, JPEG, PNG & PDF bu dosya tiplerine İzin verilmektedir.";
        $landuploadOk = 0;
      }

      // Check if $uploadOk is set to 0 by an error
      if ($landuploadOk == 1) 
        {
         if (!move_uploaded_file($files[$i]["tmp_name"], $target_file . "/" . $file_names[$i] . "." . $imageFileType))
         {$file_err = "Dosya Yükleme Sırasında Bir Hata Oluştu";}
        }  
     }
  }
  
  echo '<div class="alert alert-success" role="alert">
             Kayıt başarılı bir şekilde eklendi
           </div>';
          
           header("Location: ciftci-index.php");   
            exit;  
}   else
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

       ?>