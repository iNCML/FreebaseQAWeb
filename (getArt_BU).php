<?php
// Connect to DB
require_once('dbopen.php');
// Get in use article ids
$inUseIDs = $_POST['artId'];
$inUseIDs = json_decode($inUseIDs);
$pairNum = $inUseIDs[0];

// Get array of article ids to select from
$pairs = array_map('str_getcsv', file('articlePairs.csv'));

// Remove the used id's from the array
array_splice($pairs,$pairNum,1);

// Generate a random number
$num =  rand( 0, count($pairs) );
// Select the article
$artId1 = $pairs[$num][0];
$artId2 = $pairs[$num][1];

/* check connection */
if ($conn->connect_error) {
    printf("Connect failed: %s\n", $conn->connect_error);
    exit();
}

$query = "select * from `id2art` where `art_id` = $artId1 or `art_id` = $artId2";

/* Select queries return a resultset */
if ($result = mysqli_query($conn, $query)) {
    $n = mysqli_num_rows($result);
    $json = array();
    // Collect variables to send back to javascript
    $json['pairNum']= $num;
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
echo json_encode($json);

?>
