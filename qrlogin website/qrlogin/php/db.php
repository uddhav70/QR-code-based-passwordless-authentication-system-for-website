<?php
define('HOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'qrlogin');
$db  = new mysqli(HOST,DBUSER,DBPASS,DBNAME);
if($db->connect_error) {
	die("Error: ".$db->connect_error);	
}	

?>