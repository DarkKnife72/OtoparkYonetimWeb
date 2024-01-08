var server_url = 'http://'+location.hostname+'/project';
$(document).ready(function () {
    $("#header-notif").click(function (e) {         
        $("#header-notif-menu").css("diplay", "flex");
    });
    
    $("#header-notif").click(function (e) { 
        if ($("#header-notif-menu").css("display") == "none")
        {
            $("#header-notif-menu").css("display", "flex");
        }
        else
        {
            $("#header-notif-menu").css("display", "none");
        }
    });
});

/*function PageChange(type) {  
    if (type == 1)
    {
        if ($("#vehicle-action-page").css("display") == "none")
        {
            $("#vehicle-action-arrow").removeClass("fa-chevron-left");
            $("#vehicle-action-arrow").addClass("fa-chevron-right");
            $("#vehicle-action-page").css("display", "block");
        }
        else
        {            
            $("#vehicle-action-arrow").removeClass("fa-chevron-right");
            $("#vehicle-action-arrow").addClass("fa-chevron-left");
            $("#vehicle-action-page").css("display", "none");
        }
    }
}*/

function ShowRightPage(name) {     
    if (name == "main-menu")
    {
        $("#right-panel-vehicle").css("display", "none");
        $("#right-panel-garage").css("display", "none");
        $("#right-panel-account").css("display", "none");
        $("#right-panel-staffs").css("display", "none");
        $("#right-panel-management").css("display", "none");
        $("#right-main-info").css("display", "block");
    }
    else if (name == "vehicle-action")
    {
        $("#right-main-info").css("display", "none");
        $("#right-panel-garage").css("display", "none");
        $("#right-panel-account").css("display", "none");
        $("#right-panel-staffs").css("display", "none");
        $("#right-panel-management").css("display", "none");
        $("#right-panel-vehicle").css("display", "flex");
    }
    else if (name == "garage-action")
    {
        $("#right-main-info").css("display", "none");
        $("#right-panel-vehicle").css("display", "none");
        $("#right-panel-account").css("display", "none");
        $("#right-panel-staffs").css("display", "none");
        $("#right-panel-management").css("display", "none");
        $("#right-panel-garage").css("display", "block");
    }
    else if (name == "account-action")
    {
        $("#right-main-info").css("display", "none");
        $("#right-panel-vehicle").css("display", "none");        
        $("#right-panel-garage").css("display", "none");
        $("#right-panel-staffs").css("display", "none");
        $("#right-panel-management").css("display", "none");
        $("#right-panel-account").css("display", "block");
    }
    else if (name == "staffs-action")
    {
        $("#right-main-info").css("display", "none");
        $("#right-panel-vehicle").css("display", "none");        
        $("#right-panel-garage").css("display", "none");
        $("#right-panel-account").css("display", "none");
        $("#right-panel-management").css("display", "none");
        $("#right-panel-staffs").css("display", "block");
    }
    else if (name == "management-action")
    {
        $("#right-main-info").css("display", "none");
        $("#right-panel-vehicle").css("display", "none");        
        $("#right-panel-garage").css("display", "none");
        $("#right-panel-account").css("display", "none");
        $("#right-panel-staffs").css("display", "none");
        $("#right-panel-management").css("display", "block");
    }
}

function VehicleRecordAdd() {
    if ($("#vehicle-add-brand").val() == "" || $("#vehicle-add-model").val() == "" || $("#vehicle-add-plate").val() == "" || $("#vehicle-add-owner").val() == "" || $("#vehicle-add-hours").val() == "")
    {
        ErrorMessage('Boş alanları doldurun!');
        return;
    }
    $.ajax({
        type: "POST",
        url: "./source/modules.php",
        data: {
            'type': 'vehicle_add',
            'brand': $('#vehicle-add-brand').val(),
            'model': $('#vehicle-add-model').val(),
            'plate': $('#vehicle-add-plate').val(),
            'owner': $('#vehicle-add-owner').val(),
            'hours': $('#vehicle-add-hours').val(),
        },        
        success: function (response) {
            if (response == "mysql")
            {                
                ErrorMessage('Veritabanı hatası oluştu!');
            }
            else if (response == "avaible")
            {
                ErrorMessage('Bu plakaya ait kayıt zaten mevcut!');
            }     
            else
            {
                SuccessMessage('Araç başarıyla otopark içerisine kayıt edildi.');                
            }       
        },
        error: function (xhr, status, error) {
            alert("Hata: "+error);            
        }
    });
}

