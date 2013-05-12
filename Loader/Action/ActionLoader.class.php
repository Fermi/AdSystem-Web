<?php
/**
* FileName: ActionLoader.class.php
* Author:   Carl Yu<fxycarl@gmail.com>
* Description: Action的加载基类文件。
* Date:     May 9,2013
*/
require_once dirname(dirname(__FILE__)).'/Config/ActionLoaderConfig.php';
class ActionLoader{
    //指定默认方法名。
    private $_ajaxMethodName = 'ajaxAction';
    //AJAX加载方法。
    public function AjaxLoadAction($module_name,$action_name){
        if(empty($module_name)||empty($action_name)){
            echo "参数不可用";
            exit;
        }else{
            if(defined("ACTION_MODULE")) {
                require ACTION_MODULE.'/'.$module_name.'Action/'.$action_name.'Action.class.php';
                if(method_exists($action_name.'Action',$this->_ajaxMethodName)) {
                    $action_class_name = $action_name.'Action';
                    $action_obj = new $action_class_name;
                    call_user_func(array($action_obj,$this->_ajaxMethodName));
                    exit;
                } else {
                    echo "加载页面的方法不存在";
                    exit;
                }
            
            } else {
                echo "找不到相应Action";
                exit;
            }
        }
    }
}
