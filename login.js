function openAjax()
{
  var xhr;
  if(window.XMLHttpRequest)
  {
    xhr = new XMLHttpRequest();
  }
  else if (window.ActiveXObject)
  {
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
  }
  return xhr;
}

function login()
{
  var xhr = openAjax();
  var userName = document.getElementById('username').value;
  var password = document.getElementById('password').value;
  var sendOver = [userName,password];
  var loginInfo = "loginInfo=" + JSON.stringify(sendOver);
  xhr.open("POST", "login_db.php",true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(loginInfo);
  xhr.onreadystatechange = display_data;
    function display_data()
    {
      if(xhr.readyState == 4)
      {
        if(xhr.status == 200)
        {
          var responseT = xhr.responseText;
          if(responseT == "go")
          {
            window.location.replace("articles.php");
          }
          else
          {
            alert(responseT);
          }
        }
        else
        {
          alert("There was a problem with the request.");
        }
      }
    }
}

function createAcc()
{
  var xhr = openAjax();
  var email = document.getElementById('emailSignUp').value;
  var userName = document.getElementById('usernameSignUp').value;
  var password = document.getElementById('passwordSignUp').value;
  var sendOver = [email,userName,password];
  var loginInfo = "loginInfo=" + JSON.stringify(sendOver);
  xhr.open("POST", "createAcc.php",true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(loginInfo);
  xhr.onreadystatechange = display_data;
    function display_data()
    {
      if(xhr.readyState == 4)
      {
        if(xhr.status == 200)
        {
          var responseT = xhr.responseText;
          alert(responseT);
        }
        else
        {
          alert("There was a problem with the request.");
        }
      }
    }
}
