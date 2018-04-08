<?php

header('Access-Control-Allow-Origin: *');

include_once('db.php');

$sql = "select * from type";
// $sql_result = mysqli_query($link, $sql);
$sql_result = mysql_query($sql, $link);
$num = 0;
// while($row = mysqli_fetch_array($sql_result)) {
while($row = mysql_fetch_array($sql_result)) {
        $tmp[$num] = array(
        'index' => $num,
        'tid' => $row['tid'],
        'kind' => $row['kind']
    );
    $num++;
}
$result = array(
    'echo' => '3',
    'data' => $tmp
);
echo json_encode($result);

mysql_close($link);

?>