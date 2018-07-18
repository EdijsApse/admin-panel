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
				$sql = 'SELECT usr_name, usr_email, usr_password, role_name, usr_regdate, usr_image
						FROM (reg_users INNER JOIN usr_roles ON reg_users.usr_role = usr_roles.role_id)
						WHERE usr_email="'.$email.'"AND usr_password="'.$password.'"';
				$result = $connection->query($sql);
				if($result->num_rows == 1){//Only 1 user will be in db, because email fild is unique
						$user = $result->fetch_assoc();
						session_start();
						$_SESSION["user"] = $user["usr_name"];
						$_SESSION["role"] = $user["role_name"];
						$_SESSION["email"] = $user["usr_email"];
						$_SESSION["password"] = $user["usr_password"];
						$_SESSION["regdate"] = $user["usr_regdate"];
						$_SESSION["image"] = $user["usr_image"];
						header("location:home");
				}
				else{
					$template->show_notification("E-Pasta adrese vai Parole nav derīga");
				}
				$connection->close();
			}
			public function change_image($user_email,$new_image){
				$connection = main::create_connection();
				$template = new template();
				$sql = 'UPDATE reg_users
				SET usr_image = "'.$new_image.'"
				WHERE usr_email = "'.$user_email.'";';
				$result = $connection->query($sql);
				if($result === TRUE){
					session_start();
					$_SESSION["image"] = $new_image;
				}
				else{
					$template->show_notification("Kļūda mainot datubāzes lauku");
					echo $connection->error;
					die();
				}
				$connection->close();
			}
			public function get_all_users($user_role){
				$connection = main::create_connection();
				$template = new template();
				$sql = "SELECT usr_name, usr_image
						FROM reg_users;";
				$users = $connection->query($sql);
				if($users->num_rows >= 1){
					while($user = $users->fetch_assoc()){
						$template->show_all_users($user["usr_name"], $user["usr_image"],$user_role);
					}
				}
				$connection->close();
			}
    }
?>