<!DOCTYPE html>
<html>
<head>
  <title>FreebaseQA Analysis</title>
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="ratings.css">
  <script type="text/javascript" src="queryDB.js"></script>
</head>
<body>
  <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <div class="navbar-header page-scroll">
              <img src="logo.jpg" class="img-responsive" alt="Lassonde Logo"><p class="navbar-text">Evaluating Matched QA Pairs and Freebase Triplets/Quadruplets</p>
          </div>
      </div>
  </div>
    <div id='ratings'>
      <b>In term of content delivered, how similar do you think these two articles are?</b>
      <br><br>
      <input type="radio" name="rating" class="ratingRadio" value="0">0: Not Similar
      <input type="radio" name="rating" class="ratingRadio" value="1">1: Similar
      <input type="radio" name="rating" class="ratingRadio" value="2">2: Very Similar
      <br><br>
      <b>If one of these articles was recommended based on the other would you have followed the link?</b>
      <br><br>
      <input type="radio" name="goodRad" class="goodRadio" value="0">No
      <input type="radio" name="goodRad" class="goodRadio" value="1">Yes
      <br><br>
      <button id="submit" onclick="submit()" class="submitButton">Submit Rating</button>
      <button id="newPair" onclick="newPair()" class="submitButton">New Pair</button>
      <button id="logout" onclick="logout()" class="submitButton">Logout</button>
      <button id="undo" onclick="undo()" class="submitButton">Undo Previous Rating</button>
    </div>
    <div id='art1'>
      <p id='art1text'>
        <span id = "title1" class = "title"></span>
        <span id = "paraArt1" class="arttext">
          <span id = "teaser1"></span><span id = "complete1"></span>
          <span id = "more1" onclick="more(this)">more...</span>
        </span>
      </p>
    </div>

    <div id='art2'>
      <p id='art2text'>
        <span id = "title2" class = "title"></span>
        <span id = "paraArt2" class="arttext">
          <span id = "teaser2"></span><span id = "complete2"></span>
          <span id = "more2" onclick="more(this)">more...</span>
        </span>
      </p>
    </div>
    <div id="snackbar">Some text some message..</div>

</body>
</html>
