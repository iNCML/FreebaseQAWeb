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

function login()
{
  var xhr = openAjax();
  var username = document.getElementById('username').value;
  var password = document.getElementById('password').value;
  var loginarray = [username, password];
  var logininfo = "logininfo=" + JSON.stringify(loginarray);
  xhr.open("POST", "Login.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(logininfo);
  xhr.onreadystatechange = display_data;
  function display_data()
  {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        var responseT = xhr.responseText;
        if (responseT == "go") {
          window.location.replace("evaluation.php");
        }
        else {
          alert(responseT);
        }
      }
      else {
        alert("There was a problem with the request.");
      }
    }
  }
}

function createAccount()
{
  var xhr = openAjax();
  var email = document.getElementById('emailSignUp').value;
  var username = document.getElementById('usernameSignUp').value;
  var password = document.getElementById('passwordSignUp').value;
  var loginarray = [email, username, password];
  var logininfo = "logininfo=" + JSON.stringify(loginarray);
  xhr.open("POST", "CreateAccount.php",true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(logininfo);
  xhr.onreadystatechange = display_data;
  function display_data()
  {
    if (xhr.readyState == 4) {
      if (xhr.status == 200) {
        var responseT = xhr.responseText;
        alert(responseT);
      }
      else {
        alert("There was a problem with the request.");
      }
    }
  }
}
