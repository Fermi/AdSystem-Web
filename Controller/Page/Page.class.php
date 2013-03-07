<?php
/**
* FileName: Page.class.php
* Author:   Carl Yu<fxycarl@gmail.com>
* Description: 渲染PHP页面模板的控制器基类文件。
* Date:     Dec 10,2012
*/
require_once dirname(dirname(__FILE__)).'/Config/PageConfig.php';

class Page {
    //整合后模板页储存位置。
    private $_renderedPage;
    //输出PHP页面私有方法。
    public function renderPage($templateIdentifier,$params){
        if ((!defined("TEMPLATES_DIR"))&&(!defined("BASE_TEMPLATES_DIR"))){
            echo "Undefined 'TEMPLATES_DIR'";
            exit;
        } else {
            if(defined("TEMPLATES_DIR")){
                $renderDir = TEMPLATES_DIR.$templateIdentifier;
            }else if (defined("BASE_TEMPLATES_DIR")){
                $renderDir = BASE_TEMPLATES_DIR.$templateIdentifier;
            }

            $this->_renderedPage = file_get_contents($renderDir); 

            echo php_template_parser_pause($this,$this->_renderedPage,$params);
            exit;
        }
    } 
    //加载PHP页面脚本私有方法。
    //本方法一般用于加载页面非组件的JS.
    public function loadScript($scriptIdentifier,$params){
        if ((!defined("SCRIPTS_DIR"))&&(!defined("BASE_SCRIPTS_DIR"))){
            echo "Undefined 'SCRIPTS_DIR'";
            exit;
        } else {
            if(defined("SCRIPTS_DIR")){
                $renderDir = SCRIPTS_DIR.$scriptIdentifier;
            }else if (defined("BASE_SCRIPTS_DIR")){
                $renderDir = BASE_SCRIPTS_DIR.$scriptIdentifier;
            }
            
            $renderFile = file_get_contents($renderDir);

            $renderResult = php_template_parser_pause($this,$renderFile,$params);

            return $renderResult;
        }
    }
    //加载PHP页面组件脚本私有方法.
    //组件分三个部分,CSS在页面头引入,DIV在相应位置加入,JS脚本通过本方法加入.
    public function loadWidget($widgetIdentifier,$params,$divId){
        if((!defined("WIDGETS_DIR"))&&(!defined("BASE_WIDGETS_DIR"))){
            echo "Undefined 'WIDGETS_DIR'";
            exit;
        } else {
            if(defined("WIDGETS_DIR")){
                $renderDir = WIDGETS_DIR.$widgetIdentifier;
            }else if (defined("BASE_WIDGETS_DIR")){
                $renderDir = BASE_WIDGETS_DIR.$widgetIdentifier;
            }
            $renderFile = file_get_contents($renderDir);
            $renderResult = php_template_parser_pause($this.$renderFile,$params);

            if(isset($divId)){
                return '$("#'.$divId.'").html('.$renderResult.')';
            } else {
                return $renderResult;
            }
        }
    }
    //加载插件私有方法。
    //本方法一般用于生成特定代码并传递给模板等加载。也可用来格式化某些特殊输出样式.
    public function loadPlugin($pluginIdentifier,$params){
        if ((!defined("PLUGINS_DIR"))&&(!defined("BASE_PLUGINS_DIR"))){
            echo "Undefined 'PLUGINS_DIR'";
            exit;
        } else {
            if(defined("PLUGINS_DIR")){
                $renderDir = PLUGINS_DIR.$pluginIdentifier;
            }else if(defined("BASE_PLUGINS_DIR")){
                $renderDir = BASE_PLUGINS_DIR.$pluginIdentifier;
            }
            $renderFile = file_get_contents($renderDir);
            
            $renderResult = php_template_parser_pause($this,$renderFile,$params);

            return $renderResult;
         }
    }
    //继承控制器基类的控制器类需要覆盖的默认调用方法。
    //public function initPage(){
       //$this->renderPage();
       //exit;
    //}
    //继承控制器基类的控制器类需要覆盖的AJAX调用方法。
    //public function ajaxPage(){
        //$this->renderPage();
        //exit;
    //}
 } 

