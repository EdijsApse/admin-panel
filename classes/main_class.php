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
            die();//Will stop script execution
        }
        static function create_connection(){//Will return database connection
            $server_name = "localhost";
			$user_name = "root";
			$password = "";
			$db_name = "registration_db";
			$connection = new mysqli($server_name, $user_name, $password, $db_name);
			$connection->set_charset("utf8");//Set connection charset, so i can get data with Ā, Ē etc
			return $connection;
		}
    }
?>