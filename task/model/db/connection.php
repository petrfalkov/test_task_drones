<?php
//connect to database 'drone_assets'
$host="localhost";
$user="root";
$pass="root";
$db_name="drone_assets";
$link = mysql_connect('localhost', 'root', 'root');
mysql_select_db($db_name,$link);
?>