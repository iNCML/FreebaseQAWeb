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

/*var art1;
var art2;
var prevArt1;
var prevArt2;
var art1Cat;
var art2Cat;
var pairNum;
var tmpPairNum;
var numLeft;

function updateRatingsLocations()
{
    var h1 = document.getElementById("art1").clientHeight;
    var h2 = document.getElementById("art2").clientHeight;
    var h;
    if (h2 > h1)
    {
        h = h2;
    }
    else {
        h = h1;
    }
    document.getElementById("ratings").style.top = h + 100 + "px";
}

function updateArtLocations()
{
    var h = document.getElementById("ratings").clientHeight;

    document.getElementById("art1").style.top = h + 100 + "px";
    document.getElementById("art2").style.top = h + 100 + "px";
}*/


function submit(rating)
{
    /*var rating = document.getElementsByName('rating');
    var rate_val = -1;
    for(var i = 0; i < rating.length; i++){
        if(rating[i].checked){
            rate_val = rating[i].value;
        }
    }
    var goodR = document.getElementsByName('goodRad');
    var goodR_val = -1;
    for(var j = 0; j < goodR.length; j++){
        if(goodR[j].checked){
            goodR_val = goodR[j].value;
        }
    }

    if (pairNum == tmpPairNum) {
        alert("Please select a new pair of articles.")
    }
    else if ((rate_val == -1) || (goodR_val == -1)) {// || (art1Like == "likeArt") || (art2Like == "likeArt"))
        alert("Please select a numeric rating and/or indicate if one of the articles would have been a good recommendation based on the other.")
    }
    else {
        rate_val = parseInt(rate_val);
        goodR_val = parseInt(goodR_val);*/
    
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
                // showSnackBar("Rating has been posted properly. Generating New Pair.");
                //tmpPairNum = pairNum;
                //var responseT = JSON.parse(xhr.responseText);
                //numLeft = responseT.numLeft;
                newPair(true);
            }
            else {
                showSnackBar("There was a problem with the request.");
                // alert("There was a problem with the request.");
            }
        }
    };
    //}
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
    //document.getElementByID('question').innerHTML = "what's up";

    var xhr = openAjax();
    //var inUseIDs = "matchID=" + JSON.stringify(matchID);
    xhr.open("POST", "GetMatch.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send();
    //xhr.send(inUseIDs);
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                //var responseT = xhr.responseText;
		var responseT = JSON.parse(xhr.responseText);
                //console.log(responseT);
		
                document.getElementById('question').innerHTML = "<b>" + responseT.question + "</b>";
                document.getElementById('answer').innerHTML = "<b>" + responseT.answer + "</b>";
                document.getElementById('subject').innerHTML = responseT.subject;
                document.getElementById('predicate').innerHTML = "<b>" + responseT.predicate + "</b>";
		if (responseT.mediator_predicate != 'null' && responseT.predicate != responseT.mediator_predicate) {
                    document.getElementById('m-predicate').innerHTML = "(" + responseT.mediator_predicate + ")";
                }
		else {
		    document.getElementById('m-predicate').innerHTML = "<br>";
		}
		document.getElementById('object').innerHTML = responseT.object;
   
                prevMatchID = matchID;
                matchID = responseT.matchID;
                
		/*var rating = document.getElementsByName('rating');
                for(var i = 0; i < rating.length; i++){
                    rating[i].checked = false;
                }
                var goodR = document.getElementsByName('goodRad');
                for(var j = 0; j < goodR.length; j++){
                    goodR[j].checked = false;
                }*/
            }
            else {
                showSnackBar("There was a problem with the request.");
            }
        }
    };
}

function undo()
{
    //var sendOver = [prevArt1,prevArt2];
    //var artIds = "artIds=" + JSON.stringify(sendOver);
    var previnfo = "previnfo=" + prevMatchID;
    var xhr = openAjax();
    xhr.open("POST", "Undo.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(previnfo);
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                showSnackBar("The previous rating was deleted from the database.");
            }
            else {
                showSnackBar("There was a problem with the request");
            }
        }
    };
}

/*function more(ele)
{
    // Get element id
    var spanClicked = ele.id;
    // For some reason there's a ton of white space after the word
    // So trim it for comparision purposes
    var moreOrLess = ele.innerHTML.trim();
    var relatedArt;

    if(spanClicked.indexOf("1") != -1)
    {
        relatedArt = 1;
    }
    else
    {
        relatedArt = 2;
    }

    if(moreOrLess == "more...")
    {
        ele.innerHTML="less...";
        document.getElementById("complete" + relatedArt).style.display="inline";
        // updateRatingsLocations();
        updateArtLocations();
    }
    else
    {
        ele.innerHTML="more...";
        document.getElementById("complete" + relatedArt).style.display="none";
        // updateRatingsLocations();
        updateArtLocations();
    }
}

function retractMore()
{
    var more1 = document.getElementById("more1");
    var more2 = document.getElementById("more2");
    var moreOrLess1 = more1.innerHTML.trim();
    var moreOrLess2 = more2.innerHTML.trim();
    if(moreOrLess1 == "less...")
    {
        more(more1);
    }
    if(moreOrLess2 == "less...")
    {
        more(more2);
    }
}*/


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

function showSnackBar(text) {
    var x = document.getElementById("snackbar")
    x.innerHTML = text;
    // add the "show" class to DIV
    x.className = "show";
    // after 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

window.addEventListener('resize', function(){
    "use strict";
    //updateArtLocations();
});

window.onload = function(){
    //updateArtLocations();
    newPair(false);
    //showSnackBar("Generating Match...");
}
