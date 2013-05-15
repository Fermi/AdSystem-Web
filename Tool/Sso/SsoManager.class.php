<?php
require_once dirname(dirname(__FILE__)).'/Config/Config.php';
require_once DATA_DIR.'/Database/DatabaseManager.class.php';
require_once DATA_DIR.'/Metadata/SqlQueryManager.class.php';
require_once TOOL_DIR.'/Session/SessionManager.class.php';
require_once TOOL_DIR.'/Token/TokenManager.class.php';
class SsoManager{
    public static function Login($username,$password,$expire = 3600){
        if((empty($username))||(empty($password))){
            return 1;
        } else {
            $password_encrypted = md5($password);

            $db_conn = DatabaseManager::connectDB('sso_fxycarl');
            if($db_conn){
                $sql_query = new SqlQueryManager('select''sso_users',array('id','name'),array(),array('name'=>array('value'=>$username,'condition'=>'eq'),'password'=>array('value'=>$password_encrypted,'condition'=>'eq'),'status'=>array('value'=>'1','condition'=>'eq')),array(),array(),NULL,NULL);
                $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                if(($result_sql !== false)&&(!empty($result_sql))){
                    $token = TokenManager::genToken(array('user_id'=>$result_sql[0]['id'],'user_name'=>$result_sql[0]['name'],'user_expire'=>time()+$expire,'create_time'=>$time),'Sso');
                    if(!empty($token)){
                        if(!SessionManager::setSession(array('user_id'=>$result_sql[0]['id'],'user_name'=>$result_sql[0]['name'],'user_expire'=>time()+$expire),'Sso')){
                            $sql_query = new SqlQueryManager('insert','sso_session',array('user_id','token','name','user_expire','status','create_time','modify_time'),array($result_sql[0]['id'],$token,$result_sql[0]['name'],time()+$expire,'1',time(),time()),array(),array(),array(),NULL,NULL);
                            $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                            if($result_sql === true){
                                DatabaseManager::leaveDB($db_conn);
                                return 0;
                            } else {
                                DatabaseManager::leaveDB($db_conn);
                                return 1;
                            }
                        }
                    } else {
                        DatabaseManager::leaveDB($db_conn);
                        return 1;
                    }
                } else {
                    DatabaseManager::leaveDB($db_conn);
                    return 1;
                }
            }
        }
    }


    public static function Logout(){
        $user_id = $_SESSION['user_id'];
        if(TokenManager::clearToken('Sso')&&SessionManager::clearSession('Sso')){
            if(empty($user_id)){
                return 0;
            } else {
                $db_conn = DatabaseManager::connectDB('sso_fxycarl');
                if($db_conn){
                    $sql_query = new SqlQueryManager('select','sso_session',array('id'),array(),array('user_id'=>array('value'=>$user_id,'condition'=>'eq'),'status'=>array('value'=>'1','condition'=>'eq')));
                    $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                    if(($result_sql !== false)&&(!empty($result_sql))){
                        $sql_query = new SqlQueryManager('update','sso_session',array('status'),array('0'),array('id'=>array('value'=>$result_sql[0]['id'],'condition'=>'eq')),array(),array(),NULL,NULL);
                        $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                        if($result_sql === true){
                            DatabaseManager::leaveDB($db_conn);
                            return 0;
                        } else {
                            DatabaseManager::leaveDB($db_conn);
                            return 1;
                        }
                    }
                }
            }
        }
    }

    public static function isLogin(){
        $token = TokenManager::getToken('Sso');
        $user_id = $_SESSION['user_id'];
        if(empty($token)||empty($user_id)){
            header('Location: http://sso.fxycarl.org/Login');
        } else {
            $db_conn = DatabaseManager::connectDB('sso_fxycarl');
            if($db_conn){
                $sql_query = new SqlQueryManager('select','sso_session',array('id','user_expire'),array(),array('user_id'=>array('value'=>$user_id,'condition'=>'eq'),'token'=>array('value'=>$token,'condition'=>'eq'),'status'=>array('value'=>'1','condition'=>'eq')),array(),array(),NULL,NULL);
                $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                if(($result_sql !== false)&&(!empty($result_sql))){
                    $user_expire = $result_sql[0]['user_expire'];
                    if($user_expire > time()+3600){
                    } else {
                        $user_expire = time()+3600;
                    }
                    $sql_query = new SqlQueryManager('update','sso_session',array('user_expire'),array($user_expire),array('id'=>array('value'=>$result_sql[0]['id'],'condition'=>'eq')),array(),array(),NULL,NULL);
                    $result_sql = DatabaseManager::executeDBQuery($db_conn,$sql_query,'utf8');
                    if($result_sql === true){
                        DatabaseManager::leaveDB($db_conn);
                        return 0;
                    else {
                        DatabaseManager::leaveDB($db_conn);
                        header('Location: http://sso.fxycarl.org/Login');
                    }
                } else {
                    DatabaseManager::leaveDB($db_conn);
                    header('Location: http://sso.fxycarl.org/Login');
                }
            }
        }
    }
}
