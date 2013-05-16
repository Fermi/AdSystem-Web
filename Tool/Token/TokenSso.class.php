<?php
require_once dirname(dirname(__FILE__)).'/Config/Token.php';
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
            if(setcookie('sso_fxycarl_org_uid_token',$result,time()+TOKEN_SSO_TIME_MATCH+3600,'/',TOKEN_SSO_HTTP_PATH)){
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
        if(setcookie('sso_fxycarl_org_uid_token','',time()+TOKEN_SSO_TIME_MATCH,'/',TOKEN_SSO_HTTP_PATH)){
            return 0;
        } else {
            return 1;
        }
    }

    public static function refreshToken($token,$time){
         if(setcookie('sso_fxycarl_org_uid_token',$token,$time,'/',TOKEN_SSO_HTTP_PATH)){
            return 0;
        } else {
            return 1;
        }
    }
}
