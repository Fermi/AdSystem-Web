<?php
require_once dirname(dirname(__FILE__)).'/Config/Sso.php';
require_once DATA_MODULE.'/Database/DatabaseManager.class.php';
require_once DATA_MODULE.'/Metadata/SqlQueryManager.class.php';
require_once TOOL_MODULE.'/Session/SessionManager.class.php';
require_once TOOL_MODULE.'/Token/TokenManager.class.php';
class SsoManager{
    public static function Login($username,$password,$expire = 3600){
        $token = TokenManager::getToken('Sso');
        if(empty($token)){
            if(empty($username)||empty($password)){
                return 1;
            } else {
                $password_encrypted = md5($password);
                if(!empty($password_encrypted)){
                    $db_conn = DatabaseManager::connectDB('sso_fxycarl');
                    if($db_conn){
                        $sql_query = new SqlQueryManager('select','sso_users',array('id'),array(),array('name'=>array('value'=>$username,'condition'=>'eq'),'password'=>array('value'=>$password_encrypted,'condition'=>'eq'),'status'=>array('value'=>'1','condition'=>'eq')),array(),array(),NULL,NULL);
                        $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                        if($result_sql !== false){
                            if(empty($result_sql)){
                                DatabaseManager::leaveDB($db_conn);
                                return 3;
                            } else {
                                $token = TokenManager::genToken(array($result_sql[0]['id'],$username,$password_encrypted,time()),'Sso');
                                $sql_query = new SqlQueryManager('insert','sso_session',array('user_id','name','user_expire','token','status','create_time','modify_time'),array($result_sql[0]['id'],$username,time()+SSO_TIME_MATCH+3600,$token,'1',time(),time()),array(),array(),array(),NULL,NULL);
                                $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                                if($result_sql === true){
                                    DatabaseManager::leaveDB($db_conn);
                                    return 0;
                                } else {
                                    DatabaseManager::leaveDB($db_conn);
                                    TokenManager::clearToken('Sso');
                                    return 1;
                                }

                            }
                        }
                    }
                }
            }
        } else {
            if(empty($username)||empty($password)){
                return 1;
            } else {
                $password_encrypted = md5($password);
                if(!empty($password_encrypted)){
                    $db_conn = DatabaseManager::connectDB('sso_fxycarl');
                    if($db_conn){
                        $sql_query = new SqlQueryManager('select','sso_session',array('id','name','user_id','user_expire'),array(),array('token'=>array('value'=>$token,'condition'=>'eq'),'status'=>array('value'=>'1','condition'=>'eq')),array(),array(),NULL,NULL);
                        $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                        if($result_sql !== false){
                            if(!empty($result_sql)){
                                $sql_query = new SqlQueryManager('update','sso_session',array('status'),array('0'),array('id'=>array('value'=>$result_sql[0]['id'],'condition'=>'eq')),array(),array(),NULL,NULL);
                                $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                            }
                        }

                        $sql_query = new SqlQueryManager('select','sso_users',array('id'),array(),array('name'=>array('value'=>$username,'condition'=>'eq'),'password'=>array('value'=>$password_encrypted,'condition'=>'eq'),'status'=>array('value'=>'1','condition'=>'eq')),array(),array(),NULL,NULL);
                        $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                        if($result_sql !== false){
                            if(empty($result_sql)){
                                DatabaseManager::leaveDB($db_conn);
                                return 3;
                            } else {
                                $token = TokenManager::genToken(array($result_sql[0]['id'],$username,$password_encrypted,time()),'Sso');
                                $sql_query = new SqlQueryManager('insert','sso_session',array('user_id','name','user_expire','token','status','create_time','modify_time'),array($result_sql[0]['id'],$username,time()+SSO_TIME_MATCH+3600,$token,'1',time(),time()),array(),array(),array(),NULL,NULL);
                                $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                                if($result_sql === true){
                                    DatabaseManager::leaveDB($db_conn);
                                    return 0;
                                } else {
                                    DatabaseManager::leaveDB($db_conn);
                                    TokenManager::clearToken('Sso');
                                    return 1;
                                }

                            }
                        }

                    }
                }
            }
        }
    }

