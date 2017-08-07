var matchID;
var prevMatchID;

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

function submit(rating)
{   
    var ratingarray = [matchID, rating];
    var ratinginfo = "ratinginfo=" + JSON.stringify(ratingarray);
    var xhr = openAjax();
    xhr.open("POST", "SubmitRating.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(ratinginfo);
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) { 
                newPair(true);
            }
            else {
                showSnackBar("There was a problem with the request.");
            }
        }
    };
}

function newPair(onSubmit)
{
    if (!onSubmit) {
        showSnackBar("Generating new match...");
    }
    else {
        //showSnackBar("Rating has been posted " + numLeft + " left. Generating New Pair.");
        showSnackBar("Submitted. Generating new match...");
    }

    var xhr = openAjax();
    xhr.open("POST", "GetMatch.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
		var responseT = JSON.parse(xhr.responseText);
		updateFields(responseT);
            }
            else {
                showSnackBar("There was a problem with the request.");
            }
        }
    };
    getUserInfo();
}

function undo()
{
    if (prevMatchID != null) {
	var previnfo = "previnfo=" + prevMatchID;
	var xhr = openAjax();
	xhr.open("POST", "Undo.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(previnfo);
	xhr.onreadystatechange = function()
	{
            if (xhr.readyState == 4) {
		if (xhr.status == 200) {
		    xhr.open("POST", "GetMatch.php", true);
		    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		    xhr.send();
		    xhr.onreadystatechange = function()
		    {
			if (xhr.readyState == 4) {
			    if (xhr.status == 200) {
				var responseT = JSON.parse(xhr.responseText);
				updateFields(responseT);
				getUserInfo();
				prevMatchID = null;
				showSnackBar("The previous rating was deleted from the database.");
			    }
			    else {
				showSnackBar("There was a problem with the request");
			    }
			}
		    }
		}
		else {
                    showSnackBar("There was a problem with the request");
		}
            }
	};
    }
    else {
	showSnackBar("You cannot undo again.");
    }
}

function defer()
{
    var matchinfo = "matchinfo=" + matchID;
    var xhr = openAjax();
    xhr.open("POST", "Defer.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(matchinfo);
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4) {
	    if (xhr.status == 200) {
		xhr.open("POST", "GetMatch.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send();
		xhr.onreadystatechange = function()
		{
		    if (xhr.readyState == 4) {
			if (xhr.status == 200) {
			    var responseT = JSON.parse(xhr.responseText);
			    updateFields(responseT);
			    getUserInfo();
			    showSnackBar("The match has been deferred.");
			}
			else {
			    showSnackBar("There was a problem with the request");
			}
		    }
		}
	    }
	    else {
                showSnackBar("There was a problem with the request");
	    }
        }
    };
}

function logout()
{
    var xhr = openAjax();
    xhr.open("POST", "Logout.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                window.location.replace("index.php");
            }
            else {
                alert("There was a problem with the request.");
            }
        }
    };
}

function updateFields(responseT)
{
    document.getElementById('question').innerHTML = "<b>" + responseT.question + "</b>";
    document.getElementById('answer').innerHTML = "<b>" + responseT.answer + "</b>";
    document.getElementById('subject').innerHTML = "<a target='_blank' href='http://www.eecs.yorku.ca/~watchara/cgi/FBFL2054_QUERY.cgi?Search_Input=" + responseT.subjectID + "&Input_Type=ANY&Input_Language=en&Result_Type=Summary&Result_Limit=UNLIMITED'>" + responseT.subject + "</a>";
    document.getElementById('predicate').innerHTML = "<b>" + responseT.predicate + "</b>";
    // don't show mediator predicates that are null or are the same as the regular predicate
    if (responseT.mediator_predicate != 'null' && responseT.predicate != responseT.mediator_predicate) {
        document.getElementById('m-predicate').innerHTML = "(" + responseT.mediator_predicate + ")";
    }
    else {
	document.getElementById('m-predicate').innerHTML = "<br>";
    }
    document.getElementById('object').innerHTML = "<a target='_blank' href='http://www.eecs.yorku.ca/~watchara/cgi/F\
BFL2054_QUERY.cgi?Search_Input=" + responseT.objectID + "&Input_Type=ANY&Input_Language=en&Result_Type=Summary&Result_Limit=UNLIMITED'>" + responseT.object + "</a>";
  
    prevMatchID = matchID;
    matchID = responseT.matchID;
}

function copyToClipboard()
{
    var matchString = document.getElementById('subject').innerText + " | " + document.getElementById('predicate').innerText + " | " + document.getElementById('object').innerText + " | " + document.getElementById('question').innerText + " | " + matchID;
    
    // creates a temporary textarea to copy from
    var textArea = document.createElement("textarea");
    textArea.value = matchString;
    document.body.appendChild(textArea);
    textArea.select();

    document.execCommand('copy');
    document.body.removeChild(textArea);
    
    showSnackBar("Copied to clipboard.");
}

function showSnackBar(text)
{
    var x = document.getElementById("snackbar");
    x.innerHTML = text;
    // add the "show" class to DIV
    x.className = "show";
    // after 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

function getUserInfo()
{
    var xhr = openAjax();
    xhr.open("POST", "GetUserInfo.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
		var responseT = JSON.parse(xhr.responseText);
		document.getElementById("username").innerHTML = responseT.username;
		document.getElementById("progress").innerHTML = "PROGRESS: " + responseT.count + "/20000";
            }
            else {
                showSnackBar("There was a problem with the request.");
            }
        }
    };
}

window.addEventListener('resize', function()
{
    "use strict";
});

window.onload = function()
{
    newPair(false);
}
