<?php
	require_once("main_class.php");
	require_once("template_class.php");
    class database{
			public function add_user($user_name,$user_email,$user_password){
				$connection = main::create_connection();
				$current_date = date("Y-m-d");
				$sql = 'INSERT INTO reg_users (usr_name, usr_email, usr_password, usr_regdate)
						VALUES ("'.$user_name.'","'.$user_email.'","'.$user_password.'","'.$current_date.'")';
				if($connection->query($sql) === TRUE){
					header("location:/");//Back to index
				}
				$connection->close();
			}
			public function get_user($email, $password){
				$connection = main::create_connection();
				$template = new template();
				$sql = 'SELECT usr_name, usr_email, usr_password, role_name
						FROM (reg_users INNER JOIN usr_roles ON reg_users.usr_role = usr_roles.role_id)
						WHERE usr_email="'.$email.'"AND usr_password="'.$password.'"';
				$result = $connection->query($sql);
				if($result->num_rows == 1){//Only 1 user will be in db, because email filde is unique
						$user = $result->fetch_assoc();
						session_start();
						$_SESSION["user"] = $user["usr_name"];
						$_SESSION["role"] = $user["role_name"];
						header("location:home.php");
				}
				else{
					$template->show_notification("E-Pasta adrese vai Parole nav derīga");
				}
				$connection->close();
			}
    }
?>