function VehicleRecordDelete() {
    if ($("#vehicle-delete-plate").val() == "")
    {
        ErrorMessage('Boş alanları doldurun!');
        return;
    }
    $.ajax({
        type: "POST",
        url: "./source/modules.php",
        data: {
            'type': 'vehicle_delete',
            'plate': $('#vehicle-delete-plate').val(),
        },        
        success: function (response) {
            if (response == "mysql")
            {                
                ErrorMessage('Veritabanı hatası oluştu!');
            }
            else if (response == "not_found")
            {
                ErrorMessage('Bu plakaya ait araç kaydı bulunamadı!');
            }     
            else
            {
                SuccessMessage('Aracın otopark kaydı başarıyla silindi.');                
            }       
        },
        error: function (xhr, status, error) {
            alert("Hata: "+error);            
        }
    });
}

function ChangeTheme(theme) {      
    $.ajax({
        type: "POST",
        url: "./source/modules.php",
        data: {
            'type': 'change_theme',
            'theme': theme            
        },        
        success: function (response) {
            if (response == "mysql")
            {                
                ErrorMessage('Panel teması değiştirilirken bir hata oluştu!');
            }                 
            else
            {
                if (theme == 1)
                {
                    $("#left-panel").css("background-color", "#121212");
                    $("#left-panel").css("color", "#fff");
                    $(".right-panel-box").css("color", "#fff");                    
                    $(".right-panel-box").css("background-color", "#121212");
                    $(".fa-pen-to-square").css("color", "#fff");
                    $(".fa-pen-to-square").css("background-color", "rgb(61, 61, 61)");
                    $("input").css("background-color", "#262626");
                    $("input").css("color", "#fff");
                    $("button").css("background-color", "#262626");
                    $("button").css("color", "#fff");
                    $("select").css("background-color", "#262626");
                    $("select").css("color", "#fff");
                    $("body").css("background-color", "#353535");
                    $("#header-theme").attr("onclick", "ChangeTheme(0);");
                    $("#header-theme-logo").removeClass("fa-moon");
                    $("#header-theme-logo").addClass("fa-regular fa-sun");                    
                }
                else
                {
                    $("#left-panel").css("background-color", "#fff");
                    $("#left-panel").css("color", "#000");
                    $(".right-panel-box").css("color", "#000");
                    $(".right-panel-box").css("background-color", "#fff");
                    $(".fa-pen-to-square").css("color", "#000");
                    $(".fa-pen-to-square").css("background-color", "rgb(151, 151, 151)");
                    $("input").css("background-color", "#ccc");
                    $("input").css("color", "#000");
                    $("button").css("background-color", "#ccc");
                    $("button").css("color", "#000");
                    $("select").css("background-color", "#ccc");
                    $("select").css("color", "#000");
                    $("body").css("background-color", "#ccc");
                    $("#header-theme").attr("onclick", "ChangeTheme(1);");
                    $("#header-theme-logo").removeClass("fa-sun");
                    $("#header-theme-logo").addClass("fa-regular fa-moon");                    
                }
            }       
        },
        error: function (xhr, status, error) {
            alert("Hata: "+error);            
        }
    });
}

function Logout() {  
    $.ajax({
        type: "POST",
        url: "./source/modules.php",
        data: {
            'type': 'logout',            
        },        
        success: function (response) {
            if (response == "mysql")
            {                
                alert('Veritabanı hatası oluştu!');
            }                 
            else
            {                
                window.location.href = server_url+"/login.php";
            }       
        },
        error: function (xhr, status, error) {
            alert("Hata: "+error);            
        }
    });
}

