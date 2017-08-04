<?php
session_start();

require_once('ConnectDB.php');
require('GetMatchIDs.php');
//$inUseIDs = $_POST['artId'];
//$inUseIDs = json_decode($inUseIDs);
//$pairNum = $inUseIDs[0];
$username = $_SESSION["person"];
//$username = "atjoseph";
// Get array of article ids to select from
//$allPairs = array_map('str_getcsv', file('articlePairs.csv'));
// Get individual user pairs
//$pairs = getUserPairs($username);
//print_r($pairs);
// Generate a random number
//$num =  rand( 0, count($pairs) );
// Select the article
//$artId1 = $allPairs[$pairs[$num]][0];
//$artId2 = $allPairs[$pairs[$num]][1];

// exit();
/* check connection */
if ($conn->connect_error) {
    //printf("Connect failed: %s\n", $conn->connect_error);
    echo("Conn failed");
    exit();
}

$query = "select * from `id2art` where `art_id` = $artId1 or `art_id` = $artId2";
// echo("Something");
// exit();
/* Select queries return a resultset */
if ($result = mysqli_query($conn, $query)) {
    $n = mysqli_num_rows($result);
    $json = array();
    // Collect variables to send back to javascript
    $json['pairNum']= $pairs[$num];
    $json['artId1'] = $artId1;
    $json['artId2'] = $artId2;
    $rowCount = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        // Make the article info in JSON
        if ($rowCount == 0)
        {
            $json['art_id1']=$row['art_id'];
            $json['title1']=$row['title'];
            $json['category1']=$row['category'];
            $json['artText1']=$row['artText'];
        }
        else
        {
            $json['art_id2']=$row['art_id'];
            $json['title2']=$row['title'];
            $json['category2']=$row['category'];
            $json['artText2']=$row['artText'];
        }
        $rowCount = $rowCount + 1;
    }
    /* free result set */
    mysqli_free_result($result);
}

// Return results to client
// echo("SOmething");
echo json_encode($json);

?>
