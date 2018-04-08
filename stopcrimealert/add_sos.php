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
    $flag = $request->flag;

    if($flag == 'add') {

        $user_sql = "select * from user where uid='".$uid."'";
        // $user_sql_result = mysqli_query($link, $user_sql);
        $user_sql_result = mysql_query($user_sql, $link);
        // $u_row = mysqli_fetch_array($user_sql_result);
        $u_row = mysql_fetch_array($user_sql_result);
        $contact1 = isset($u_row['contact1'])? $u_row['contact1'] : '';
        $contact2 = isset($u_row['contact2'])? $u_row['contact2'] : '';
        
        $valid_sql = "select * from sos where uid='".$uid."' and state='0'";
        // $sql_result = mysqli_query($link, $valid_sql);
        $sql_result = mysql_query($valid_sql, $link);
        // $row = mysqli_fetch_array($sql_result);
        $row = mysql_fetch_array($sql_result);
        if($row) {
            $result = array(
                'echo' =>'2',
            );
            echo json_encode($result);
        }
        else {
            $dt = new DateTime("now");
            $time = $dt->format('Y-m-d h:i:s');

            $insert_sql = "INSERT INTO `sos`(`uid`, `location`, `time`) VALUES ('".$uid."', '".$location."', '".$time."')";
            // mysqli_query($link, $insert_sql);
            mysql_query($insert_sql, $link);
            $result = array(
                'echo' =>'3',
            );

            $message_text = "Help me. \r\n Location: ".$u_row['location']."\r\n Name : ".$u_row['f_name']." ".$u_row['l_name']."\r\n Email : ".$u_row['email']."\r\n";
            if($contact1) {
                $sendingSMS = var_dump(mail($contact1."vtext.com", "", $message_text));
            }
            if($contact2) {
                $sendingSMS = var_dump(mail($contact2."vtext.com", "", $message_text));
            }
            
            echo json_encode($result);
        }
    }
    else {
        $insert_sql = "update sos set state='1' where uid='".$uid."' and state='0'";
        // mysqli_query($link, $insert_sql);
        mysql_query($insert_sql, $link);
        $result = array(
            'echo' =>'3',
        );

        $message_text = "Solved my problem. \r\n Location: ".$u_row['location']."\r\n Name : ".$u_row['f_name']." ".$u_row['l_name']."\r\n Email : ".$u_row['email']."\r\n";
        if($contact1) {
            $sendingSMS = var_dump(mail($contact1."vtext.com", "", $message_text));
        }
        if($contact2) {
            $sendingSMS = var_dump(mail($contact2."vtext.com", "", $message_text));
        }
    
    echo json_encode($result);
    }
}

mysql_close($link);

?>