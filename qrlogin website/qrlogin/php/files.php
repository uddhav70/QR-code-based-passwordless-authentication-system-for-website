<?php 
if(isset($_POST['getfile']) && $_POST['getfile'] == 1) {
	include_once('functions.php');
	$files = array();
	$sql = ("select id,name,type,size from `files` where userid = '".$_SESSION['userid']."'");
	$result = $db->query($sql);
	if($result) {
		while($file = mysqli_fetch_assoc($result)) {
			$files[$file['id']]['name'] = $file['name'];
			$files[$file['id']]['type'] = $file['type'];
			$files[$file['id']]['size'] = $file['size'];
		}
		if(!empty($files)) {
			echo json_encode($files);
			exit;
		}else {
			echo "No result found";
		}
	}
}else {	
	echo "Invalid request.";
	exit;
}