function getInfo()
{
  var email = document.getElementById('email').value;
  var xhr = openAjax();
  xhr.open("POST", "emailInfo.php",true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  var emailInfo = "emailInfo=" + email;
  xhr.send(emailInfo);
  xhr.onreadystatechange = display_data;
    function display_data()
    {
      if(xhr.readyState == 4)
      {
        if(xhr.status == 200)
        {
          alert("Your information has been emailed to you.");
        }
        else
        {
          alert("There was a problem with the request.");
        }
      }
    }
}

function resetPass()
{
  var xhr = openAjax();
  var key = document.getElementById('key').value;
  var userName = document.getElementById('username').value;
  var password = document.getElementById('password').value;
  var sendOver = [key,userName,password];
  var loginInfo = "loginInfo=" + JSON.stringify(sendOver);
  xhr.open("POST", "resetInfo.php",true);
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
