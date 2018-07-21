<?php
require_once("classes/database_class.php");
require_once("classes/template_class.php");
main::display_errors();
$database = new database();
$template = new template();
set_error_handler("main::error_handler");//Default error display function
session_start();
if(isset($_SESSION["user"])){
    switch($_POST["purpose"]){
        case "change_user":
            if($_POST["new_password"] == $_POST["new_password_confirm"]){
                $database->change_user_information(
                    $_POST["user_id"],
                    $_POST["new_name"],
                    $_POST["new_email"],
                    $_POST["new_role"],
                    $_POST["new_password"]
                );
            }
            else{
                $template->show_notification("Jaunā parole nesakrīt!");
            }
            break;
        case "delete_user":
                $database->delete_user($_POST["user_id"]);
            break;
        case "green":
            echo "Your favorite color is green!";
            break;
        default:
            echo "Your favorite color is neither red, blue, nor green!";
    }
}
else{
    header("location:/");
}