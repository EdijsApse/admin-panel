<?php
    class database{
        static function create_connection(){
            $server_name = "localhost";
			$user_name = "root";
			$password = "";
			$db_name = "socia";
			$connection = new mysqli($server_name, $user_name, $password, $db_name);
			if ($conn->connect_error) {
    			die("<h1>Neizdevās pieslēgties datubāzei: </h1>" . $conn->connect_error);
			}
			$conn->set_charset("utf8");
			return $conn;
        }
    }
?>