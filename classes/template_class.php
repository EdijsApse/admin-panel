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
        static function get_menu(){
            echo '<nav class="navbar navbar-inverse">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-menu">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span> 
                            </button>
                        </div>
                        <div class="collapse navbar-collapse" id="main-menu">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="home">Sākums</a></li>
                                <li><a href="">Items</a></li>
                                <li><a href="">Items</a></li> 
                                <li><a href="">Items</a></li>
                                <li ><a href="">Items</a></li> 
                            </ul>
                        </div>
                    </div>
                </nav>';
        }
        public function show_notification($message){
            echo "<div class='error'>
                    <p>" .$message. "</p>
                </div>";
        }
        public function get_right_sidebar($user_id, $user_name, $email, $password, $image, $reg_date, $role){
            echo '<div class="right_sidebar">
                    <h3 class="text-center">Lietotāja profils</h3>
                    <div class="image_container">
                        <img id="profile_image" class="center-block" src="'.$image.'">
                        <label id="edit" for="file_upload">
                            Izvēlēties bildi <span class="glyphicon glyphicon-edit"></span></button>
                        </label>
                    </div>
                    <form id="image_upload_form" action="image_upload" method="POST" enctype="multipart/form-data">
                        <input id="file_upload" name="selected_image" type="file" accept=".jpg, .jpeg, .png" />
                        <button type="submit" class="btn btn_danger" id="change_image" name="change_image">Mainīt Bildi</button>
                    </form>
                    <form id="edit_profile_form" action="edit_user" method="POST">
                        <input id="user_id" name="user_id" value="'.$user_id.'">
                        <button class="btn btn-danger edit_profile" name="edit">Labot Profilu</button>
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
        public function show_all_users($user_id, $user_name, $user_image, $active_user_role, $user_role, $user_regdate){//Vēl viens parametrs ar user_role, lai parbaudītu, vai izvadīt edit pogu vai nē
           $edit_button = ($active_user_role == "Guest" ? '':'<button type="submit" id="edit" name="edit" class="btn btn-danger btn-sm">Labot</button>');
            echo '<div class="user">
                    <div class="user_image">
                        <img src="'.$user_image.'"/>
                    </div>
                    <div class="user_details">
                        <p>Lietotājs: '.$user_name.'</p>
                        <p>Tiesības: '.$user_role.'</p>
                        <p>Reģistrējies: '.$user_regdate.'</p>
                    </div>
                    <div class="controls">
                        <form id="control_form" method="POST" action="edit_user">
                            <input id="user_id" name="user_id" value="'.$user_id.'">
                            <button type="submit" id="visit" name="visit" class="btn btn-primary btn-sm">Apskatīt</button>
                            '.$edit_button.'
                        </form>
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
        public function edit_profile($user_name, $user_email){
            echo '<div class="edit_profile_container">
                    <h1 class="text-center">'.$user_name.'</h1>
                    <form class="edit_profile">
                        <div class="form-group">
                            <label for="name">Vārds:</label>
                            <input type="text" class="form-control" value="'.$user_name.'" id="name" autocomplete="name">
                        </div>
                        <div class="form-group">
                            <label for="email">E-pasta adrese:</label>
                            <input type="email" class="form-control" value="'.$user_email.'" id="email" autocomplete="email">
                        </div>
                        <div class="form-group">
                            <label for="select_role">Tiesības:</label>
                            <select class="form-control" id="select_role" name="select_role">
                                <option>-----Tiesības-----
                                <option value="admin">Admin</option>
                                <option value="moderator">Moderator</option>
                                <option value="guest">Guest</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Jaunā parole:</label>
                            <input type="password" class="form-control" name="new_password" id="new_password" autocomplete="new_password">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Jaunā parole vēlreiz:</label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" autocomplete="confirm_password">
                        </div>
                        <button class="btn btn-default default_button" name="confirm_changes">Saglabāt</button>
                    </form>
                </div>';
        }
    }
?>