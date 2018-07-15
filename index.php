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
		$template->get_head("Login Page");
	?>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
					<form action="index.php" class="login-form" method="POST" novalidate>
						<div class="form-group">
						  <label for="email">E-Pasta Adrese:</label>
						  <input type="email" class="form-control" id="email" name="email" autocomplete="email">
						</div>
						<div class="form-group">
						  <label for="password">Parole:</label>
						  <input type="password" class="form-control" id="password" name="password" autocomplete="password">
						</div>
						<button type="submit" class="btn btn-default login" name="login">Ieiet <span class="glyphicon glyphicon-log-in"></span></button>
						<button type="submit" class="btn btn-primary registrate" name="registrate">Reģistrēties</button>
					</form>
			</div>
		</div>
	</div>
</body>
</html>
<?php
	if(isset($_POST["login"])){
		$database->get_user($_POST["email"],$_POST["password"]);
	}
	if(isset($_POST["registrate"])){
		header("location:registration.php");
	}
?>