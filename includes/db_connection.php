<?php


define("DB_SERVER", "localhost");
define("DB_USER", "abc");
define("DB_PASS", "123");
define("DB_NAME", "widget_corp");
$connection= mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

//test if connection occured
if(mysqli_connect_errno()){
	die("Database connection failed:".mysqli_connect_error()."(".mysqli_connect_errno().")");
}
?>