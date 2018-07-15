<?php
	require_once("main_class.php");
    class database{
		public function add_user($user_name,$user_email,$user_password){
			$connection = main::create_connection();
			$sql = 'INSERT INTO reg_users (usr_name, usr_email, usr_password)
					VALUES ("'.$user_name.'","'.$user_email.'","'.$user_password.'")';
			if($connection->query($sql) === TRUE){
				header("location:/index.php");
			}
			$connection->close();
		}
    }
?>