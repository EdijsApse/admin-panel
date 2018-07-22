<?php
require_once("classes/database_class.php");
require_once("classes/template_class.php");
require_once("classes/validation_class.php");
main::display_errors();
$database = new database();
$template = new template();
$validation = new validation();
$main = new main();
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
                $database->delete_user($_SESSION["user_id"],$_POST["user_id"]);
            break;
        case "registrate":
            $user_input = [$_POST["user_name"],$_POST["user_email"],$_POST["user_password"]];
            foreach($user_input as $value){
                $validation->is_long_enough($value);
            }
            $is_email = $validation->is_email($_POST["user_email"]);
            if($is_email){
                $database->add_user($_POST["user_name"],$_POST["user_email"],$_POST["user_password"]);
            }
            else{
                $template->show_notification("E-pasta adrese nav derīga!");
            }
            break;
        default:
            echo "";
    }
}
else{
    header("location:/");
}