<?php
require_once dirname(dirname(__FILE__)).'/Config/Database.php';

class DatabaseManager { 
    public static function connectDB($dbhost,$dbport,$dbname){ 
        if (defined('DATABASE_MYSQL_DEFAULT')){
            include dirname(__FILE__).'/DatabaseMysqli.class.php';
            return DatabaseMysqli::connectDB($dbhost,$dbport,$dbname);
        } 
    }
    public static function executeDBQuery($dbconn,$sql,$encoding){
        if (defined('DATABASE_MYSQL_DEFAULT')){
            include dirname(__FILE__).'/DatabaseMysqli.class.php';
            return DatabaseMysqli::executeDBQuery($dbconn,$sql,$encoding);
        }
    }
    public static function executeDBQueryArray($dbconn,$sqlarray,$encoding){
        if(defined('DATABASE_MYSQL_DEFAULT')){
            include dirname(__FILE__).'/DatabaseMysqli.class.php';
            return DatabaseMysqli::executeDBQueryArray($dbconn,$sqlarray,$encoding);
        }
    }
    public static function leaveDB($dbconn){ 
        if (defined('DATABASE_MYSQL_DEFAULT')){
            include dirname(__FILE__).'/DatabaseMysqli.class.php';
            return DatabaseMysqli::leaveDB($dbconn);
        }
    }
    public static function getError($dbconn){ 
        if (defined('DATABASE_MYSQL_DEFAULT')){
            include dirname(__FILE__).'/DatabaseMysqli.class.php';
            return DatabaseMysqli::getError($dbconn);
        }
    }
}
