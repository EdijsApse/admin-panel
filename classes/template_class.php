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
                <script src="./js/choose_image.js"></script>
                <script src="./js/ajax_calls.js"></script>
                <link href="./css/style.css" rel="stylesheet">
                <link href="https://fonts.googleapis.com/css?family=Montserrat|Roboto" rel="stylesheet">';
        }
        public function show_notification($message){
            echo "<div class='error'>
                    <p>" .$message. "</p>
                </div>";
        }
        public function get_right_sidebar($user_name, $email, $password, $image, $reg_date, $role){
            echo '<div class="right-sidebar">
                    <h3 class="text-center">Lietoāja profils</h3>
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
                    <p class="text-center">E-Pasts: '.$email.'</p>
                    <p class="text-center">Tiesības: '.$role.'</p>
                    <p class="text-center">Parole: '.str_repeat ('*',strlen ($password)).'</p>
                    <p class="text-center">Reģistrējies: '.$reg_date.'</p>
                    <form id="log_out_form" method="POST" enctype="multipart/form-data">
                        <button class="btn btn-danger" type="submit" formmethod="post" name="logout">Iziet <span class="glyphicon glyphicon-log-out"></span></button>
                    </form>
                </div>';
        }
    }
?>