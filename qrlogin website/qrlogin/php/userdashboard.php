<?php
include_once('encryption.php');
include_once('functions.php');
if(!isset($_SESSION['userid'])) {
	header('Location: ../index.php');
}

if(isset($_POST['submit']) && $_FILES['file']['size'] > 0)
{
	$userid = @$_SESSION['userid'];
	$fileName = $_FILES['file']['name'];
	$tmpName  = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileType = $_FILES['file']['type'];
	$key = md5(uniqid($fileName, true));
	define('CIPHERKEY','jsldjlasjd');
	$fp      = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	$content = addslashes($content);
	fclose($fp);

	if(!get_magic_quotes_gpc())
	{
	    $fileName = addslashes($fileName);
	}
	$content = aes128_encode($content);
	$sql = ("insert into `files` (name,userid, size, type, content) VALUES ('$fileName', $userid, '$fileSize', '$fileType', '$content')");

	$db->query($sql);
	$success = 'Suucessfully uploaded.';
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome</title>
	<link rel="stylesheet" type="text/css" href="../css/style2.css" />
  <script type="text/javascript" src="../js/jquery.min.js"></script>
  <style type="text/css">
  	input[type=submit] {
	width: 70px;
	height: 30px;
	margin-top: 10px;
	color: #fff;
	background-color: #004280;
	border-radius: 4px;
	border: 1px solid #004280;
}
  </style>
</head>
<body>
	<div class="wrapper">
		 <ul>
			<li><a href="">Home</a></li>
			<li><a id="view-files-user" href="#">Files</a></li>
			<li><a id = "about" href="#">About</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul> 
	</div>
	<div id="display-content">
		<div id="files-upload">
			<form method="post" action="" enctype="multipart/form-data">
			<label><strong><?php echo isset($success)?$success:'';?></strong></label></br>
				<h2>Upload files:</h2></br>
				<input type="file" name="file" id="file" class="inputfile" />
				<label for="file">Choose a file</label>
				<input id="file-submit" type="submit" name = "submit" value="Save" />
			</form>
		</div>
	</div>
<script type="text/javascript" src="../js/qr.js"></script>
</body>
</html>