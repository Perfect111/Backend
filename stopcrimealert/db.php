<?php

$host = 'localhost';
// $db = 'stopcrim_alertdb';
// $db_user = 'root';
// $db_passwd = '';
$db = 'alert_stopcrim_alertDb';
$db_user = 'alert_stopcrime';
$db_passwd = 'alertDb12345!';

// $domain_link = "http://192.168.3.91/";
$domain_link = "http://alertt.us/";
/*
$link = mysqli_connect($host, $db_user, $db_passwd, $db);

if (!$link) {
    echo '1';
    exit;
}
*/
$link = mysql_connect($host, $db_user, $db_passwd);

if (!$link) {
    echo '1';
    exit;
}

mysql_select_db($db);

?>