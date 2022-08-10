<?php
session_start();
session_destroy();
if(isset($_POST['unsetsession'])) {
	echo '1';
	exit;
}
setcookie("username",$username,time() - 60*60*24*100,"/");
setcookie("uniquekey",$uniquekey,time() - 60*60*24*100,"/");
header('Location: ../index.php');