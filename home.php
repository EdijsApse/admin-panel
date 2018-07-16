<?php
	require_once("classes/main_class.php");
	require_once("classes/template_class.php");
	require_once("classes/database_class.php");
	require_once("classes/validation_class.php");
	main::display_errors();
	$template = new template();
	$database = new database();
	$validation = new validation();
    set_error_handler("main::error_handler");//Default error display function
    session_start();
    if(!isset($_SESSION["user"])){
        header("location:/");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		$template->get_head("Admin Panel");
	?>
</head>
<body>
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6"></div>
            <div class="col-md-3">
                <?php 
                    $template->get_right_sidebar($_SESSION["user"],$_SESSION["email"],$_SESSION["password"],$_SESSION["image"],$_SESSION["regdate"],$_SESSION["role"]);
                ?>
            </div>
        </div>
        <div class="row">
            
		</div>
	</div>
</body>
</html>
<?php
    if(isset($_POST["logout"])){
        session_destroy();
        header("location:/");
    }
?>