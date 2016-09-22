<?php
/**
* FileName: Page.class.php
* Author:   Carl Yu<fxycarl@gmail.com>
* Description: 渲染PHP页面模板的控制器基类文件。
* Date:     Dec 10,2012
*/
require_once dirname(dirname(__FILE__)).'/Config/PageConfig.php';
require_once BASE_WIDGETS_DIR.'WidgetManager/WidgetManager.class.php';
//require_once BASE_PLUGINS_DIR.'PluginManager/PluginManager.class.php';

class Page {
    //私有变量
    //页面里有的组件.
    private $widgets;
    //private $plugins;

    //构造方法.
    public function __construct(){
        $this->widgets = new WidgetManager();
        //$this->plugins = new PluginManager();
    }
    //输出PHP页面公有方法。
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
 
            echo template_parser_parse($this,$renderDir,$params);
        }
    }  
    //加载PHP页面脚本公有方法。
    //本方法用于加载页面非组件的整合过的JS.
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

            $renderResult = template_parser_parse($this,$renderDir,$params);

            echo $renderResult;
        }
    }
    
    //控制器中注册控件.
    public function registWidget($name,$params,$prefix=NULL){
        return $this->widgets->regist($name,$params,$prefix);
    }
    //页面导出控件css.
    public function exportWidgetCss(){
        echo $this->widgets->getStyles();
    }
    //页面导出控件div.
    public function exportWidgetTemplate($full_name){
        echo $this->widgets->getTemplate($full_name);
    }
    //页面导出控件JS.
    public function exportWidgetScript(){
        echo $this->widgets->getScripts();
    }
    //控制器中注册插件.
    //public function registPlugin($name,$params){
    //    return $this->plugins->regist($name,$params);
    //}
    //页面导出插件结果.
    //public function exportPluginResult($name){
    //    echo $this->plugins->getResult($name);
    //}
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

