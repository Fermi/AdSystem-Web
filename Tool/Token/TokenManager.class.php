<?php
require_once dirname(dirname(__FILE__)).'/Config/Config.php'
class TokenManager{
    public static function genToken($elem,$type){
        $result = '';
        switch($type){
            case 'Sso':
                include_once dirname(__FILE__).'/TokenSso.class.php';
                $result = TokenSso::genToken($elem);
                break;
            default:
                break;
        }
        return $result;
    }

    public static function getToken($type){
        $result = '';
        switch($type){
            case 'Sso':
                include_once dirname(__FILE__).'/TokenSso.class.php';
                $result = TokenSso::getToken();
                break;
            default:
                break;
        }
        return $result;
    }

    public static function clearToken($type){
        $result = '';
        switch($type){
            case 'Sso':
                include_once dirname(__FILE__).'/TokenSso.class.php';
                $result = TokenSso::clearToken();
                break;
            default:
                break;
        }
        return $result;
    }
}



