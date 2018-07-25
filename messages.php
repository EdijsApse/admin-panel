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
        $template->get_head("Messages");
	?>
</head>
<body>
    <div class="notification">
        <div class="message_container">
        </div>
    </div>
    <div class="preview_container">
        <div class="preview">
            <button class="btn btn-default close_users">Aizvērt logu</button>
        </div>
    </div>
    <div class="send_message_container">
        <form class="send_message_form" id="send_message_form">
            <div class="input-group">
                <input type="text" class="form-control" name="search_user" placeholder="Meklēt lietotāju...">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </div>
            </div>
            <div class="retrieved_users">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="title" autocomplete="title" placeholder="Vēstules virsraksts">
            </div>
            <textarea id="message_content" form="send_message_form" placeholder="Vēstules saturs..."></textarea>
            <div class="button_container">
                <button type="button" class="btn btn-default send" name="send">Sūtīt</button>
                <button type="button" class="btn btn-default cancel">Aizvērt</button>
            </div>
        </form>
    </div>
    <div class="sent_message_container">
        <?php
            template::get_my_sent_messages();
        ?>
    </div>
    <div class="container-fluid">
        <?php 
            template::get_menu();
        ?>
        <div class="row">
            <div class="col-md-3 left">
                <?php
                    template::get_left_sidebar();
                ?>
            </div>
            <div class="col-md-6 main">
                <?php 
                    template::get_messages();
                ?>
            </div>
            <div class="col-md-3 right">
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