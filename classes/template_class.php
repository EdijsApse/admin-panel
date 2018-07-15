<?php
    class template{
        public function get_head($page_title){
                echo '<meta charset="UTF-8">
                <title>'.$page_title.'</title>
                <meta  name="viewpor" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
                <link href="./css/reset.css" rel="stylesheet">
                <link href = "./libs/bootstrap/css/bootstrap.css" rel ="stylesheet">
                <script src="./libs/jQuery/jquery2.1.4.min.js"></script>
                <script src="./libs/bootstrap/js/bootstrap.js"> </script>
                <script src="./js/my.js"> </script>
                <link href="./css/style.css" rel="stylesheet">';
        }
        public function show_notification($message){
            echo "<div class='error'>
                <p>" .$message. "</p>
                </div>";
        }
    }
?>