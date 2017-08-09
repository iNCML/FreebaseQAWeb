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
                    <img src="logo.jpg" class="img-responsive" alt="Lassonde Logo"><p class="navbar-text">Evaluating Matched QA Pairs and Freebase Triples</p>
                </div>
            </div>
        </div>

        <div id="qa">
            <table class="qa-table" align="center">
                <tr><th class="qa-th">Question</th>
                    <th class="qa-th">Answer</th></tr>
                <tr><td id="question" class="qa-td"></td>
                    <td id="answer" class="qa-td"></td></tr>
            </table>
        </div>
        <div id="triplet">
            <span id="subject" class="triplet-span"></span><span style="font-size: 16pt"> &rarr;</span>
            <span id="predicate" class="triplet-span" style="font-size: 14pt"></span><span style="font-size: 16pt"> &rarr;</span>
            <span id="object" class="triplet-span"></span>
	    <br>
	    <p id="m-predicate"></p>
        </div>

        <div id="ratings">
            <b>In term of answering the question, how relevant is this triplet/quadruplet? </b><a href="javascript:copyToClipboard()">(COPY TO CLIPBOARD)</a>
            <br><br>
            <button id="0" onclick="submit(0)" class="rating-button" style="background-color: rgba(102, 204, 255, 0.4)"><b>Not Relevant</b></button>
            <button id="1" onclick="submit(1)" class="rating-button" style="background-color: rgba(102, 204, 255, 0.7)"><b>Partially Relevant</b></button>
            <button id="2" onclick="submit(2)" class="rating-button" style="background-color: rgba(102, 204, 255, 1)"><b>Completely Relevant</b></button>
            <br><br>
            <button id="undo" onclick="undo()" class="rating-button" style="background-color: #ffcc66">UNDO</button>
            <button id="defer" onclick="submit(3)" class="rating-button" style="background-color: #ffcc66">DEFER</button>
            <br><br><br><br>
	    <span id="username"></span><br><span id="progress"></span><br>
            <button id="logout" onclick="logout()" class="menu-button">Logout</button>
        </div>
        <div id="snackbar"></div>
    </body>
</html>
