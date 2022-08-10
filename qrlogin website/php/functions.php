<?php
if(isset($_REQUEST['username'])) {
	session_id($_REQUEST['username']);	
}else {
	session_id("random");
}
session_id("abcd");
session_start();


include_once(dirname(__FILE__).DIRECTORY_SEPARATOR."db.php");

function login() {
	global $db;
	$data = base64_decode(mysqli_real_escape_string($db, $_REQUEST['username']));
	$userdata = explode("_", $data);
	$username = $userdata[1];
	$uniquekey = (mysqli_real_escape_string($db, $_REQUEST['uniquekey']));
/**/
	if(!empty($username) && !empty($uniquekey)) {
		$sql = "select * from `users` where `username` = '".$username."' and `unique_key` = '".$uniquekey."'";
		$result = $db->query($sql);
		$user = mysqli_fetch_row($result);
		if(!empty($user)) {
			$_SESSION['userid'] = $user[0];
			$_SESSION['username'] = $user[3];
			$_SESSION['uniquekey'] = $user[4];
			setcookie("username",$user[3],time() + 60*60*24*100,"/");
			setcookie("uniquekey",$user[4],time() + 60*60*24*100,"/");
		}else {
			$_SESSION['error_message'] = 'Failed to login';
		}
	}
}

function resetphone()
{
	global $db;
	if(!empty($_REQUEST['mobile'])) {
		$mob = mysqli_real_escape_string($db,$_REQUEST['mobile']);
		$sql = "select * from `users` where `mobile` = '".$mob."'";
		$result = $db->query($sql);
		$user = mysqli_fetch_row($result);
		if(!empty($user)) {
			$_SESSION['email'] = $user[3];
			$num = rand(1000,9999);
			$_SESSION['OTP'] = $num;
			$url = "http://103.16.101.52:8080/sendsms/bulksms?username=ams1-msproj&password=msproj&type=0&dlr=1&destination=".$user[5]."&source=MSPROJ&message=".$num;
			$curl_handle=curl_init();
			curl_setopt($curl_handle,CURLOPT_URL,$url);
			curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
			curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
			$buffer = curl_exec($curl_handle);
			curl_close($curl_handle);
			echo json_encode(array("email"=>$user[3],"OTP"=>$num));
		}
	}
}
function register() {
	global $db;
	$firstname = mysqli_real_escape_string($db, $_POST['fname']);
	$lastname = mysqli_real_escape_string($db, $_POST['lname']);
	$username = mysqli_real_escape_string($db, $_POST['reg_username']);
	$mobile = mysqli_real_escape_string($db, $_POST['mobile']);
	$uniquekey = mysqli_real_escape_string($db, $_SESSION['temp_uniquekey']);
	$sql = "select id from `users` where `username` = '".$username."'";
	$query = $db->query($sql);
	$result = mysqli_num_rows($query);
	if(empty($result)) {
		$sql = "insert into `users`(firstname,lastname,username,unique_key, mobile) values('".$firstname."','".$lastname."','".$username."','".$uniquekey."','".$mobile."')";
		$db->query($sql);
		$userid = mysqli_insert_id($db);
		$_SESSION['userid'] = $userid;
		$_SESSION['username'] = $username;
		$_SESSION['uniquekey'] = $uniquekey;
		setcookie("temp_username","",time() - 60*60*24*100,"/");
		setcookie("temp_uniquekey","",time() - 60*60*24*100,"/");
		header("Location: userdashboard.php");
	}else {
		$_SESSION['error'] = "That username is taken. Please try another.";
		header("Location: ../index.php");
	}
}

function setuniquekey() {
	global $db;
	$data = base64_decode(mysqli_real_escape_string($db, $_REQUEST['username']));
	$userdata = explode("_", $data);
	$username = $userdata[1];
	$uniquekey = (mysqli_real_escape_string($db, $_REQUEST['uniquekey']));
	$_SESSION['temp_username'] = $username;
	$_SESSION['temp_uniquekey'] = $uniquekey;
	$_COOKIE['temp_uniquekey'] = $uniquekey;
	setcookie("temp_username",$username,time() + 60*60*24*100,"/",$_SERVER['SERVER_NAME']);
	setcookie("temp_uniquekey",$uniquekey,time() + 60*60*24*100,"/",$_SERVER['SERVER_NAME']);
	if(!empty($_SESSION['OTP']) &&$_SESSION['email'] && $_SESSION['email'] == $username) {
		$sql = "update `users` set `unique_key` = '$uniquekey' where `username` = '".$username."'";
		$db->query($sql);
		$_SESSION['error_message'] = 'Your phone has been successfully updated. Please login.';
		$_SESSION['resetphone'] = 1;
	}
}

function getsession() {
	echo json_encode($_SESSION);
	exit;
}

if(!empty($_REQUEST['action'])) {
	call_user_func($_REQUEST['action']);
}

