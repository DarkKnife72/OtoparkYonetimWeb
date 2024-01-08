<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otopark Yönetimi - Giriş</title>
    <link rel="stylesheet" href="assets/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    
</head>
<body>
    <?php

        if (session_status() != PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        if (isset($_SESSION['account_id']))
        {
            header('location:index.php');
            die();
        }

    ?>
    <div id="container">        
        <h2>Yetkili Girişi</h2>
        <div id="login-error" style="display:none;">
            <span id="login-error-text"></span>
        </div>  
        <br>
        <div class="input-custom">
            <span class="input-custom-icon"><i class="fa-regular fa-user"></i></span>
            <div style="display:flex;flex-direction:column;gap:10px;">
                <span class="input-custom-title">Kullanıcı Adı</span>
                <input type="text" id="login-username" class="input-custom-input" placeholder="Kullanıcı Adınızı Girin.."></input>
            </div>            
        </div>
        <br>
        <div class="input-custom">
            <span class="input-custom-icon"><i class="fa-solid fa-key"></i></span>
            <div style="display:flex;flex-direction:column;gap:10px;">
                <span class="input-custom-title">Şifre</span>
                <input type="password" id="login-password" class="input-custom-input" placeholder="Şifrenizi giriniz.."></input>
            </div>        
        </div>
        <br>
        <button id="login-button" onclick="LoginAccount();">
            <span>Hesabıma Giriş Yap</span>
            <span style="float:right;"><i class="fa-solid fa-arrow-right"></i></span>
        </button>
    </div>

    <script src="script/login.js"></script>

</body>
</html>