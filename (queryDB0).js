// Define global article id variables

var art1;
var art2;
var pairNum;
var tmpPairNum;
// var tmpArt1;
// var tmpArt2;

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

// function get_art(ele)
// {
//   // Get id and set title and paragraph references for injection
//   var buttonClicked = ele.id;
//   var title;
//   var paraArt; var tease; var comp;
//   var tmpChoice;
//   if (buttonClicked.indexOf("1") != -1)
//   {
//     title = "title1";
//     paraArt = "paraArt1";
//     tease = "teaser1";
//     comp = "complete1";
//   }
//   else
//   {
//     title = "title2";
//     paraArt = "paraArt2";
//     tease = "teaser2";
//     comp = "complete2";
//   }
//
//   var xhr=openAjax();
//   var sendOver = [art1,art2]
//   var inUseIDs = "artId=" + JSON.stringify(sendOver);
//   xhr.open("POST", "getArt.php",true);
//   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//   xhr.send(inUseIDs);
//   xhr.onreadystatechange = display_data;
//     function display_data()
//     {
//       if(xhr.readyState == 4)
//       {
//         if(xhr.status == 200)
//         {
//           var responseT = JSON.parse(xhr.responseText);
//           // console.log(responseT.artText);
//           document.getElementById(title).innerHTML= responseT.title +"<br><br>";
//           var aText = responseT.artText;
//           document.getElementById(tease).innerHTML = aText.substring(0,301);
//           document.getElementById(comp).innerHTML = aText.substring(301);
//           // document.getElementById(paraArt).innerHTML= responseT.artText;
//           if (title == "title1")
//           {
//             art1 = responseT.art_id;
//           }
//           else
//           {
//             art2 = responseT.art_id;
//           }
//           // Change Location of ratings bar
//           updateRatingsLocations();
//         }
//         else
//         {
//           alert("There was a problem with the request.");
//         }
//       }
//     }
// }

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

function submit()
{
  // Get user rating input
  var rating = document.getElementById("ratingDropDown");
  var goodR = document.getElementById("goodR");
  // Extract the value from the selection menus
  goodR = goodR.options[goodR.selectedIndex].value;
  rating = rating.options[rating.selectedIndex].value;
  if (pairNum == tmpPairNum)
  {
    alert("Please select a new pair of articles.")
  }
  else if ((rating == "Similarity Rating") || (goodR == "Good Reccomendation"))
  {
    alert("Please select a numeric rating and/or indicate if one of the articles would have been a good reccomendation.")
  }
  else
  {
    // Turn into ints
    rating = parseInt(rating);
    goodR = parseInt(goodR);
    var sendOver = [art1,art2,rating,goodR];
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
            alert("Rating has been posted properly.");
            tmpPairNum = pairNum;
          }
          else
          {
            alert("There was a problem with the request.");
          }
        }
      }
  }
}

// function newPair()
// {
//   get_art(document.getElementById("newArt1"));
//   get_art(document.getElementById("newArt2"));
// }

function newPair()
{
  // Get id and set title and paragraph references for injection
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
          for(i =1; i <= 2 ; i++)
          {
            var currentTitle = "title" + i;
            var currentTease = "teaser" + i;
            var currentComp = "complete" + i;
            var aText = "";
            if (i == 1)
            {
              document.getElementById(currentTitle).innerHTML= responseT.title1 +"<br><br>";
              aText = responseT.artText1;
            }
            else {
              document.getElementById(currentTitle).innerHTML= responseT.title2 +"<br><br>";
              aText = responseT.artText2;
            }
            document.getElementById(currentTease).innerHTML = aText.substring(0,301);
            document.getElementById(currentComp).innerHTML = aText.substring(301);
          }
          pairNum = responseT.pairNum;
          alert(pairNum);
          art1 = responseT.artId1;
          art2 = responseT.artId2;
          // document.getElementById(paraArt).innerHTML= responseT.artText;
          // Change Location of ratings bar
          updateRatingsLocations();
        }
        else
        {
          alert("There was a problem with the request.");
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
    updateRatingsLocations();
  }
  else
  {
    ele.innerHTML="more...";
    document.getElementById("complete" + relatedArt).style.display="none";
    updateRatingsLocations();
  }
}

window.addEventListener('resize', function () {
    "use strict";
    // Change Location of ratings bar
    updateRatingsLocations();
});

window.onload = function(){
  newPair();
}
