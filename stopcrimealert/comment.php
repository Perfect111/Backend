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
    $text = $request->text;
    $photo = $request->photo;
    $device = isset($request->device)? $request->device: '';
    
    $dt = new DateTime("now");
    $time = $dt->format('Y-m-d h:i:s');

    if($photo) {
        $file_name = "upload/c".$uid."_".$rid."_".md5($time).".jpg";
        if($device) {
            $data = base64_decode($photo);
        } else {
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo));
        }
        file_put_contents($file_name, $data);
    } else {
        $file_name = "";
    }

    $insert_sql = "INSERT INTO `comment`(`rid`, `uid`, `comment`, `time`, `photo`) VALUES ('".$rid."', '".$uid."', '".$text."', '".$time."', '".$file_name."')";
    // mysqli_query($link, $insert_sql);
    mysql_query($insert_sql, $link);
    
    $result = array(
        'echo' =>'3',
    );
    echo json_encode($result);

}
mysql_close($link);

?>