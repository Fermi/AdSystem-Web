<?php

class DatabaseMysqli {
    public static function connectDB($dbhost=DEFAULT_HOST,$dbport=DEFAULT_PORT,$dbname){
        return new mysqli($dbhost,DEFAULT_USER,DEFAULT_PASSWD,$dbname,$dbport);   
    }
    public static function executeDBQuery($dbconn,$querytype,$param,$encoding){
        $prepared_stmt = $dbconn->stmt_init();
        $query_sql = '';
        
        if (isset($encoding)&&$encoding !=''){
            $dbconn->set_charset($encoding);
        }

        switch(strtoupper($query_type)){
            case 'SELECT':
            $query_sql = $query_sql.'SELECT ? FROM ? ';
            $param_array = $this->_formatSelectParam($param);
                break;
            case 'INSERT':
            $query_sql = $query_sql.'INSERT INTO ? (?) VALUES (?)';
            $param_array = $this->_formatInsertParam($param);
                break;
            case 'UPDATE':
            $query_sql = $query_sql.'UPDATE ? SET ? WHERE ?';
            $param_array = $this->_formatUpdateParam($param);
                break;
            case 'DELETE':
            $query_sql = $query_sql.'DELETE FROM ? WHERE ?';
            $param_array = $this->_formatDeleteParam($param);
                break;
            default:
                return array();
        }

        $prepared_stmt->prepare($query_sql);
        foreach($param_array as $item){
            $prepared_stmt->bind_param('s',$item);
        }
        $prepared_stmt->execute($query_sql);
        if(isset($prepared_stmt->error_list)){
            $result = $prepared_stmt->error_list;
        } else {
            if (strtoupper($querytype) === 'SELECT'){
                $result['row_nums'] = $prepared_stmt->num_rows;
                $query_result =$prepared_stmt->get_result();

                while($row = $query_result->fetch_row()){
                    $result['result_array'][] = $row;
                }

            } else {
                $result['row_nums'] = $prepared_stmt->affected_rows;
                if (strtoupper($querytype) === 'INSERT'){
                    $result['id'] = $prepared_stmt->insert_id;
                }
            }

        }
        $result->close();
        $prepared_stmt->close();
    }
    public static function leaveDB($dbconn){
        return $dbconn->close();
    }
    public static function getError($dbconn){
        return $dbconn->error_list;
    }

    private static function _formatSelectParam($param){
        
    }
    private static function _formatInsertParam($param){
        
    }
    private static function _formatUpdateParam($param){
        
    }
    private static function _formatDeleteParam($param){
        
    }
}
