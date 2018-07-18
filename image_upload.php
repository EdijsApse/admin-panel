<?php
	require_once("classes/main_class.php");
	$main = new main();
	session_start();
	if(isset($_SESSION["user"])){
		$main->upload_image($_POST["change_image"],$_FILES["selected_image"]);
	}
	else{
		header("location:/");
		//Par cik es zinu, ka pie image_upload faila var tikt tikai caur home lapu un pie home lapas var tikt tikai tad, ja esi ielogojies
	}
?>