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
    // $rid = '1';

    $valid_sql = "select u.f_name, u.l_name, t.kind, r.rid, r.location, r.text, r.photo, r.time from report as r, user as u, type as t where r.rid='".$rid."' and r.tid=t.tid and r.uid=u.uid";
    // $sql_result = mysqli_query($link, $valid_sql);
    $sql_result = mysql_query($valid_sql, $link);
    // $row = mysqli_fetch_array($sql_result);
    $row = mysql_fetch_array($sql_result);
    $date1 = new DateTime(date('Y-m-d h:i:s', strtotime($row['time'])));
    $date2 = new DateTime(date('Y-m-d h:i:s', strtotime(date("Y-m-d h:i:s"))));
    $r_i_time = $date1->diff($date2)->i;
    $r_h_time = $date1->diff($date2)->h;

    $r_time = ($r_h_time > 0)? $r_h_time."hours ".$r_i_time : $r_i_time;

    // $sql = "select * from like_crime where rid='".$rid."'";
    $sql = "select count(*) from like_crime where rid='".$rid."'";
    // $sql_result = mysqli_query($link, $sql);
    $sql_result = mysql_query($sql, $link);
    // if(mysqli_fetch_array($sql_result))
    if(mysql_fetch_array($sql_result)) {
        // $num = mysqli_num_rows($sql_result);
        $num = mysql_result($sql_result, 0);
    }
    else
        $num = 0;
    $result = array(
        'echo' =>'3',
        'data' => $row,
        'event' => $r_time,
        'like' => $num
    );
    echo json_encode($result);
}

mysql_close($link);

?>