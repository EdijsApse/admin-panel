<?php
	require_once("classes/main_class.php");
	require_once("classes/template_class.php");
	require_once("classes/database_class.php");
	main::display_errors();
    $template = new template();
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
	<div class="notification">
		<div class="message_container">
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
					<form class="login-form" novalidate>
                        <div class="form-group">
						  <label for="email">Lietotāja vārds:</label>
						  <input type="text" class="form-control" id="user_name" name="user_name">
						</div>
                        <div class="form-group">
						  <label for="email">E-pasta adrese:</label>
						  <input type="email" class="form-control" id="email" name="email" autocomplete="email">
						</div>
						<div class="form-group">
						  <label for="pwd">Parole:</label>
						  <input type="password" class="form-control" id="password" name="password" autocomplete="password">
						</div>
						<button type="button" class="btn btn-primary registrate" name="registrate">Reģistrēties</button>
					</form>
			</div>
		</div>
	</div>
</body>
</html>