<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/index.css">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Otopark Yönetim - Anasayfa</title>
</head>
<body>
    <?php     
        date_default_timezone_set('Europe/Istanbul');
        if (session_status() != PHP_SESSION_ACTIVE)
        {
            session_start();
        }
        if (!$_SESSION || !$_SESSION['account_id'])
        {
            header('location:login.php');
            die();
        }
        $conn = new mysqli("localhost", "root", "", "project_db");

        if ($conn->connect_errno > 0) {
            header("location:error.php");
            die();
        }
        else
        {
            $conn->set_charset("utf8");            
        }
    ?>
    <div id="header">
        <div style="display:flex;gap:10px;align-items:center;">
                        
            <?php                
                $query = "SELECT * FROM accounts WHERE id = '".$_SESSION['account_id']."'";
                $result = $conn->query($query);
                if ($result->num_rows > 0) 
                {                    
                    $row = $result->fetch_assoc();                    
                    if ($row['avatar'] != null)
                    {
                        echo '<img id="header-avatar" src="'.$row['avatar'].'">';
                    }
                }
                else
                {
                    header("location:error.php");
                    die();
                }

            ?>
            <h3 id="hello-text">Hoşgeldin, <?= $row['username'] ?></h3>
        </div>
        <div style="display:flex;gap:30px;align-items:center;">
            <?php
                if ($row['theme_mode'] == 0)
                {
                    echo '<span id="header-theme" onclick="ChangeTheme(1);"><i id="header-theme-logo" class="fa-regular fa-moon"></i></span>';
                } 
                else
                {
                    echo '<span id="header-theme" onclick="ChangeTheme(0);"><i id="header-theme-logo" class="fa-regular fa-sun"></i></span>';
                }
            ?>
            <span onclick="Logout();" id="header-logout"><i class="fa-solid fa-right-from-bracket"></i> Çıkış Yap</span>
        </div>
    </div>
    <div id="success-notif" style="display:none;">
        <div style="display:flex;justify-content:space-between;color:#000;align-items:center;">
            <span><i class="fa-solid fa-check"></i> Başarılı</span>
            <span onclick="SuccessMessageClose();"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <br>
        <div>
            <span id="success-notif-text"></span>
        </div>
    </div>
    <div id="error-notif" style="display:none;">
        <div style="display:flex;justify-content:space-between;color:#000;align-items:center;">
            <span><i class="fa-solid fa-circle-exclamation"></i> Hata</span>
            <span onclick="ErrorMessageClose();"><i class="fa-solid fa-xmark"></i></span>
        </div>
        <br>
        <div>
            <span id="error-notif-text"></span>
        </div>
    </div>
    
    <div id="container">
        <div id="left-panel">
            <span>
                <div onclick="ShowRightPage('main-menu')" class="left-menu-hover" style="display:flex;justify-content:space-between;align-items:center;gap:20px;">
                    <span>Anasayfa</span>
                    <i class="fa-solid fa-house"></i>
                </div>                
            </span>
            <span>
                <div onclick="ShowRightPage('vehicle-action');" class="left-menu-hover" style="display:flex;justify-content:space-between;align-items:center;gap:20px;">
                    <span>Araç İşlemleri</span>                    
                    <i class="fa-solid fa-car"></i>
                </div>                    
            </span>
            <span>
                <div onclick="ShowRightPage('garage-action')" class="left-menu-hover" style="display:flex;justify-content:space-between;align-items:center;gap:20px;">
                    <span>Garaj İşlemleri</span>                    
                    <i class="fa-solid fa-warehouse"></i>
                </div>   
            </span>            
            <span>
                <div onclick="ShowRightPage('account-action')" class="left-menu-hover" style="display:flex;justify-content:space-between;align-items:center;gap:20px;">
                    <span>Hesap Yönetimi</span>                    
                    <i class="fa-solid fa-circle-user"></i>
                </div>   
            </span>
            <?php
                if ($row['admin_level'] > 0)
                {
                    echo '
                        <span>
                            <div onclick="ShowRightPage(`staffs-action`)" class="left-menu-hover" style="display:flex;justify-content:space-between;align-items:center;gap:20px;">
                                <span>Çalışan Yönetimi</span>
                                <i class="fa-solid fa-id-card-clip"></i>
                            </div>
                        </span>
                    ';
                }
                if ($row['admin_level'] > 1)
                {
                    echo '
                        <span>
                            <div onclick="ShowRightPage(`management-action`)" class="left-menu-hover" style="display:flex;justify-content:space-between;align-items:center;gap:20px;">
                                <span>Yönetim Menüsü</span>
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                        </span>
                    ';
                }
            ?>
        </div>
        <div id="right-panel">
            <div id="right-main-info">
                <div class="right-panel-box">
                        <?php
                            $query = "SELECT id FROM garage";
                            $result = $conn->query($query);
                            $total_garage_car = $result->num_rows;
                            $query_staff = "SELECT id FROM accounts";
                            $result_staff = $conn->query($query_staff); 
                            $total_staff = $result_staff->num_rows;
                            $query = "SELECT * FROM management";
                            $result = $conn->query($query); 
                            if ($result->num_rows > 0)
                            {
                                $row_info = $result->fetch_assoc();
                                if ($row_info['add_vehicle'] == 1)
                                {
                                    $add_vehicle = "<span style='color:green;'>Eklenebilir</span>";
                                } 
                                else
                                {
                                    $add_vehicle = "<span style='color:red;'>Eklenemez</span>";
                                }         
                                if ($row_info['create_account'] == 1)
                                {
                                    $add_account = "<span style='color:green;'>Oluşturulabilir</span>";  
                                }
                                else
                                {
                                    $add_account = "<span style='color:red;'>Oluşturulamaz</span>";
                                }                               
                            }
                        ?>
                        <h3>Genel Otopark Bilgisi</h3>                    
                        <span>Garaj İçerisindeki Araçlar: <b><?= $total_garage_car ?></b> Araç</span>
                        <span>Toplam Çalışan Sayısı: <b><?= $total_staff ?></b> Kişi</span>
                        <span>Otopark Araç Eklenebilirlik Durumu: <b><?= $add_vehicle ?></b></span>
                        <?php

                            if ($row['admin_level'] > 0)
                            {
                                echo '<span>Otopark Çalışan Hesabı Oluşturma Durumu: <b>'.$add_account.'</b></span>';
                            }
                            if ($row['admin_level'] > 1)
                            {
                                echo '<span>Kasada bulunan toplam para miktarı: <b>'.number_format($row_info['total_cash'], 0).'</b> TL</span>';
                            }
                        ?>                        
                </div>
            </div>
            <div id="right-panel-vehicle" style="gap:30px;display:none;">
                <div>
                    <div class="right-panel-box">
                        <h3>Araç Kaydı Ekleme</h3>                    
                        <span style="opacity:0.8;">Otoparka kayıt edilecek araçların girişini buradan yapabilirsin.</span>                                        
                        <span>Araç Markası: <input type="text" id="vehicle-add-brand" placeholder="Araç Markasını Girin.." maxlength="50"></span>                    
                        <span>Araç Modeli: <input type="text" id="vehicle-add-model" placeholder="Araç Modelini Girin.." maxlength="50"></span>
                        <span>Araç Plakası: <input type="text" id="vehicle-add-plate" placeholder="Araç Plakasını Girin.." maxlength="50"></span>
                        <span>Araç Sahibi: <input type="text" id="vehicle-add-owner" placeholder="Araç Sahibi Girin.." maxlength="50"></span>
                        <span>Aracın Otoparkta Kalacağı Saat: <input type="number" placeholder="Aracın Kalacağı Süre.." id="vehicle-add-hours"></span>
                        <button onclick="VehicleRecordAdd();">Kayıt Ekle</button>
                    </div>
                </div>
                <div>
                    <div class="right-panel-box">
                        <h3>Araç Kaydı Sil</h3>                    
                        <span style="opacity:0.8;">Otoparktan çıkan araçların çıkış işlemlerini buradan yapabilirsiniz.</span>
                        <span>Araç Plakası: <input type="text" id="vehicle-delete-plate" placeholder="Araç Plakasını Girin.." maxlength="50"></span>
                        <button onclick="VehicleRecordDelete();">Kayıt Sil</button>
                    </div>
                </div>
            </div>

            <div id="right-panel-garage" style="display:none;overflow:auto;">
                <div>
                    <div class="right-panel-box">
                        <h3>Otopark İçerisindeki Araçlar</h3>                    
                        <span style="opacity:0.8;">Otopark içerisindeki tüm araçları buradan görüntüleyebilirsiniz.</span>                                        
                        <table width="100%">
                            <thead style="font-weight:bold;">
                                <tr>
                                    <td>Araç Markası</td>
                                    <td>Araç Modeli</td>
                                    <td>Araç Plakası</td>
                                    <td>Araç Sahibi</td>
                                    <td>Aracın Otoparktan Çıkacağı Zaman</td>
                                </tr>                                
                            </thead>
                            <tbody>
                                <?php

                                    $query = "SELECT * FROM garage ORDER BY id ASC";
                                    $result = $conn->query($query); 
                                    if ($result->num_rows > 0)
                                    {
                                        while ($row_garage = $result->fetch_assoc())
                                        {
                                            echo '
                                                <tr>
                                                    <td>'.$row_garage['brand'].'</td>
                                                    <td>'.$row_garage['model'].'</td>
                                                    <td>'.$row_garage['plate'].'</td>
                                                    <td>'.$row_garage['owner'].'</td>                                                                                            
                                            ';
                                            if ($row_garage['end_time'] < time())
                                            {
                                                echo '<td style="color:red;">Zamanı Doldu</td>';
                                            }
                                            else
                                            {
                                                echo '<td>'.date("d/m/Y H:i", $row_garage['end_time']).'</td>'; 
                                            }
                                            echo '</tr>';
                                        }
                                        
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="right-panel-account" style="gap:30px;display:none;">
                <div>
                    <div class="right-panel-box">
                        <?php

                            switch ($row['admin_level']) {
                                case 0:
                                    $admin_text = "Üye";
                                    break;
                                case 1:
                                    $admin_text = "Çalışan";
                                    break;
                                case 2:
                                    $admin_text = "Patron";
                                    break;    
                                default:
                                    $admin_text = "Bilinmiyor";
                                    break;
                            }
                            switch ($row['theme_mode'])
                            {
                                case 0:
                                    $theme_mode = "Aydınlık";
                                    break;
                                case 1:
                                    $theme_mode = "Karanlık";
                                    break;
                                default:
                                    $theme_mode = "Bilinmiyor";
                                    break;    
                            }
                        ?>
                        <h3>Genel Hesap Bilgileri</h3>                    
                        <span style="opacity:0.8;">Genel hesap bilgilerinizi görebileceğiniz bölüm.</span>                                        
                        <span>Kullanıcı Adı: <span><?= $row['username'] ?></span></span>                                        
                        <span>Yönetici Seviyesi: <span><?= $admin_text ?></span></span>
                        <span>Son Başarılı Giriş Tarihi: <span><?= date("d/m/Y H:i", $row['last_login']) ?></span></span>
                        <span>Tema Modu: <span><?= $theme_mode ?></span></span>                        
                    </div>
                    <br>
                    <div class="right-panel-box">
                        <h3>Hesap Bilgileri Düzenleme</h3>                    
                        <span style="opacity:0.8;">Hesap bilgilerinizi düzenleyebileceğiniz bölüm.</span>                                        
                        <span>Kullanıcı Adı: <input type="text" id="account-management-username" placeholder="Yeni kullanıcı adı.." maxlength="50"></span>                                        
                        <button style="width:max-content;" onclick="SaveAccountUsername();">Kaydet</button>
                        <span>Eski Şifre: <input type="password" id="account-management-oldpassword" placeholder="Eski şifre.." maxlength="50"></span>
                        <span>Yeni Şifre: <input type="password" id="account-management-newpassword" placeholder="Yeni şifre.." maxlength="50"></span>
                        <button style="width:max-content;" onclick="SaveAccountPassword();">Kaydet</button>
                        <span>Avatar Resim(URL): <input type="text" id="account-management-avatar" placeholder="Avatar URL.."></span>
                        <button style="width:max-content;" onclick="SaveAccountAvatar();">Kaydet</button>
                    </div>
                </div>                
            </div>

            <div id="right-panel-staffs" style="gap:30px;display:none;">
                <div>
                    <div class="right-panel-box">                        
                        <h3>Çalışanların Listesi</h3>                    
                        <span style="opacity:0.8;">Otopark içerisindeki kayıtlı çalışanları görebileceğiniz bölüm.</span>
                        <table width="100%">
                            <thead style="font-weight:bold;">
                                <tr>
                                    <td>Kullanıcı Adı</td>
                                    <td>Yönetici Seviyesi</td>
                                    <td>Son Başarılı Giriş</td>                                    
                                    <td>Otoparka Toplam Kaydedilen Araç</td>
                                    <td>Otoparktan Toplam Çıkarılan Araç</td>
                                </tr>                                
                            </thead>
                            <tbody>
                                <?php

                                    $query = "SELECT * FROM accounts ORDER BY id ASC";
                                    $result = $conn->query($query); 
                                    if ($result->num_rows > 0)
                                    {
                                        while ($row_staffs = $result->fetch_assoc())
                                        {
                                            switch ($row_staffs['admin_level']) {
                                                case 0:
                                                    $admin_text = "Üye";
                                                    break;
                                                case 1:
                                                    $admin_text = "Çalışan";
                                                    break;
                                                case 2:
                                                    $admin_text = "Patron";
                                                    break;    
                                                default:
                                                    $admin_text = "Bilinmiyor";
                                                    break;
                                            }
                                            echo '
                                                <tr>
                                                    <td>'.$row_staffs['username'].'</td>
                                                    <td>'.$admin_text.'</td>
                                                    <td>'.date("d/m/Y H:i", $row_staffs['last_login']).'</td>
                                                    <td>'.$row_staffs['total_input'].'</td>
                                                    <td>'.$row_staffs['total_output'].'</td>
                                                </tr>
                                            ';
                                        }
                                    }

                                ?>
                            </tbody>
                        </table>                                               
                    </div>                    
                </div>                
            </div>

            <div id="right-panel-management" style="gap:30px;display:none;">
                <div>
                    <div class="right-panel-box">                        
                        <h3>Otopark Otomasyonu Yönetim Paneli</h3>                    
                        <span style="opacity:0.8;">Otopark otomasyonunun yönetim paneli.</span>                        
                        <h4>Kullanıcı Hesabı Oluşturma</h4>
                        <span>Kullanıcı Adı: <input type="text" id="account-create-username" placeholder="Kullanıcı adı.." maxlength="50"></span>
                        <span>Şifre: <input type="password" id="account-create-password" placeholder="Kullanıcı adı.." maxlength="50"></span>
                        <span>Yönetici Seviyesi: <select id="account-create-adminlevel"><option value="1">Çalışan</option><option value="2">Patron</option></select></span>
                        <button style="width:max-content;" onclick="CreateAccount();">Hesap Oluştur</button>
                    </div>                    
                </div>                
            </div>
            
        </div>
    </div>  
    <script src="script/index.js"></script>
    <?php
    
        if ($row['theme_mode'] == 1)
        {
            echo '
            <script type="text/javascript">
                $("#left-panel").css("background-color", "#121212");
                $("#left-panel").css("color", "#fff");
                $(".right-panel-box").css("color", "#fff");
                $(".fa-pen-to-square").css("color", "#fff");
                $(".fa-pen-to-square").css("background-color", "rgb(61, 61, 61)");
                $(".right-panel-box").css("background-color", "#121212");
                $("input").css("background-color", "#262626");
                $("input").css("color", "#fff");
                $("button").css("background-color", "#262626");
                $("button").css("color", "#fff");
                $("select").css("background-color", "#262626");
                $("select").css("color", "#fff");
                $("body").css("background-color", "#353535");
            </script>';
        }

    ?>
</body>
</html>