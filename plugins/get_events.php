<?php
require_once("../classes/database_class.php");
$database = new database();
session_start();
if(isset($_SESSION["user"])){
    $database->get_events($_POST["event_month"],$_POST["event_year"]);
}
else{
    header("location:/");
}
?>