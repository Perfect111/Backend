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

    // $valid_sql = "select * from comment where rid='".$rid."' ";
    $valid_sql = "select count(*) from comment where rid='".$rid."' ";
    // $sql_result = mysqli_query($link, $valid_sql);
    $sql_result = mysql_query($valid_sql, $link);
    // if(mysqli_num_rows($sql_result) != '0') {
    if(mysql_result($sql_result, 0) != '0') {
            //        $data = [];
        $valid_sql = "select * from comment where rid='".$rid."' ORDER BY cid DESC";
        // $sql_result = mysqli_query($link, $valid_sql);
        $sql_result = mysql_query($valid_sql, $link);
        $num = 0;
        // while($row = mysqli_fetch_array($sql_result)) {
        while($row = mysql_fetch_array($sql_result)) {
            $u_sql = "select * from user where uid='".$row['uid']."'";
            // $u_result = mysqli_query($link, $u_sql);
            $u_result = mysql_query($u_sql, $link);
            // $u_row = mysqli_fetch_array($u_result);
            $u_row = mysql_fetch_array($u_result);
            $u_full_name = $u_row['f_name']." ".$u_row['l_name'];

            $date1 = new DateTime(date('Y-m-d h:i:s', strtotime($row['time'])));
            $date2 = new DateTime(date('Y-m-d h:i:s', strtotime(date("Y-m-d h:i:s"))));
            $r_i_time = $date1->diff($date2)->i;
            $r_h_time = $date1->diff($date2)->h;
        
            $r_time = ($r_h_time > 0)? $r_h_time."hours ".$r_i_time : $r_i_time;
            $photo = '';
            if($row['photo']) {
                $photo = $domain_link.'stopcrimealert/'.$row['photo'];
            }           
            $tmp = array(
                'name' => $u_full_name,
                'text' => $row['comment'],
                'time' => $r_time,
                'photo' => $photo
            );

            $data[$num] = $tmp;
            $num++;
        }
        $result = array(
            'echo' =>'3',
            'count' => $num,
            'data' => $data
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

mysql_close($link);

?>