    public static function Logout(){
        $token = TokenManager::getToken('Sso');
        if(empty($token)){
            return 0;
        } else {
            $db_conn = DatabaseManager::connectDB('sso_fxycarl');
            if($db_conn){
                $sql_query = new SqlQueryManager('select','sso_session',array('id'),array(),array('token'=>array('value'=>$token,'condition'=>'eq'),'status'=>array('value'=>'1','condition'=>'eq')),array(),array(),NULL,NULL);
                $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                if($result_sql != false){
                    if(!empty($result_sql)){
                        $sql_query = new SqlQueryManager('update','sso_session',array('status'),array('0'),array('id'=>array('value'=>$result_sql[0]['id'],'condition'=>'eq')),array(),array(),NULL,NULL);
                        $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                    } 
                }
                TokenManager::clearToken('Sso');
                DatabaseManager::leaveDB($db_conn);
                return 0;
            }
        }

    }

    public static function isLogin($force = false){
        //Valid login status is available.
        $token = TokenManager::getToken('Sso');
        if(empty($token)){
            SessionManager::clearSession('Sso');
            if($force){
                header('Location: http://'.SSO_HTTP_PATH.'/Login');
            }
            return 1;
        } else {
            //Take token to get user info.
            $db_conn = DatabaseManager::connectDB('sso_fxycarl');
            if($db_conn){
                $sql_query = new SqlQueryManager('select','sso_session',array('id','user_id','name','user_expire'),array(),array('token'=>array('value'=>$token,'condition'=>'eq'),'status'=>array('value'=>'1','condition'=>'eq')),array(),array(),NULL,NULL);
                $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                if($result_sql !== false){
                    if(empty($result_sql)){
                        SessionManager::clearSession('Sso');
                        TokenManager::clearToken('Sso');
                        if($force){
                            header('Location: http://'.SSO_HTTP_PATH.'/Login');
                        }
                        DatabaseManager::leaveDB($db_conn);
                        return 1;
                    } else {
                        $user_id = $result_sql[0]['user_id'];
                        $user_name = $result_sql[0]['name'];
                        $user_expire = $result_sql[0]['user_expire'];
                        if($result_sql[0]['user_expire'] >time()+SSO_TIME_MATCH){
                            $sql_query = new SqlQueryManager('update','sso_session',array('user_expire'),array(time()+SSO_TIME_MATCH+3600),array('id'=>array('value'=>$result_sql[0]['id'],'condition'=>'eq')),array(),array(),NULL,NULL);
                            $user_expire = time()+SSO_TIME_MATCH+3600;
                            $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                            if($result_sql === true){
                                SessionManager::setSession(array('user_id'=>$user_id,'user_name'=>$user_name,'user_expire'=>$user_expire),'Sso');
                                TokenManager::refreshToken($token,$user_expire,'Sso');
                                DatabaseManager::leaveDB($db_conn);
                                return 0;
                            }
                        } else {
                            $sql_query = new SqlQueryManager('update','sso_session',array('status'),array('0'),array('id'=>array('value'=>$result_sql[0]['id'],'condition'=>'eq')),array(),array(),NULL,NULL);
                            $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                            SessionManager::clearSession('Sso');
                            TokenManager::clearToken('Sso');
                            if($force){
                                header('Location: http://'.SSO_HTTP_PATH.'/Login');
                            }
                            DatabaseManager::leaveDB($db_conn);
                            return 1;
                        }
                    }
                }
            } else {
                SessionManager::clearSession('Sso');
                TokenManager::clearToken('Sso');
                if($force){
                    header('Location: http://'.SSO_HTTP_PATH.'/Login');
                }
                return 1;
            }
            
        }
    }
}
