<?php

header('Access-Control-Allow-Origin: *');

include_once('db.php');

$postdata = file_get_contents("php://input");

    // $sql = "select * from report ORDER BY rid DESC limit 0, 10";
    $sql = "select count(*) from report ORDER BY rid DESC limit 0, 10";
    // $sql_result = mysqli_query($link, $sql);
    $sql_result = mysql_query($sql, $link);
    // if(mysqli_num_rows($sql_result) != '0') {
    if(mysql_result($sql_result, 0) != '0') {
            // $data = [];
        $sql = "select * from report ORDER BY rid DESC limit 0, 10";
        // $sql_result = mysqli_query($link, $sql);
        $sql_result = mysql_query($sql, $link);
        $num = 0;
        // while($row = mysqli_fetch_array($sql_result)) {
        while($row = mysql_fetch_array($sql_result)) {
            $u_sql = "select * from user where uid='".$row['uid']."'";
            // $u_result = mysqli_query($link, $u_sql);
            $u_result = mysql_query($u_sql, $link);
            // $u_row = mysqli_fetch_array($u_result);
            $u_row = mysql_fetch_array($u_result);
            $u_full_name = $u_row['f_name']." ".$u_row['l_name'];

            // $c_sql = "select * from comment where rid='".$row['rid']."'";
            $c_sql = "select count(*) from comment where rid='".$row['rid']."'";
            // $c_result = mysqli_query($link, $c_sql);
            $c_result = mysql_query($c_sql, $link);
            // $c_num = mysqli_num_rows($c_result);
            $c_num = mysql_result($c_result, 0);
            
            $kind_name = "";
            switch ($row['tid']) {
                case '1':
                    $kind_name = "Hijacking";
                    break;
                case '2':
                    $kind_name = "Stolen cars";
                    break;
                case '3':
                    $kind_name = "Kidnapping";
                    break;
                default:
                    $kind_name = "Hijacking";
                    break;
            }

            $date1 = new DateTime(date('Y-m-d h:i:s', strtotime($row['time'])));
            $date2 = new DateTime(date('Y-m-d h:i:s', strtotime(date("Y-m-d h:i:s"))));
            $r_i_time = $date1->diff($date2)->i;
            $r_h_time = $date1->diff($date2)->h;
        
            $r_time = ($r_h_time > 0)? $r_h_time."hours ".$r_i_time : $r_i_time;

            // $like_sql = "select * from like_crime where rid='".$row['rid']."'";
            $like_sql = "select count(*) from like_crime where rid='".$row['rid']."'";
            // $like_sql_result = mysqli_query($link, $like_sql);
            $like_sql_result = mysql_query($like_sql, $link);
            // if(mysqli_fetch_array($like_sql_result))
            if(mysql_fetch_array($like_sql_result)) {
                // $num_like = mysqli_num_rows($like_sql_result);
                $num_like = mysql_result($like_sql_result, 0);
            }
            else
                $num_like = 0;
        
            $photo = '';
            if($row['photo']) {
                $photo = $domain_link.'stopcrimealert/'.$row['photo'];
            }           
    
            $tmp = array(
                'rid' => $row['rid'],
                'uid' => $u_row['uid'],
                'name' => $u_full_name,
                'location' => $row['location'],
                'time' => $r_time,
                'text' => $row['text'],
                'photo' => $photo,
                'com_num' => $c_num,
                'type' => $row['tid'],
                'kind_name' => $kind_name,
                'num' => $num_like
            );
            $data[$num] = $tmp;
            $num++;
        }

        $result = array(
            'echo' => '3',
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

// }

mysql_close($link);

?>