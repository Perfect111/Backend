<?php

header('Access-Control-Allow-Origin: *');

include_once('db.php');


$valid_sql = "select * from sos";
// $sql_result = mysqli_query($link, $valid_sql);
$sql_result = mysql_query($valid_sql, $link);

$num = 0;
$tmp = [];

// while($row = mysqli_fetch_array($sql_result)) {
while($row = mysql_fetch_array($sql_result)) {
    $location = $row['location'];
    $state = ($row['state'] == '1')? "Solved" : "Requested";

    $date1 = new DateTime(date('Y-m-d h:i:s', strtotime($row['time'])));
    $date2 = new DateTime(date('Y-m-d h:i:s', strtotime(date("Y-m-d h:i:s"))));
    $r_i_time = $date1->diff($date2)->i;
    $r_h_time = $date1->diff($date2)->h;

    $r_time = ($r_h_time > 0)? $r_h_time."hours ".$r_i_time : $r_i_time;
    
    $u_sql = "select * from user where uid='".$row['uid']."'";
    // $u_result = mysqli_query($link, $u_sql);
    $u_result = mysql_query($u_sql, $link);
    // $u_row = mysqli_fetch_array($u_result);
    $u_row = mysql_fetch_array($u_result);
    
    $name = $u_row['f_name']." ".$u_row['l_name'];

    $tmp[$num] = array(
        'location' => $location,
        'state' => $state,
        'time' => $r_time,
        'name' => $name,
        'id' => $row['sid']
    );

    $num++;
}

echo json_encode($tmp);

mysql_close($link);

?>