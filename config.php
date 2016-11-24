<?php

//session_start();

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);


$db = "ron178";
$host = "localhost";
$user = "ron178";
$pass = "5qMXuMiy";


mysql_connect($host, $user, $pass); 

mysql_select_db($db);

mysql_query("SET CHARACTER SET 'utf8'");

//mysql_query("SET NAMES 'utf8'");
//mysql_query("SET CHARACTER SET 'utf8'");


//if($rt == "true") {echo "eeeeeeeeeeeeeeee";} else {echo "ccccccccccc";}
