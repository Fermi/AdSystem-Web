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
       
        $key_string = '';
        $key_string .= '`';
        $key_string .= implode('`,`',$keyarray);
        $key_string .= '`';
        $value_string = '';
        $value_string .= '"';
        $value_string .= implode('","',$valuearray);
        $value_string .= '"';

        $sql = 'INSERT INTO '.$table.' ( '.$key_string.' ) VALUES ( '.$value_string.' )';
        
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
                if($key_count < $key_array_count-1){
                    $sql .= ',';
                }
                $key_count++;
            }
        } else {
            $sql .= ' * ';
        }
        $sql .= ' FROM '.$table ;
        $sql .= self::_formatWhereSql($wherearray);
        $sql .= self::_formatOrderBySql($orderarray);
        $sql .= self::_formatGroupBySql($grouparray);
        if(isset($limit)){
            if(is_array($limit)){
                $sql .= 'LIMIT'.$limit['down'].','.$limit['up'];
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

        for($count = 0;$count < $array_count;$count ++){
            $str_tmp .= '`'.$keyarray[$count].'`="'.$valuearray[$count].'"';

            if($count < $array_count-1){
                $str_tmp .= ', ';
            }
            $count++;
        }

        $sql = 'UPDATE '.$table.' SET '.$str_tmp;
        $sql .= self::_formatWhereSql($wherearray);
        if(!empty($limit)){
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
        
        $sql = 'DELETE FROM '.$table;
        $sql .= self::_formatWhereSql($wherearray);
        if(!empty($limit)){
            if(is_array($limit)){
                $sql .= ' LIMIT '.$limit['down'].','.$limit['up'];
            } else {
                $sql .= ' LIMIT '.$limit;
            }
        }
        return $sql;
    }

    private static function _formatWhereSql($wherearray){
        if(!empty($wherearray)){
        $where_str = ' WHERE ';
            $array_count = count($wherearray);
            $count = 0;
            foreach($wherearray as $wr){
                switch(strtoupper($wr['condition'])){
                    case 'LT':
                        $where_str .= '`'.$wr['key'].'`<'.$wr['value'];
                        break;
                    case 'LE':
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
                        $str_tmp = '';
                        if(is_array($wr['value'])){
                            foreach($wr['value'] as $ve){
                                $str_tmp .= '"'.$ve.'",';
                            }
                        } else {
                            $str_tmp .='"'.$wr['value'].'",';
                        }
                        $where_str .= '`'.$wr['key'].'` IN ('.substr($str_tmp,0,-1).')';
                        break;
                    default:
                        break;
                }
                if($count < $array_count-1){
                    $where_str .= ' AND ';
                }
                $count++;
            } 
        } else{
            
        }

        return $where_str;
    }
    
    private static function _formatOrderBySql($orderarray){
        if(!empty($orderarray)){
            $order_str = ' ORDER BY ';
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
                if($count < $array_count-1){
                    $order_str .=', ';
                }
                $count++;
            }

            return $order_str;
        } else {
            return ' ';   
        }
    }

    private static function _formatGroupBySql($grouparray){
        if(!empty($grouparray)){
            $group_str = ' GROUP BY ';
            $array_count = count($grouparray);
            $count = 0;
            foreach($grouparray as $gp) {
                $group_str .= '`'.$gp['key'].'`';
                if($count < $array_count-1){
                    $group_str .= ', ';
                }
            }

            return $group_str;
        } else {
            return ' ';
        }

    }
}


