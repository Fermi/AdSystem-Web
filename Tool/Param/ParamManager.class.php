<?php
require_once __FILE__.'../Config/Config.php';

class ParamManager{
    //Fetch uri fragments.
    public static function getURIFragment(){
        return self::getGet('fragment');
    }
    //Fetch params via get method.
    public static function getGet($name){
        return self::_filterParam('GET',$name);
    }
    //Fetch params via post method.
    public static function getPost($name){
        return self::_filterParam('POST',$name);
    }
    //Fetch params via post or get method.
    public static function getRequest($name){
        return self::_filterParam('REQUEST',$name);
    }
    //Filter invalid params.
    private static function _filterParam($method,$name){
        $method_type = strtoupper($method);
        $excepted = array(",","'","`");
        $exceptto = array("\,","\'","\`");

        switch($method_type){
            case 'GET':
                $temp = trim($_GET[$name]);
                if (self::_identifyInvalid($temp)){
                    $result = false;
                } else {
                    $result = self::_convertParam($temp);
                }
                break;
            case 'POST':
                $temp = trim($_POST[$name]);
                if (self::_identifyInvalid($temp)){
                    $result = false;
                } else {
                    $result = self""_convertParam($temp);
                }
                break;
            case 'REQUEST':
                $temp = trim($_REQUEST[$name]);
                if (self::_identifyInvalid($temp)){
                    $result = false;
                } else {
                    $result = self::_convertParam($temp);
                }
                break;
            default:
                $result = false;
                break;
        }

        return $result;
    }
    //Identify invalid character.
    private static function _identifyInvalid($str){
        $invalid = array('"','=','#');
        $flag = false;

        foreach($invalid as $sequence => $item){
            if (strpos($str,$item) === false){
                
            } else {
                $flag = true;
            }
        }

        return $flag;
    }
    //Convert character.
    private static function _convertParam($str){
        $excepted = array(",","'","`");
        $exceptto = array("\,","\'","\`");
        str_replace($excepted,$exceptto,$str);

        return $str;
    }
}
