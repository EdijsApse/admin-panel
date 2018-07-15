<?php
    require_once("template_class.php");
    class validation {
        public function is_long_enough($input){
            $template = new template();//      tā jādeklarē klase iekš klases???????
            if(strlen($input) == 0){
                $template->show_notification("Visiem laukiem jābūt aizpildītiem!");
                die();//So wont check even next values
            }
            else if(strlen($input) <= 3){
                $template->show_notification("Laukam jāsatur vismaz 3 simboli!");
                die();
            }
        }
        public function is_email($email){
            $template = new template();
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $template->show_notification("E-Pasta adrese nav derīga!");
                die();
            }
            else{
                return true;
            }
        }
    }
?>