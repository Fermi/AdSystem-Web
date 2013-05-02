<?php
require_once dirname(dirname(__FILE__)).'/Config/Database.php';

class DatabaseManager { 
    public static function connectDB($dbname,$dbport=NULL,$dbhost=NULL){ 
        if (defined('DATABASE_MYSQL_DEFAULT')){
            include_once dirname(__FILE__).'/DatabaseMysqli.class.php';
            if(($dbport == NULL)&&($dbhost == NULL)){
                return DatabaseMysqli::connectDB($dbname);
            } else if(($dbport != NULL)&&($dbhost == NULL)){
                return DatabaseMysqli::connectDB($dbname,$dbport);
            } else {
                return DatabaseMysqli::connectDB($dbname,$dbport,$dbhost);
            }
        } 
    }
    public static function executeDBQuery($dbconn,$sql,$encoding=NULL){
        if (defined('DATABASE_MYSQL_DEFAULT')){
            include_once dirname(__FILE__).'/DatabaseMysqli.class.php';
            return DatabaseMysqli::executeDBQuery($dbconn,$sql,$encoding);
        }
    }
    public static function executeDBQueryArray($dbconn,$sqlarray,$encoding){
        if(defined('DATABASE_MYSQL_DEFAULT')){
            include_once dirname(__FILE__).'/DatabaseMysqli.class.php';
            return DatabaseMysqli::executeDBQueryArray($dbconn,$sqlarray,$encoding);
        }
    }
    public static function leaveDB($dbconn){ 
        if (defined('DATABASE_MYSQL_DEFAULT')){
            include_once dirname(__FILE__).'/DatabaseMysqli.class.php';
            return DatabaseMysqli::leaveDB($dbconn);
        }
    }
    public static function getError($dbconn){ 
        if (defined('DATABASE_MYSQL_DEFAULT')){
            include_once dirname(__FILE__).'/DatabaseMysqli.class.php';
            return DatabaseMysqli::getError($dbconn);
        }
    }
}
