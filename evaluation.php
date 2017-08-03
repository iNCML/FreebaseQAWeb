<!DOCTYPE html>
<html>
    <head>
        <title>FreebaseQA Analysis</title>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="evaluation.css">
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

        <div id='qa'>
            <table class="qa-table" align="center">
                <tr><th class="qa-th">Question</th>
                    <th class="qa-th">Answer</th></tr>
                <tr><td class="qa-td">Who was the first president of the United States?</td>
                    <td class="qa-td">George Washington</td></tr>
            </table>
        </div>
        <div id='triplet'>
            <span id='subject' class="triplet-span">Subject</span><span style="font-size: 20pt"> &rarr;</span>
            <span id='predicate' class="triplet-span">Predicate</span><span style="font-size: 20pt"> &rarr;</span>
            <span id='m-predicate' class="triplet-span">Mediator Predicate</span><span style="font-size: 20pt"> &rarr;</span>
            <span id='object' class="triplet-span">Object</span>
        </div>

        <!--<div id='art1'>
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
        </div>-->

        <div id='ratings'>
            <b>In term of answering the question, how relevant is this triplet/quadruplet?</b>
            <br><br>
            <!--<input type="radio" name="rating" class="ratingRadio" value="0">0: Not Similar
            <input type="radio" name="rating" class="ratingRadio" value="1">1: Similar
            <input type="radio" name="rating" class="ratingRadio" value="2">2: Very Similar-->
            <button id="0" onclick="" class="rating-button" style="background-color: rgba(102, 204, 255, 0.4)">Not Relevant</button>
            <button id="1" onclick="" class="rating-button" style="background-color: rgba(102, 204, 255, 0.7)">Somewhat Relevant</button>
            <button id="2" onclick="" class="rating-button" style="background-color: rgba(102, 204, 255, 1)">Completely Relevant</button>
            <br><br>
            <button id="undo" onclick="" class="rating-button" style="background-color: #ffcc66">Undo Rating</button>
            <button id="submit" onclick="" class="rating-button" style="background-color: #ffcc66"><b>SUBMIT RATING</b></button>
            <button id="skip" onclick="" class="rating-button" style="background-color: #ffcc66">Skip Match</button>
            <br><br><br><br><br>
            <button id="logout" onclick="newPair()" class="menu-button">Logout</button>
        </div>
        <div id="snackbar">Some text some message..</div>
    </body>
</html>
