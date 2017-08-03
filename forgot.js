function openAjax()
{
    var xhr;
    if (window.XMLHttpRequest) {
        xhr = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
    return xhr;
}

function requestKey()
{
    var xhr = openAjax();
    var email = document.getElementById('email').value;
    xhr.open("POST", "RequestKey.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    var emailinfo = "emailinfo=" + email;
    xhr.send(emailinfo);
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                alert("Your information has been emailed to you.");
            }
            else {
                alert("There was a problem with the request.");
            }
        }
    }
}

function resetPassword()
{
    var xhr = openAjax();
    var key = document.getElementById('key').value;
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var loginarray = [key, username, password];
    var logininfo = "logininfo=" + JSON.stringify(loginarray);
    xhr.open("POST", "ResetPassword.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(logininfo);
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4) {
            if (xhr.status == 200){
                var responseT = xhr.responseText;
                alert(responseT);
            }
            else {
                alert("There was a problem with the request.");
            }
        }
    }
}