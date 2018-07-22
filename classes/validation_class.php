<?php
    require_once("template_class.php");
    class validation {
        public function is_valid_name($input){
            $template = new template();
            $valid_input = htmlspecialchars($input);
            if(!preg_match('/^[0-9a-zēūīāšģķļņ\s]*$/i', $valid_input)){
                $template->show_notification("Lūgums ievadīt tikai Burtus!");
                die();
            }
            else{
                return $input;
            }
        }
        public function is_long_enough($input){
            $template = new template();//      tā jādeklarē klase iekš klases???????
            if(strlen($input) == 0){
                $template->show_notification("Visiem laukiem jābūt aizpildītiem!");
                die();//So wont check even next values
            }
            else if(strlen($input) < 5){
                $template->show_notification("Laukam jāsatur vismaz 6 simboli!");
                die();
            }

            //Kaut ko atgriezt???
        }
        public function is_email($email){
            $template = new template();
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $template->show_notification("E-Pasta adrese nav derīga!");
                die();
            }
            else{
                return $email;
            }
        }
    }
?>