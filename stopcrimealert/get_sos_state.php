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

    // $valid_sql = "select * from sos where uid='".$uid."' and state='0'";
    $valid_sql = "select count(*) from sos where uid='".$uid."' and state='0'";
    // $sql_result = mysqli_query($link, $valid_sql);
    $sql_result = mysql_query($valid_sql, $link);
    // if(mysqli_num_rows($sql_result) != '0') {
    if(mysql_result($sql_result, 0) != '0') {
            $result = array(
            'echo' =>'3',
        );
    }
    else {
        $result = array(
            'echo' =>'2',
        );
    }
    echo json_encode($result);
}

mysql_close($link);

?>