<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary  navbar bg-dark" data-bs-theme="dark" >
  <div class="container">
    <a class="navbar-brand" href="alici-index.php">ALICI ANA SAYFA</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="alici-index.php">Sayfam</a>
        <a class="nav-link" href="#">Mesajlar</a>
        <a class="nav-link" href="alici-iletisim.php">İletişim</a>
      </div>
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="alici-profil.php">Profil</a>
      </div>
    </div>
  </div>
</nav>

<div class="container pt-5">
<div class="row">
  
    <div class="col-lg-8 col-lg-offset-2">
    <form id="contact-form" method="post" action="contact.php" role="form">

<div class="messages"></div>

<div class="controls">
<div class="mb-3">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group" >
                <label for="form_name">Adınız *</label>
                <input id="form_name" type="text" name="Adi" class="form-control" placeholder="Lütfen adınızı yazın *" required="required" data-error="Adınız gerekli.">
                <div class="help-block with-errors"></div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group" >
                <label for="form_lastname">Soyadınız *</label>
                <input id="form_lastname" type="text" name="Soyadi" class="form-control" placeholder="Lütfen soyadınızı yazın *" required="required" data-error="Soyadınız gerekli.">
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="form_email">E-Posta Adresiniz *</label>
                <input id="form_email" type="email" name="EPosta" class="form-control" placeholder="Lütfen E-Posta adresinizi yazın *" required="required" data-error="Geçerli bir E-Posta gerekli.">
                <div class="help-block with-errors"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="form_phone">Telefon Numaranız</label>
                <input id="form_phone" type="tel" name="Telefon" class="form-control" placeholder="Lütfen telefon numaranızı yazın">
                <div class="help-block with-errors"></div>
            </div>
        </div>
</div>

    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="form_message">Mesajınız *</label>
                <textarea id="form_message" name="Mesaj" class="form-control" placeholder="Lütfen mesajınızı yazın *" rows="4" required="required" data-error="Lütfen mesajınızı yazın."></textarea>
                <div class="help-block with-errors"></div>
            </div>
        </div>
           <div class="col-md-12" style="margin-top: 20px;">
              <input type="submit" class="btn btn-primary " value="Gönder">
           </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <p class="text-muted"><strong>*</strong> Bu alanlar gereklidir. <a href="" target="_blank"></a>.</p>
        </div>
    </div>
      
</div>

</form>

    </div>

</div>

</div>

<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="validator.js"></script>
<script src="contact.js"></script>
</body>
</html>