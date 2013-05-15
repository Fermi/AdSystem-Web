<?php
require_once dirname(dirname(__FILE__)).'/Config/Config.php';
class SessionSso{
    public static function setSession($elem){
        if(empty($elem)){
            return 1;
        } else {
            foreach($elem as $key => $value){
                $_SESSION[$key] = $value;
            }
        }
        return 0;
    }

    public static function clearSession(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_expire']);
        return 0;
    }
}
