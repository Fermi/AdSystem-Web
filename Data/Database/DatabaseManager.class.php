<?php
require_once __FILE__.'../Config/Database.php';

class DatabaseManager { 
    public static function connectDB($dbhost,$dbport,$dbname){ 
        if (defined('DATABASE_MYSQL')){
            include dirname(__FILE__).'DatabaseMysqli.class.php';
            return DatabaseMysqli::connectDB($dbhost,$dbport,$dbname);
        } 
    }
    public static function executeDBQuery($dbconn,$querytype,$param,$encoding){
        if (defined('DATABASE_MYSQL')){
            include dirname(__FILE__).'DatabaseMysqli.class.php';
            return DatabaseMysqli::executeDBQuery($dbconn,$querytype,$param,$encoding);
        }
    }
    public static function leaveDB($dbconn){ 
        if (defined('DATABASE_MYSQL')){
            include dirname(__FILE__).'DatabaseMysqli.class.php';
            return DatabaseMysqli::leaveDB($dbconn);
        }
    }
    public static function getError($dbconn){ 
        if (defined('DATABASE_MYSQL')){
            include dirname(__FILE__).'DatabaseMysqli.class.php';
            return DatabaseMysqli::getError($dbconn);
        }
    }
}
