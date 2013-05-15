<?php
require_once dirname(dirname(__FILE__)).'/Config/Config.php';
class TokenSso{
    public static function genToken($elem){
        if(empty($elem)){
            return 1;
        } else {
            $str = '';
            foreach($elem as $value){
                $str .= $value;
            }
            $result = md5($str);
            if(setcookie('sso_fxycarl_org_uid_token',$result,time()+3600)){
                return $result;
            } else {
                return NULL;
            }
        }
    }

    public static function getToken(){
        if(!empty($_COOKIE['sso_fxycarl_org_uid_token'])){
            return $_COOKIE['sso_fxycarl_org_uid_token'];
        } else {
            return NULL;
        }
    }

    public static function clearToken(){
        if(setcookie('sso_fxycarl_org_uid_token','',time())){
            return 0;
        } else {
            return 1;
        }
    }
}
