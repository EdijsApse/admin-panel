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
            $user_old_information = $database->get_user_information($_POST["user_id"]);
            if($_POST["new_password"] == $_POST["new_password_confirm"]){
                $user_new_information = array(
                    "user_name"=>$_POST["new_name"],
                    "user_email"=>$_POST["new_email"],
                    "user_role"=>$_POST["new_role"],
                    "user_password"=>$_POST["new_password"]
                );
                foreach($user_new_information as $key=>$value){
                    if($user_old_information[$key] != $value){
                        switch($key){
                            case "user_name":{

                                $validation->is_valid_name($value);
                                $validation->is_long_enough($value);
                                break;
                            }
                            case "user_email":{
                                $validation->is_email($value);
                                $validation->is_long_enough($value);
                                break;
                            }
                            case "user_role":{
                                if(!is_numeric($value)){
                                    $template->show_notification("Es zinu ko tu mēģinin izdarīt!");
                                    die();
                                }
                                break;
                            }
                            case "user_password":{
                                if(strlen($value) == 0){
                                    $_POST["new_password"] = $user_old_information[$key];
                                }
                                else{
                                    $validation->is_long_enough($value);
                                }
                                break;
                            }
                            default:{
                                $template->show_notification("Lūgums mēģināt vēlreiz!");
                                die();
                            }
                        }
                    }
                    else{
                        $user_new_information[$key] = $user_old_information[$key];
                    }
                }
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
            $valid_name = $validation->is_valid_name($_POST["user_name"]);
            $user_input = [$_POST["user_name"],$_POST["user_email"],$_POST["user_password"]];
            foreach($user_input as $value){
                //Uztaisīt tāpat kā change_user switchā
                $validation->is_long_enough($value);
            }
            $is_email = $validation->is_email($_POST["user_email"]);
            $database->add_user($_POST["user_name"],$_POST["user_email"],$_POST["user_password"]);
            break;
        default:
            echo "";
    }
}
else{
    header("location:/");
}