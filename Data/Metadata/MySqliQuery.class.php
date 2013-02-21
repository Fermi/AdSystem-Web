<?php

class MysqliQuery{
    public static function formatInsertSqlQuery($table,$keyarray,$valuearray){
        
        if(empty($table)){
            echo "未指定数据表名";
            return null;
        }
        if(empty($keyarray)||empty($valuearray)){
            return null;
        }
        
        $key_string = implode(',',$keyarray);
        $value_string = implode(',',$valuearray);

        $sql = 'INSERT INTO {$table} ( {$key_string} ) VALUES ( {$value_string} )';
        
        return $sql;
    } 
    public static function formatSelectSqlQuery($table,$keyarray,$wherearray,$orderarray,$grouparray,$limit){
        if(empty($table)){
            echo "未指定数据表名";
            return null;
        }

        $sql = 'SELECT ';

        if(!empty($keyarray)){
            $key_array_count = count($keyarray);
            $key_count = 0;
            foreach($keyarray as $ky){
                $sql .= '`'.$ky.'`';
                if($key_count < $key_array_count){
                    $sql .= ',';
                    $count ++;
                }
            }
        } else {
            $sql .= ' * ';
        }
        $sql .= ' FROM {$table} ';
        $sql .= $this->_formatWhereSql($wherearray);
        $sql .= $this->_formatOrderBySql($orderarray);
        $sql .= $this->_formatGroupBySql($grouparray);
        if(isset($limit)){
            if(is_array($limit)){
                $sql .= 'LIMIT'.$limit['down'].','$limit['up'];
            } else {
                $sql .= ' LIMIT '.$limit;
            }
        }

        return $sql;
    }
    public static function formatUpdateSqlQuery($table,$keyarray,$valuearray,$wherearray,$limit){
        if(empty($table)){
            echo "未指定数据表名";
            return null;
        }
        if(empty($keyarray)||empty($valuearray)){
            return null;
        }

        $array_count = count($keyarray);

        for($count = 0;$count < $array_count,$count ++){
            $str_tmp .= '`'.$keyarray[$count].'`='.$valuearray[$count].',';
        }

        $sql = 'UPDATE {$table} SET '.$str_tmp;
        $sql .= $this->_formatWhereSql($wherearray);
        if(isset($limit)){
            if(is_array($limit)){
                $sql .= 'LIMIT '.$limit['down'].','.$limit['up'];
            } else {
                $sql .= ' LIMIT '.$limit;
            }
        }

        return $sql;
    }
    public static function formatDeleteSqlQuery($table,$wherearray,$limit){
        if(empty($table)){
            echo "未指定数据表名";
            return null;
        }
        
        $sql = 'DELETE FROM {$table}';
        $sql .= $this->_formatWhereSql($wherearray);
        if(isset($limit)){
            if(is_array($limit)){
                $sql .= ' LIMIT '.$limit['down'].','.$limit['up'];
            } else {
                $sql .= ' LIMIT '.$limit;
            }
        }
        return $sql;
    }

    private function _formatWhereSql($wherearray){
        $where_str = ' WHERE ';
        if(isset($wherearray)){
            $array_count = count($wherearray);
            $count = 0;
            foreach($wherearray as $wr){
                switch(strtoupper($wr['condition'])){
                    case 'LT':
                        $where_str .= '`'.$wr['key'].'`<'.$wr['value'];
                        break;
                    case 'LT':
                        $where_str .= '`'.$wr['key'].'`<='.$wr['value'];
                        break;
                    case 'GT':
                        $where_str .= '`'.$wr['key'].'`>'.$wr['value'];
                        break;
                    case 'GE':
                        $where_str .= '`'.$wr['key'].'`>='.$wr['value'];
                        break;
                    case 'NE':
                        $where_str .= '`'.$wr['key'].'`<>'.$wr['value'];
                        break;
                    case 'EQ':
                        $where_str .= '`'.$wr['key'].'`='.$wr['value'];
                        break;
                    case 'IN':
                        foreach($wr['value'] as $ve){
                            $str_tmp .= $ve.',';
                        }
                        $where_str .= 'IN ('.substr($str_tmp,0,-1).')';
                        break;
                    default:
                        break;
                }
                if($count < $array_count){
                    $where_str .= ' AND ';
                    $count ++;
                }
            } 
        } else{
            
        }

        return $where_str;
    }
    
    private function _formatOrderBySql($orderarray){
        $order_str = ' ORDER BY ';
        if(isset($orderarray)){
            $array_count = count($orderarray);
            $count = 0;
            foreach($orderarray as $or){
                $order_str .= ' `'.$or['key'].'` ';
                if(isset($or['order'])){
                    if(strtoupper($or['order']) === 'DESC'){
                        $order_str .= 'DESC';
                    } else if (strtoupper($or['order']) === 'ASC'){
                        $order_str .= 'ASC';
                    }
                }
                if($count < $array_count){
                    $order_str .=', ';
                    $count ++;
                }
            }
        } else {
            
        }
        
        return $order_str;
    }

    private function _formatGroupBySql($grouparray){
        $group_str = ' GROUP BY ';
        if(isset($grouparray)){
            $array_count = count($grouparray);
            $count = 0;
            foreach($grouparray as $gp) {
                $group_str .= '`'.$gp['key'].'`';
                if($count < $array_count){
                    $group_str .= ', ';
                    $count ++;
                }
            }
        } else {
            
        }

        return $group_str;
    }
}


