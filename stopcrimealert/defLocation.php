<?php

header('Access-Control-Allow-Origin: *');

include_once('db.php');

$postdata = file_get_contents("php://input");

if(!isset($postdata)) {
    $result = array(
        'echo' =>'1'
    );
    echo json_encode($result);
}
else {
    $request = json_decode($postdata);
    $uid = $request->uid;
    $location = $request->location;
    
    $sql = "update user set `location`='".$location."' where `uid`='".$uid."'";
    // mysqli_query($link, $sql);
    mysql_query($sql, $link);
    
    $result = array(
        'echo'=> '3',
    );
    echo json_encode($result);
}

mysql_close($link);

?>