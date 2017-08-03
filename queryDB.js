// Define global article id variables

var art1;
var art2;
var prevArt1;
var prevArt2;
var art1Cat;
var art2Cat;
var pairNum;
var tmpPairNum;
var numLeft;

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
}


function submit()
{
  // Get user rating input
  // Extracting the value from the selection menus
  var rating = document.getElementsByName('rating');
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

  if (pairNum == tmpPairNum)
  {
    alert("Please select a new pair of articles.")
  }
  else if ((rate_val == -1) || (goodR_val == -1))// || (art1Like == "likeArt") || (art2Like == "likeArt"))
  {
    alert("Please select a numeric rating and/or indicate if one of the articles would have been a good recommendation based on the other.")
  }
  else
  {

    // Turn into ints
    rate_val = parseInt(rate_val);
    goodR_val = parseInt(goodR_val);
    var sendOver = [art1,art2,rate_val,goodR_val,art1Cat,art2Cat,pairNum];//,art1Like,art2Like];
    var artIds = "artIds=" + JSON.stringify(sendOver);
    var xhr = openAjax();
    xhr.open("POST", "submitRating.php",true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(artIds);
    xhr.onreadystatechange = display_data;
      function display_data()
      {
        if(xhr.readyState == 4)
        {
          if(xhr.status == 200)
          {
            // showSnackBar("Rating has been posted properly. Generating New Pair.");
            tmpPairNum = pairNum;
	    var responseT = JSON.parse(xhr.responseText);
            numLeft = responseT.numLeft;
	    newPair(true);
          }
          else
          {
            showSnackBar("There was a problem with the request.");
            // alert("There was a problem with the request.");
          }
        }
      }
  }
}

function newPair(onSubmit)
{
  if(!onSubmit)
  {
      showSnackBar("Generating New Pair");      
  }
  else
  {
      showSnackBar("Rating has been posted " + numLeft + " left. Generating New Pair.");
      //showSnackBar("Rating has been posted. Generating New Pair.");
  }
  // Get id and set title and paragraph references for injection
  // showSnackBar("Generating New Pair");
  var title;
  var paraArt; var tease; var comp;
  var tmpChoice;
  var xhr=openAjax();
  var sendOver = pairNum;
  var inUseIDs = "artId=" + JSON.stringify(sendOver);
  xhr.open("POST", "getArt.php",true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(inUseIDs);
  xhr.onreadystatechange = display_data;
    function display_data()
    {
      if(xhr.readyState == 4)
      {
        if(xhr.status == 200)
        {
          var responseT = JSON.parse(xhr.responseText);
          // console.log(responseT.artText);
          for(w =1; w <= 2 ; w++)
          {
            // Set text
            var currentTitle = "title" + w;
            var currentTease = "teaser" + w;
            var currentComp = "complete" + w;
            var aText = "";
            if (w == 1)
            {
              document.getElementById(currentTitle).innerHTML= "<b>" + responseT.title1 + "</b><br><br>";
              aText = responseT.artText1;
            }
            else {
              document.getElementById(currentTitle).innerHTML= "<b>" + responseT.title2 + "</b><br><br>";
              aText = responseT.artText2;
            }
            document.getElementById(currentTease).innerHTML = aText.substring(0,501);
            document.getElementById(currentComp).innerHTML = aText.substring(501);
          }
          // Update pair num and article numbers
          pairNum = responseT.pairNum;
          prevArt1 = art1;
	  prevArt2 = art2;
          art1 = responseT.artId1;
          art2 = responseT.artId2;
	  //var artCheck = art1 + " " + art2;
	  //alert(artCheck);
      	  var rating = document.getElementsByName('rating');
          for(var i = 0; i < rating.length; i++){
              rating[i].checked = false;
          }
          var goodR = document.getElementsByName('goodRad');
          for(var j = 0; j < goodR.length; j++){
            goodR[j].checked = false;
          }
	  retractMore();
        }
        else
        {
          showSnackBar("There was a problem with the request.");
        }
      }
    }
}

function undo()
{
  var sendOver = [prevArt1,prevArt2];
  var artIds = "artIds=" + JSON.stringify(sendOver);
  var xhr = openAjax();
  xhr.open("POST", "undo.php",true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(artIds);
  xhr.onreadystatechange = display_data;
    function display_data()
    {
      if(xhr.readyState == 4)
      {
        if(xhr.status == 200)
        {
            showSnackBar("Deleted previous rating from database.");
        }
        else
        {
          showSnackBar("There was a problem with the request");
        }
      }
    }
}

function more(ele)
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
}


function logout()
{
  var xhr=openAjax();
  xhr.open("POST", "logout.php",true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send();
  xhr.onreadystatechange = display_data;
    function display_data()
    {
      if(xhr.readyState == 4)
      {
        if(xhr.status == 200)
        {
          window.location.replace("index.php");
        }
        else
        {
          alert("There was a problem with the request.");
        }
      }
    }
}

function showSnackBar(text) {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar")
    x.innerHTML = text;
    // Add the "show" class to DIV
    x.className = "show";

    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

window.addEventListener('resize', function () {
    "use strict";
    // Change Location of ratings bar
    updateArtLocations();
});

window.onload = function(){
  updateArtLocations();
  newPair(false);
  showSnackBar("Generating New Pair.");
}
