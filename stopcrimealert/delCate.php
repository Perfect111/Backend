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
    $tid = $request->tid;

    $valid_sql = "delete from type where tid='".$tid."'";
    // mysqli_query($link, $valid_sql);
    mysql_query($valid_sql, $link);
    $result = array(
        'echo' =>'3',
    );
    echo json_encode($result);
}
mysql_close($link);

?>