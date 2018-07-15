<?php
	require_once("classes/main_class.php");
	require_once("classes/template_class.php");
	require_once("classes/database_class.php");
	require_once("classes/validation_class.php");
	main::display_errors();
    $template = new template();
	$database = new database();
	$validation = new validation();
	set_error_handler("main::error_handler");//Default error display function
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		$template->get_head("Registration Page");
	?>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
					<form action="registration.php" class="login-form" method="POST">
                        <div class="form-group">
						  <label for="email">Lietotāja vārds:</label>
						  <input type="text" class="form-control" id="user_name" name="user_name">
						</div>
                        <div class="form-group">
						  <label for="email">E-Pasta Adrese:</label>
						  <input type="email" class="form-control" id="email" name="email">
						</div>
						<div class="form-group">
						  <label for="pwd">Parole:</label>
						  <input type="password" class="form-control" id="password" name="password">
						</div>
						<button type="submit" class="btn btn-primary registrate" name="registrate">Reģistrēties</button>
					</form>
			</div>
		</div>
	</div>
</body>
</html>
<?php
	if(isset($_POST["registrate"])){
		$user_input = [$_POST["user_name"],$_POST["email"],$_POST["password"]];
		foreach($user_input as $value){
			$validation->is_long_enough($value);
		}
		$is_email = $validation->is_email($_POST["email"]);
		if($is_email){
			$database->add_user($_POST["user_name"],$_POST["email"],$_POST["password"]);
		}
	}
?>