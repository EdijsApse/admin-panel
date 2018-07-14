<?php
	require_once("classes/main_class.php");
	require_once("classes/template_class.php");
	main::show_errors();
	$template = new template();
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
					<form action="index.php" class="login-form" method="POST">
						<div class="form-group">
						  <label for="email">E-Pasta Adrese:</label>
						  <input type="email" class="form-control" id="email">
						</div>
						<div class="form-group">
						  <label for="pwd">Parole:</label>
						  <input type="password" class="form-control" id="password">
						</div>
						<button type="submit" class="btn btn-default login" name="login">Ieiet</button>
						<button type="submit" class="btn btn-primary registrate" name="registrate">Reģistrēties</button>
					</form>
					<?php
						if(isset($_POST["login"])){

						}
						if(isset($_POST["registrate"])){

						}
					?>
			</div>
		</div>
	</div>
</body>
</html>