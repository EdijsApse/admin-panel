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
        <div class="header">
            <form method="POST">
                <div class="user_detail">
                    <p>Lietotājs:<b><?php echo $_SESSION["user"];?></b></p>
                    <p>Tiesības:<b><?php echo $_SESSION["role"];?></b></p>
                </div>
                <button class="btn btn-danger btn-md" type="submit" formmethod="post" name="logout">Iziet <span class="glyphicon glyphicon-log-out"></span></button>
            </form>
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