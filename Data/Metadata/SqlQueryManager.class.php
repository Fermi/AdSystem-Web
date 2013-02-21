<?php
require_once dirname(dirname(__FILE__)).'/Config/Metadata.php'

class SqlQueryManager{
    private $sqlquery;

    public function __construct($sqltype,$table,$keyarray,$valuearray,$wherearray,$orderarray,$grouparray,$order,$limit){
        switch(strtoupper($sqltype)){
            case 'INSERT':
                $this->$sqlquery = $this->_formatInsertSqlQuery($table,$keyarray,$valuearray);
                break;
            case 'SELECT':
                $this->$sqlquery = $this->_formatSelectSqlQuery($table,$keyarray,$wherearray,$orderarray,$grouparray,$order,$limit);
                break;
            case 'UPDATE':
                $this->$sqlquery = $this->_formatUpdateSqlQuery($table,$keyarray,$valuearray);
                break;
            case 'DELETE':
                $this->$sqlquery = $this->_formatDeleteSqlQuery($table,$keyarray);
                break;
            default:
                break;
        } 
    }

    public function getSqlString(){
        return $this->$sqlquery;
    }

    private function _formatInsertSqlQuery($table,$keyarray,$valuearray){
        if(defined('DATABASE_MYSQL_DEFAULT')){
            include dirname(__FILE__).'/MysqliQuery.class.php';
            return MysqliQuery::formatInsertSqlQuery($table,$keyarray,$valuearray);
        } 
    }

    private function _formatSelectSqlQuery($table,$keyarray,$wherearray,$orderarray,$grouparray,$limit){
    
        if(defined('DATABASE_MYSQL_DEFAULT')){
            include dirname(__FILE__).'/MysqliQuery.class.php';
            return MysqliQuery::formatSelectSqlQuery($table,$keyarray,$wherearray,$orderarray,$grouparray,$limit);
        }
    }

    private function _formatUpdateSqlQuery($table,$keyarray,$valuearray,$wherearray,$limit){
        if(defined('DATABASE_MYSQL_DEFAULT')){
            include dirname(__FILE__).'/MysqliQuery.class.php';
            return MysqliQuery::formatUpdateSqlQuery($table,$keyarray,$valuearray,$wherearray,$limit);
        }
    }

    private function _formatDeleteSqlQuery($table,$wherearray,$limit){
        if(defined('DATABASE_MYSQL_DEFAULT')){
            include dirname(__FILE__).'/MysqliQuery.class.php';
            return MysqliQuery::formatDeleteSqlQuery($table,$wherearray,$limit);
        }
    }
}
