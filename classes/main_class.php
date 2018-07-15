<?php
    class main{
        static function display_errors(){
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }
        static function error_handler($err_number, $err_msg){//Smukāk template savā klasē un izsaukt no template klases?
            echo "<div class='error'>";
            echo "<b>Kļūda:</b></br>";
            echo "Kļūdas Numurs: [$err_number]</br>";
            echo "Kļūdas Paziņojums: $err_msg </br>";
            echo "Skripta darbība apturēta";
            echo "</div>";
            die();
        }
    }
?>