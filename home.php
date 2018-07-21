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
    if(isset($_SESSION["user"])){
    }
    else{
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
    <div class="notification">
        <div class="message_container">
        </div>
    </div>
	<div class="container-fluid">
        <div class="navbar navbar-inerse">
            <?php 
                template::get_menu();
            ?>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?php
                    template::get_left_sidebar();
                ?>
            </div>
            <div class="col-md-6">
                <div class="main">
                    <?php
                        if(isset($_SESSION["role"])){
                            $role = $_SESSION["role"];
                        }
                        else{
                            $role = "Guest";
                        }
                        $database->get_all_users($role);
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <?php
                    $template->get_right_sidebar($_SESSION["user_id"],$_SESSION["user"],$_SESSION["email"],$_SESSION["password"],$_SESSION["image"],$_SESSION["regdate"],$_SESSION["role"]);
                ?>
            </div>
        </div>
	</div>
</body>
<script src="plugins/modules/main.js"></script>
<script src="plugins/controllers/main.js"></script>
</html>
<?php
    if(isset($_POST["logout"])){
        session_destroy();
        header("location:/");
    }
?>