<?php
	require_once("main_class.php");
	require_once("template_class.php");
    class database{
			public function add_user($user_name,$user_email,$user_password){
				$connection = main::create_connection();
				$template = new template();
				$current_date = date("Y-m-d");
				$sql = 'INSERT INTO reg_users (usr_name, usr_email, usr_password, usr_regdate)
						VALUES ("'.$user_name.'","'.$user_email.'","'.$user_password.'","'.$current_date.'")';
				if($connection->query($sql) === TRUE){
					$template->show_notification("Esi veiksmīgi reģistrējies!");
				}
				else{
					$template->show_notification("Izskatās ka šāds lietotājs jau eksistē!");
				}
				$connection->close();
			}
			public function get_user($email, $password){
				$connection = main::create_connection();
				$template = new template();
				$sql = 'SELECT usr_id, usr_name, usr_email, usr_password, role_name, usr_regdate, usr_image
						FROM (reg_users INNER JOIN usr_roles ON reg_users.usr_role = usr_roles.role_id)
						WHERE usr_email="'.$email.'"AND usr_password="'.$password.'"';
				$result = $connection->query($sql);
				if($result->num_rows == 1){//Only 1 user will be in db, because email fild is unique
						$user = $result->fetch_assoc();
						session_start();
						$_SESSION["user_id"] = $user["usr_id"];
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
			public function search_user($name){
				$connection = main::create_connection();
				$sql = 'SELECT usr_id, usr_name, usr_image
						FROM reg_users
						WHERE usr_name LIKE "'.$name.'%"';
				$result = $connection->query($sql);
				$users = array();
				if($result->num_rows > 0){
					while($user = $result->fetch_assoc()){
						array_push($users, $user);
					}
					print_r(json_encode($users));
				}
				else{
					echo "Neviens lietotājs netika atrasts!";
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
			public function get_all_users($active_user_role){
				$connection = main::create_connection();
				$template = new template();
				$sql = 'SELECT usr_id, usr_name, role_name, usr_regdate, usr_image
						FROM (reg_users INNER JOIN usr_roles ON reg_users.usr_role = usr_roles.role_id);';
				$users = $connection->query($sql);
				if($users->num_rows > 0){
					while($user = $users->fetch_assoc()){
						$template->show_all_users($user["usr_id"], $user["usr_name"], $user["usr_image"], $active_user_role, $user["role_name"], $user["usr_regdate"]);
					}
				}
				$connection->close();
			}
			public function get_events($year,$month){
				$connection = main::create_connection();
				$sql = 'SELECT usr_regdate 
						FROM reg_users
						WHERE usr_regdate LIKE "%'.$month.'-'.$year.'%";';
				$reg_date_array = array();
				$reg_dates = $connection->query($sql);
				if ($reg_dates->num_rows > 0) {
					while($row = $reg_dates->fetch_assoc()) {//While there is reg_dates
						array_push($reg_date_array,$row);//Pusshing reg_date into array
					}
					print_r(json_encode($reg_date_array));//Returning array as JSON object
				}
				else{
					echo $connection->error;
				}
				$connection->close();
			}
			public function get_user_to_edit($user_id){
				$connection = main::create_connection();
				$template = new template();
				$sql = 'SELECT usr_id, usr_name, usr_email
						FROM reg_users
						WHERE usr_id ="'.$user_id.'"';
				$result = $connection->query($sql);
				if($result->num_rows != 1){
					header("location:/home");
				}
				else{
					$user = $result->fetch_assoc();
					$template->edit_profile(
						$user["usr_id"],
						$user["usr_name"],
						$user["usr_email"]);
				}
				$connection->close();
			}
			public function get_user_profile($user_id, $active_user_role){
				$connection = main::create_connection();
				$template = new template();
				$sql = 'SELECT usr_id, usr_name, usr_email, usr_password, role_name, usr_regdate, usr_image
				FROM (reg_users INNER JOIN usr_roles ON reg_users.usr_role = usr_roles.role_id)
				WHERE usr_id = "'.$user_id.'"';
				$result = $connection->query($sql);
				if($result->num_rows == 1){
					$user = $result->fetch_assoc();
					$template->user_profile(
						$active_user_role,
						$user["usr_id"],
						$user["usr_name"],
						$user["usr_email"],
						$user["usr_password"],
						$user["role_name"],
						$user["usr_regdate"],
						$user["usr_image"]);
				}
				else{
					header("location:/home");
				}
				$connection->close();
			}
			public function get_user_information($user_id){//ONLY FOR change_user_information function - to compare vals
				$connection = main::create_connection();
				$template = new template();
				$user_arr = array();
				$sql = 'SELECT usr_id, usr_name, usr_email, usr_role, usr_password, role_name
						FROM (reg_users INNER JOIN usr_roles ON reg_users.usr_role = usr_roles.role_id)
						WHERE usr_id ="'.$user_id.'"';
				$result = $connection->query($sql);
				if($result->num_rows > 0){
					$user = $result->fetch_assoc();
					$user_arr["user_name"] = $user["usr_name"];
					$user_arr["user_email"] = $user["usr_email"];
					$user_arr["user_role"] = $user["usr_role"];
					$user_arr["role_name"] = $user["role_name"];
					$user_arr["user_password"] = $user["usr_password"];
				}
				else{
					//Nekad nevajadzētu nostrādāt!!!
					$template->show_notification("Datubāzē netika atrasts šāds lietotājs");
					die();
				}
				$connection->close();
				return $user_arr;
			}
			public function change_user_information($user_id, $user_name,$user_email, $user_role, $user_password){
				$connection = main::create_connection();
				$template = new template();
				$original_user_info = $this->get_user_information($user_id);
				$user_information_array = array(
					"user_name"=>$user_name,
					"user_email"=>$user_email,
					"user_role"=>$user_role,
					"user_password"=>$user_password
				);
				if($user_information_array["user_role"] == "0"){
					$user_information_array["user_role"] = $original_user_info["user_role"];
				}
				$sql = 'UPDATE reg_users
						SET usr_name="'.$user_information_array["user_name"].'",
							usr_email="'.$user_information_array["user_email"].'",
							usr_password="'.$user_information_array["user_password"].'",
							usr_role="'.$user_information_array["user_role"].'"
						WHERE usr_id="'.$user_id.'"';
				if ($connection->connect_error) {
					die($template->show_notification("Problēmas pieslēgties datubāzei: " . $connection->connect_error));
				}		
				if ($connection->query($sql) === TRUE) {
					$template->show_notification("Lietotāja informācija atjaunota veiksmīgi!");
				} else {
					$template->show_notification("Lietotāja informācija netika atjaunota!");
				}
				$connection->close();
				session_start();
				if($_SESSION["user_id"] == $user_id){//If loged user changes his info
					$connection = main::create_connection();
					$sql = 'SELECT role_name
							FROM usr_roles
							WHERE role_id = "'.$user_information_array["user_role"].'"';
					$result = $connection->query($sql);
					if($result->num_rows > 0){
						$role_name = $result->fetch_assoc();
						$_SESSION["role"] = $role_name["role_name"];
					}
					else{
						$template->show_notification("Šāda loma nepastāv!");
					}
					$_SESSION["user"] = $user_information_array["user_name"];
					$_SESSION["email"] = $user_information_array["user_email"];
					$_SESSION["password"] = $user_information_array["user_password"];
					$connection->close();
				}
			}
			public function delete_user($active_user_id,$user_id){
				$connection = main::create_connection();
				$template = new template();
				$sql = 'DELETE FROM reg_users WHERE usr_id="'.$user_id.'"';
				if($connection->query($sql) === TRUE){
					if($active_user_id == $user_id){
						session_destroy();
					}
					$template->show_notification("Lietotājs izdzēsts veiksmīgi!");
				}
				else{
					$template->show_notification("Lietotājs netika izdzēsts!");
				}
				$connection->close();
			}
			public function get_specific_day_event($date){
				$connection = main::create_connection();
				$template = new template();
				$sql = 'SELECT usr_name, role_name, usr_image
						FROM (reg_users INNER JOIN usr_roles ON reg_users.usr_role = usr_roles.role_id)
						WHERE usr_regdate="'.$date.'"';
				$user_arr = array();
				$result = $connection->query($sql);
				if ($result->num_rows > 0){
					while($user = $result->fetch_assoc()){
						array_push($user_arr, $user);
					};
				}
				else{
					$template->show_notification("Šajā datumā lietotāju nav!");
					die();
				}
				$connection->close();
				print_r(json_encode($user_arr));//So i can decode in JS
			}
			public function add_message($from, $to, $title, $content){
				$connection = main::create_connection();
				$template = new template();
				$sql = "INSERT INTO usr_messages (msg_title, msg_content, msg_from, msg_to)
						VALUES ('".$title."','".$content."','".$from."','".$to."')";
				if($connection->query($sql) === TRUE){
					$template->show_notification("Vēstule nosūtīta!");
				}
				else{
					$template->show_notification("Vēstule diemžēl netika nosūtīta!");
				}
				$connection->close();
			}
    }
?>