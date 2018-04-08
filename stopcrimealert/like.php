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
    $rid = $request->rid;
    $uid = $request->uid;
    // $rid = '1';
    // $uid = '1';
    
    $val_sql = "select * from like_crime where rid='".$rid."' and uid='".$uid."'";
    // $val_result = mysqli_query($link, $val_sql);
    $val_result = mysql_query($val_sql, $link);
    // if($val_result = mysqli_fetch_array($val_result)) {
    if($val_result = mysql_fetch_array($val_result)) {
        $del_sql = "delete from like_crime where rid='".$rid."' and uid='".$uid."'";
        // mysqli_query($link, $del_sql);
        mysql_query($del_sql, $link);
    } else {
        $insert_sql = "INSERT INTO `like_crime`(`rid`, `uid`) VALUES ('".$rid."', '".$uid."')";
        // mysqli_query($link, $insert_sql);
        mysql_query($insert_sql, $link);
    }

    // $sql = "select * from like_crime where rid='".$rid."'";
    $sql = "select count(*) from like_crime where rid='".$rid."'";
    // $sql_result = mysqli_query($link, $sql);
    $sql_result = mysql_query($sql, $link);
    if($sql_result) {
        // $num = mysqli_num_rows($sql_result);
        $num = mysql_result($sql_result, 0);
    }
    else
        $num = 0;


    $result = array(
        'echo' =>'3',
        'num' => $num
    );
    echo json_encode($result);

}
mysql_close($link);

?>