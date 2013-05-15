<?php
require_once dirname(dirname(__FILE__)).'/Config/Config.php';
class SessionManager{
    public static function setSession($elem,$type){
        $result = '';
        switch($type){
            case 'Sso':
                include_once dirname(__FILE__).'/SessionSso.class.php';
                $result = SessionSso::setSession($elem);
                break;
            default:
                break;
        }
        return $result;
    }

    public static function clearSession($type){
        $result = '';
        switch($type){
            case 'Sso':
                include_once dirname(__FILE__).'/SessionSso.class.php';
                $result = SessionSso::clearSession();
                break;
            default:
                break;
        }
        return $result;
    }
}


