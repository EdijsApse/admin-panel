<?php
session_start();
if($_SESSION["user"]){
    echo "Sveiks " . $_SESSION["user"];
}
else{
    header("location:/");
}
?>