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
    $f_name = $request->f_name;
    $l_name = $request->l_name;
    $email = $request->email;
    $password = $request->password;

    if(!empty($email)) {
        // $valid_sql = "select * from user where email='".$email."'";
        $valid_sql = "select count(*) from user where email='".$email."'";
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
            $insert_sql = "INSERT INTO `user`(`f_name`, `l_name`, `email`, `password`) VALUES ('".$f_name."', '".$l_name."', '".$email."', '".$password."')";
            // mysqli_query($link, $insert_sql);
            mysql_query($insert_sql, $link);
            
            $valid_sql = "select * from user where email='".$email."'";
            // $sql_result = mysqli_query($link, $valid_sql);
            $sql_result = mysql_query($valid_sql, $link);
            // $row = mysqli_fetch_array($sql_result);
            $row = mysql_fetch_array($sql_result);
            
            $result = array(
                'echo' =>'3',
                'uid' => $row['uid']
            );

            echo json_encode($result);
        }
    }
}
mysql_close($link);

?>