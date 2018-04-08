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
    $email = $request->email;
    $password = $request->password;
    if(!empty($email)) {
        $valid_sql = "select * from user where email='".$email."' and password='".$password."'";
        // $sql_result = mysqli_query($link, $valid_sql);
        $sql_result = mysql_query($valid_sql, $link);
        // $row = mysqli_fetch_array($sql_result);
        $row = mysql_fetch_array($sql_result);
        if($row) {
            $result = array(
                'echo' =>'3',
                'uid' => $row['uid']
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