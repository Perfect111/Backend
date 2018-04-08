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
    $f_name = $request->f_name;
    $l_name = $request->l_name;
    $email = $request->email;
    $password = $request->password;
    $contact1 = $request->contact1;
    $contact2 = $request->contact2;
    $company = $request->company;
    $address = $request->address;
    
    $sql = "update user set `f_name`='".$f_name."', `l_name`='".$l_name."', `email`='".$email."', `password`='".$password."', `contact1`='".$contact1."', `contact2`='".$contact2."', `company`='".$company."', `location`='".$address."' where `uid`='".$uid."'";
    // mysqli_query($link, $sql);    
    mysql_query($sql, $link);
    $result = array(
        'echo' => '3'
    );
    echo json_encode($result);
}

mysql_close($link);

?>