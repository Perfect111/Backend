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

    $valid_sql = "select * from user";
    // $sql_result = mysqli_query($link, $valid_sql);
    $sql_result = mysql_query($valid_sql, $link);
    $num = 0;
    // while($row = mysqli_fetch_array($sql_result)) {
    while($row = mysql_fetch_array($sql_result)) {
        // $valid_sql = "select * from report where uid='".$row['uid']."'";
        $valid_sql = "select count(*) from report where uid='".$row['uid']."'";
        // $c_result = mysqli_query($link, $valid_sql);
        $c_result = mysql_query($valid_sql, $link);
        // $c_num = mysqli_num_rows($c_result);
        $c_num = mysql_result($c_result, 0);
        
        $l_sql = "select time from report where uid='".$row['uid']."' ORDER BY time DESC LIMIT 1";
        // $sqlL_result = mysqli_query($link, $l_sql);
        $sqlL_result = mysql_query($l_sql, $link);
        $time = "";
        // while ($l_result = mysqli_fetch_array($sqlL_result)) {
        while ($l_result = mysql_fetch_array($sqlL_result)) {
            $time = $l_result['time'];
            break;
        }

        $tmp = array(
            'name'=> $row['f_name']." ".$row['l_name'],
            'count'=> $c_num,
            'time'=> $time,
            'uid'=> $row['uid'],
            'location'=> $row['location']
        );
        $data[$num] = $tmp;
        $num++;
    };


    $result = array(
        'echo'=> '3',
        'data'=>$data
    );
    echo json_encode($result);
}

mysql_close($link);

?>