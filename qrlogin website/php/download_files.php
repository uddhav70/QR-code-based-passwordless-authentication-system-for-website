<?php
if(isset($_REQUEST['fileid']) && !empty($_REQUEST['fileid'])) {
	if(isset($_SERVER['HTTP_REFERER'])) {
		include_once('functions.php');
		define('CIPHERKEY','jsldjlasjd');
		include_once('encryption.php');
		$files = array();
		$name = '';
		$content = '';
		$sql = ("select name,content from `files` where `id` = '".mysqli_real_escape_string($db,$_REQUEST['fileid'])."'");
		$result = $db->query($sql);
		if($result) {
			while($file = mysqli_fetch_assoc($result)) {
				$name = $file['name'];
				$content = $file['content'];
			}
			if(!empty($name) && !empty($content)) {
				$decrypt_content = aes128_decode($content);
				header('Content-disposition: attachment; filename='.$name.'');
				header('Content-type: text/plain');
				echo $decrypt_content;
				exit;
			}
		}
	}else{
		echo 'Nothing to look here.';
	}
}else {	
	echo "Invalid request.";
	exit;
}