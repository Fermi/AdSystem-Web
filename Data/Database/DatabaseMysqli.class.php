<?php

class DatabaseMysqli {
    public static function connectDB($dbname,$dbport=DEFAULT_PORT,$dbhost=DEFAULT_HOST){
        if(isset($dbname)){
            return new mysqli($dbhost,DEFAULT_USER,DEFAULT_PASSWD,$dbname,$dbport);
        } else {
            return null;
        }
    }
    public static function executeDBQuery($dbconn,$sql,$encoding){
        if(isset($encoding)){
            //TODO:Encoding legal check.
            mysqli_set_charset($dbconn,$encoding);
        }
        if(isset($sql)){
            $result_set = mysqli_query($dbconn,$sql->getSqlString());
            $result = array();
            if(($result_set)&&(!is_bool($result_set))){
                if(defined('DEFAULT_RESULT_STYLE_ARRAY')){
                    while($result_row = mysqli_fetch_assoc($result_set)){
                        $result[] = $result_row;
                    }
                } else {
                    while($result_row = mysqli_fetch_object($result_set)){
                        $result[] = $result_row;
                    }
                }
                return $result;
            } else {
                return $result_set;
            } 
        } else{
            return false;
        }
    } 
    public static function executeDBQueryArray($dbconn,$sqlarray,$encoding){
        $result = array();
        if(isset($encoding)){
            //TODO:Encoding legal check.
            mysqli_set_charset($dbconn,$encoding);
        }
        if(isset($sqlarray)&&is_array($sqlarray)){
            foreach($sqlarray as $sql){
                $result_set = mysqli_query($dbconn,$sql->getSqlString());
                if($result_set === false){
                    $result[] = null;
                } else {
                    if(defined('DEFAULT_RESULT_STYLE_ARRAY')){
                        $tmp_result = mysqli_fetch_array($result_set);
                    } else {
                        $tmp_result = mysqli_fetch_object($result_set);
                    }
                    $result[] = $tmp_result;
                }
            }
        } else {
            return null;
        }

        return $result;
    }
    public static function leaveDB($dbconn){
        $dbconn->close(); 
    }
    public static function getError($dbconn){
        return $dbconn->error_list;
    }
}
