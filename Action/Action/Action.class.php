<?php
require_once dirname(dirname(__FILE__)).'/Config/ActionConfig.php';
class Action{
    public function xssFilter($str){
        $str = preg_replace('/javascript:/',' ',$str);
        return htmlspecialchars($str);
    }
}
