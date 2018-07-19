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
    session_start();
    if(!isset($_SESSION["user"])){
        header("location:/");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
        $template->get_head("Admin Panel");
	?>
</head>
<body>
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="left-sidebar">
                    <div class="calendar_container" ng-app="apmeklejuma_uzskaites_sistema" ng-controller="main_controller">
                        <h1 class="calendar_title">
                            <span id="prev" ng-click="prev_month()">&#9668;</span>
                            {{year}}.Gada {{month}}
                            <span id="next" ng-click="next_month()">&#9658;</span>
                        </h1>
                        <table id="calendar">
                            <tr id="header">
                                <th class="text-center" ng-repeat="x in days_not">{{x}}</th>
                            </tr>
                            <tr class="weeks" ng-repeat="y in date">
                                <td ng-repeat="z in y.days track by $index" ng-class="{no_date : z == ''}" ng-click="get_event(z)">
                                    <span class="day">{{z}}</span>
                                    <span class="event">&#9830;</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="main">
                    <?php
                        if(isset($_SESSION["role"])){
                            $role = $_SESSION["role"];
                        }
                        else{
                            $role = "Guest";
                        }
                        $database->get_all_users($role);
                    ?>
                </div>
            </div>
            <div class="col-md-3">
                <?php
                    $template->get_right_sidebar($_SESSION["user"],$_SESSION["email"],$_SESSION["password"],$_SESSION["image"],$_SESSION["regdate"],$_SESSION["role"]);
                ?>
            </div>
        </div>
	</div>
</body>
<script src="plugins/modules/main.js"></script>
<script src="plugins/controllers/main.js"></script>
</html>
<?php
    if(isset($_POST["logout"])){
        session_destroy();
        header("location:/");
    }
?>