function SaveAccountUsername() { 
    if ($("#account-management-username").val() == "")
    {
        ErrorMessage('Kullanıcı adı kısmı boş bırakılamaz.');
        return;
    } 
    $.ajax({
        type: "POST",
        url: "./source/modules.php",
        data: {
            'type': 'change_username', 
            'username': $("#account-management-username").val()         
        },        
        success: function (response) {
            if (response == "mysql")
            {                
                alert('Veritabanı hatası oluştu!');
            }                 
            else
            {                
                SuccessMessage(`Kullanıcı adı başarıyla değiştirildi.`);
                setTimeout(() => {
                    window.location.href = server_url+"/index.php";
                }, 2000);
            }       
        },
        error: function (xhr, status, error) {
            alert("Hata: "+error);            
        }
    });
}

function SaveAccountPassword() {  
    if ($("#account-management-oldpassword").val() == "" || $("#account-management-newpassword").val() == "")
    {
        ErrorMessage('Yeni ve eski şifre kısmı boş bırakılamaz.');
        return;
    } 
    $.ajax({
        type: "POST",
        url: "./source/modules.php",
        data: {
            'type': 'change_password', 
            'old_password': $("#account-management-oldpassword").val(),
            'new_password': $("#account-management-newpassword").val(),
        },        
        success: function (response) {
            if (response == "mysql")
            {                
                ErrorMessage('Veritabanı hatası oluştu!');
            }    
            else if (response == "oldpass_not")
            {
                ErrorMessage('Eski şifreniz uyuşmuyor!');
            }
            else
            {
                alert(response);
                SuccessMessage(`Şifreniz başarıyla değiştirildi.`);                
            }       
        },
        error: function (xhr, status, error) {
            alert("Hata: "+error);            
        }
    });
}

function SaveAccountAvatar() {   
    $.ajax({
        type: "POST",
        url: "./source/modules.php",
        data: {
            'type': 'change_avatar',
            'avatar': $("#account-management-avatar").val()
        },        
        success: function (response) {
            if (response == "mysql")
            {                
                alert('Veritabanı hatası oluştu!');
            }                 
            else
            {                
                SuccessMessage(`Avatarınız başarıyla değiştirildi.`);
                setTimeout(() => {
                    window.location.href = server_url+"/index.php";
                }, 2000);
            }       
        },
        error: function (xhr, status, error) {
            alert("Hata: "+error);            
        }
    });
}

function CreateAccount() {
    if ($("#account-create-username").val() == "" || $("#account-create-password").val() == "")
    {
        ErrorMessage('Kullanıcı adı ve şifre kısmı boş bırakılamaz.');
        return;
    } 
    $.ajax({
        type: "POST",
        url: "./source/modules.php",
        data: {
            'type': 'create_account',
            'username': $("#account-create-username").val(),
            'password': $("#account-create-password").val(),
            'admin_level': $("#account-create-adminlevel").val()
        },        
        success: function (response) {
            if (response == "mysql")
            {                
                alert('Veritabanı hatası oluştu!');
            }                 
            else
            {                
                SuccessMessage(`Kullanıcı başarıyla oluşturuldu.`);                
            }       
        },
        error: function (xhr, status, error) {
            alert("Hata: "+error);            
        }
    });
}

function SuccessMessage(text) {
    if ($("#success-notif").css("display") != "none")
    {
        $("#success-notif").css("display", "none");
    }
    let notif_sound = new Audio('./assets/sounds/notification.mp3');
    notif_sound.volume = 0.1;
    notif_sound.play();
    $("#success-notif").fadeIn("slow");
    $("#success-notif-text").html(text);
    setTimeout(() => {
        $("#success-notif").fadeOut("slow");
    }, 5000);
}


function ErrorMessage(text) {
    if ($("#error-notif").css("display") != "none")
    {
        $("#error-notif").css("display", "none");
    }
    let notif_sound = new Audio('./assets/sounds/notification.mp3');
    notif_sound.volume = 0.1;
    notif_sound.play();
    $("#error-notif").fadeIn("slow");
    $("#error-notif-text").html(text);
    setTimeout(() => {        
        $("#error-notif").fadeOut("slow");
    }, 5000);
}

function SuccessMessageClose() {  
    $("#success-notif").css("display", "none");
}

function ErrorMessageClose() {  
    $("#error-notif").css("display", "none");
}