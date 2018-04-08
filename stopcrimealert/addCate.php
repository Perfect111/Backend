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
    $text = $request->text;

    // $valid_sql = "select * from type where kind='".$text."'";
    $valid_sql = "select count(*) from type where kind='".$text."'";
    // $sql_result = mysqli_query($link, $valid_sql);
    $sql_result = mysql_query($valid_sql, $link);
    // if(mysqli_num_rows($sql_result) != '0') {
    if(mysql_result($sql_result, 0) != '0') {
            $result = array(
            'echo' =>'2'
        );
        echo json_encode($result);
    }
    else {
        $insert_sql = "INSERT INTO `type`(`kind`) VALUES ('".$text."')";
        // mysqli_query($link, $insert_sql);
        mysql_query($insert_sql, $link);
        $result = array(
            'echo' =>'3',
        );
        echo json_encode($result);
    }
}
mysql_close($link);

?>