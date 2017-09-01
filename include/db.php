<?php

$db_host = 'localhost:8080';
$db_user = 'root';
$db_pass = '';
$db_name = 'cms';


$conn = mysql_connect($db_host,$db_user,$db_pass);
mysql_select_db($db_name);

?>