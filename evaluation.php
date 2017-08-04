<!DOCTYPE html>
<html>
    <head>
        <title>FreebaseQA Analysis</title>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="evaluation.css">
        <script type="text/javascript" src="evaluation.js"></script>
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
            <span id='subject' class="triplet-span">joe clark</span><span style="font-size: 20pt"> &rarr;</span>
            <span id='predicate' class="triplet-span">government.politician.government_positions_held</span><span style="font-size: 20pt"> &rarr;</span>
            <span id='m-predicate' class="triplet-span">government.governmental_jurisdiction.governing_officials</span><span style="font-size: 20pt"> &rarr;</span>
            <span id='object' class="triplet-span">canada</span>
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
            <button id="0" onclick="submit(0)" class="rating-button" style="background-color: rgba(102, 204, 255, 0.4)"><b>Not Relevant</b></button>
            <button id="1" onclick="submit(1)" class="rating-button" style="background-color: rgba(102, 204, 255, 0.7)"><b>Somewhat Relevant</b></button>
            <button id="2" onclick="submit(2)" class="rating-button" style="background-color: rgba(102, 204, 255, 1)"><b>Completely Relevant</b></button>
            <br><br>
            <button id="undo" onclick="undo()" class="rating-button" style="background-color: #ffcc66">UNDO</button>
            <button id="skip" onclick="newPair(false)" class="rating-button" style="background-color: #ffcc66">SKIP</button>
            <br><br><br><br><br>
            <button id="logout" onclick="logout()" class="menu-button">Logout</button>
        </div>
        <div id="snackbar">Temporary message (to be replaced)...</div>
    </body>
</html>
