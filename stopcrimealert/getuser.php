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
    
    if(!empty($uid)) {
        // $valid_sql = "select * from user where uid='".$uid."'";
        $valid_sql = "select count(*) from user where uid='".$uid."'";
        // $sql_result = mysqli_query($link, $valid_sql);
        $sql_result = mysql_query($valid_sql, $link);
        // if(mysqli_num_rows($sql_result) != '0') {
        if(mysql_result($sql_result, 0) != '0') {
            $valid_sql = "select * from user where uid='".$uid."'";
            // $sql_result = mysqli_query($link, $valid_sql);
            $sql_result = mysql_query($valid_sql, $link);
            // $row = mysqli_fetch_array($sql_result);
            $row = mysql_fetch_array($sql_result);
            $result = array(
                'echo' =>'3',
                'uid' => $row['uid'],
                'email' => $row['email'],
                'contact1' => $row['contact1'],
                'contact2' => $row['contact2'],
                'company' => $row['company'],
                'sound' => $row['sound'],
                'f_name' => $row['f_name'],
                'l_name' => $row['l_name'],
                'password' => $row['password'],
                'address' => $row['location'],
            );
            echo json_encode($result);
        }
        else {
            $result = array(
                'echo' =>'2',
            );
            echo json_encode($result);
        }
    }
}

mysql_close($link);

?>