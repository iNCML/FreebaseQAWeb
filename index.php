<!DOCTYPE html>
<html>
    <head>
        <title>FreebaseQA Analysis</title>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
        <script type="text/javascript" src="index.js"></script>
        <link rel="stylesheet" type="text/css" href="index.css">
    </head>
    <body>
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header page-scroll">
                    <img src="logo.jpg" class="img-responsive" alt="Lassonde Logo"><p class="navbar-text">Evaluating Matched QA Pairs and Freebase Triples</p>
                </div>
            </div>
        </div>
        <br><br><br><br>
        <div id='accBlock1'>
            <span class="boldtext">NEW USERS - Create Account</span><br><br>
            Email:<input type="text" name="emailSignUp" id="emailSignUp" value='' class="inputBox"><br><br>
            Username:<input type="text" name="usernameSignUp" id="usernameSignUp" value='' class="inputBox"><br><br>
            Password:<input type="password" name="passwordSignUp" id="passwordSignUp" value='' class="inputBox"><br><br>
            <button value="Submit" onclick="createAccount()" class="submit">Submit</button>
        </div>
        <br><br>
        <div id='accBlock2'>
            <span class="boldtext">EXISTING USERS - Login</span><br><br>
            Username: <input type="text" name="username" id="username" value='' class="inputBox"><br><br>
            Password: <input type="password" name="password" id="password" value='' class="inputBox"><br><br>
            <button value="Submit" onclick="login()" class="submit">Submit</button>
        </div>
        <br>
        <div style="text-align: center"><a href="forgot.php">Forgot Login Info?</a></div>
    </body>
</html>
