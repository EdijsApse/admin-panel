<?php
    require_once("database_class.php");
    class main{
        static function display_errors(){
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }
        static function error_handler($err_number, $err_msg, $file, $line){//Priekš Manis
            echo "<div class='error'>";
            echo "<b>Kļūda:</b></br>";
            echo "Kļūdas Numurs: [$err_number]</br>";
            echo "Kļūdas Paziņojums: $err_msg </br>";
            echo "Failā: $file </br>";
            echo "Rindā: $line </br>";
            echo "Skripta darbība apturēta";
            echo "</div>";
            die();//Will stop script execution
        }
        static function create_connection(){//Will return database connection
            $server_name = "localhost";
			$user_name = "root";
			$password = "";
			$db_name = "registration_db";
			$connection = new mysqli($server_name, $user_name, $password, $db_name);
			$connection->set_charset("utf8");//Set connection charset, so i can get data with Ā, Ē etc
			return $connection;
        }
        public function upload_image($button, $image){
            $database = new database();
            if (isset($image) && isset($button)) {
                $name = $image["name"];
                $tmp_name = $image['tmp_name'];//Pārvietošanas brīdī fails tiek uzglabāts tmp_mapē ar tmp_name
                //Pārbaude vai ir bilde/vai nav pārsniegts izmērs
                //Uztaisīt error lapu
                //Augšupielādēt datus datubāzē
                //Izdzēst esošo bildi, ja tiks atkārtoti mainīta
                //Pārbaude uz faila nosaukuma garumu, vai arī caur php mainīt bildes nosaukumu uz user.jpg vai kaut kā tā
                if (!empty($name)) {
                    $location = 'images/';
                    if(!file_exists($location.$name)){
                        if(move_uploaded_file($tmp_name, $location.$name)){//Tapēc fails ir tmp_name
                            session_start();
                            $database->change_image($_SESSION["email"],$location.$name);
                            header("location:/home");
                        }
                        else{
                            echo "Augšupielādēšanas brīdī radās problēma!</br>Fails <b>Netika</b> augšupielādēts!";
                        }
                    }
                    else{
                        echo $location.$name;
                        echo "Bilde ar šādu nosaukumu jau pastāv!";
                    }
                }
                else {//Redirekts uz smuku error lapu
                    echo 'Izvēlies bildi!';
                }
            }
            else{
                header("location:/home");
            }
        }
    }
?>