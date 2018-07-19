<?php
    class template{
        public function get_head($page_title){
                echo '<meta charset="UTF-8">
                <title>'.$page_title.'</title>
                <meta  name="viewpor" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
                <link href="./css/reset.css" rel="stylesheet">
                <link href = "./libs/bootstrap/css/bootstrap.css" rel ="stylesheet">
                <script src="./libs/jQuery/jquery2.1.4.min.js"></script>
                <script src="./libs/bootstrap/js/bootstrap.js"></script>
                <script src="./libs/angularJS/angular.min.js"></script>
                <script src="./js/choose_image.js"></script>
                <script src="./js/ajax_calls.js"></script>
                <script src="plugins/js/effects.js"></script>
                <script src="plugins/js/cal_object.js"></script>
                <link href="./css/style.css" rel="stylesheet">
                <link href="https://fonts.googleapis.com/css?family=Montserrat|Roboto" rel="stylesheet">';
        }
        public function show_notification($message){
            echo "<div class='error'>
                    <p>" .$message. "</p>
                </div>";
        }
        public function get_right_sidebar($user_name, $email, $password, $image, $reg_date, $role){
            echo '<div class="right_sidebar">
                    <h3 class="text-center">Lietotāja profils</h3>
                    <div class="image_container">
                        <img id="profile_image" class="center-block" src="'.$image.'">
                        <label id="edit" for="file_upload">
                            Izvēlēties bildi <span class="glyphicon glyphicon-edit"></span></button>
                        </label>
                    </div>
                    <form id="image_upload_form" action="image_upload.php" method="POST" enctype="multipart/form-data">
                        <input id="file_upload" name="selected_image" type="file" accept=".jpg, .jpeg, .png" />
                        <button type="submit" class="btn btn_danger" id="change_image" name="change_image">Mainīt Bildi</button>
                    </form>
                    <p class="text-center">Vārds: '.$user_name.'</p>
                    <p class="text-center">E-pasts: '.$email.'</p>
                    <p class="text-center">Tiesības: '.$role.'</p>
                    <p class="text-center">Parole: '.str_repeat ('*',strlen ($password)).'</p>
                    <p class="text-center">Reģistrējies: '.$reg_date.'</p>
                    <form action="/" id="log_out_form" method="POST" enctype="multipart/form-data">
                        <button class="btn btn-danger" type="submit" formmethod="post" name="logout">Iziet <span class="glyphicon glyphicon-log-out"></span></button>
                    </form>
                </div>';
        }
        public function show_all_users($user_name, $user_image, $user_role){//Vēl viens parametrs ar user_role, lai parbaudītu, vai izvadīt edit pogu vai nē
           $edit_button = ($user_role == "Guest" ? '':'<button type="submit" id="edit" class="btn btn-danger btn-sm">Labot</button>');
            echo '<div class="user">
                    <div class="user_image">
                        <img src="'.$user_image.'"/>
                    </div>
                    <div class="user_details">
                        <p class="user_name">'.$user_name.'</p>
                    </div>
                    <div class="controls">
                        <form id="control_form">
                            <button type="submit" id="visit" class="btn btn-primary btn-sm">Apskatīt</button>'
                            .$edit_button.
                       ' </form>
                    </div>
                </div>';
        }
        static function get_left_sidebar(){
            echo '<div class="left-sidebar">
                    <div class="calendar_container" ng-app="event_app" ng-controller="main_controller">
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
                                <td ng-repeat="z in y.days track by $index" ng-class="{no_date : z == \'\'}" ng-click="get_event(z)">
                                    <span class="day">{{z}}</span>
                                    <span class="event">&#9830;</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>';
        }
    }
?>