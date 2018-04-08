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
    $text = $request->text;
    $photo = $request->photo;
    $tid = $request->tid;
    $device = isset($request->device)? $request->device: '';
    
    if($tid == '') {
        $tid = '1';
    }

    $dt = new DateTime("now");
    $time = $dt->format('Y-m-d h:i:s');
    
    if($photo) {
        $file_name = "upload/".$uid."_".$tid."_".md5($time).".png";
        if($device) {
            $data = base64_decode($photo);
        } else {
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo));
        }
        file_put_contents($file_name, $data);
    } else {
        $file_name = "";
    }

    $insert_sql = "INSERT INTO `report`(`uid`, `location`, `text`, `photo`, `tid`, `time`) VALUES ('".$uid."', '".$location."', '".$text."', '".$file_name."', '".$tid."', '".$time."')";
    // mysqli_query($link, $insert_sql);
    mysql_query($insert_sql, $link);
    
    $result = array(
        'echo' =>'3',
        'data' => $request
    );

}
mysql_close($link);

?>