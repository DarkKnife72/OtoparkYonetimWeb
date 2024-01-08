var server_url = 'http://'+location.hostname+'/project';
function LoginAccount() {  
    if ($('#login-username').val() == "" || $('#login-password').val() == "")
    {
        LoginError("Kullanıcı adı ve şifre kısmını boş bırakamazsınız.");        
        return;
    }    
    $.ajax({
        type: "POST",
        url: "./source/modules.php",
        data: {
            'type': 'login',
            'username': $('#login-username').val(),
            'password': $('#login-password').val(),
        },        
        success: function (response) {
            if (response == "mysql")
            {                
                LoginError("Veritabanı hatası oluştu.");
            }
            else if (response == "incorrect")
            {
                LoginError("Kullanıcı adı veya şifre yanlış.");
            }     
            else
            {
                window.location.href = server_url+"/index.php";
            }       
        },
        error: function (xhr, status, error) {
            alert("Hata: "+error);            
        }
    });
}

function LoginError(text) {
    $("#login-error").fadeIn("fast");
    $("#login-error-text").html(text);
}
