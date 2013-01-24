<?php
/**
* FileName: Page.class.php
* Author:   Carl Yu<fxycarl@gmail.com>
* Description: 渲染PHP页面模板的控制器基类文件。
* Date:     Dec 10,2012
*/
require_once __FILE__.'../Config/PageConfig.inc.php'

class Page
 {
    //整合后模板页储存位置。
    private renderedPage;
    //输出PHP页面私有方法。
    public function renderPage($templateIdentifier,$params = array()){
        if (!defined("TEMPLATE_DIR")){
            echo "Undefined 'TEMPLATE_DIR'";
            exit;
        } else {
            if (isset($params)){
                extract($params);
            }

            $this->renderedPage = file_get_contents(TEMPLATE_DIR.$templateIdentifier);
            
            echo $this->renderedPage;
            exit;
        }
    } 
    //加载PHP页面脚本私有方法。
    public function loadScript($scriptIdentifier,$params = array()){
        if (!defined("SCRIPTS_DIR")){
            echo "Undefined 'SCRIPTS_DIR'";
            exit;
        } else {
            if (isset($params)){
                extract($params);
            }
            
            $renderFile = file_get_contents(SCRIPTS_DIR.$scriptIdentifier);
            $excute = '$renderResult = '.$renderFile.';';

            @eval($excute);

            return $renderResult;
        }
    }
    //加载插件控制格式化输出文本私有方法。
    //本方法区别于loadScript方法用return做返回值的原因是，本方法一般不在页面模板里调用。
    //本方法用于生成特定代码并传递给模板等加载。
    public function formatHelper($pluginIdentifier,$params = array()){
        if (!defined("PLUGINS_DIR")){
            echo "Undefined 'PLUGINS_DIR'";
            exit;
        } else {
            if (isset($params)){
                extract($params);
            }
            
            $renderFile = file_get_contents(PLUGINS_DIR.$pluginIdentifier);
            $excute = '$renderResult = '.$renderFile.';';

            @eval($excute);
            
            return $renderResult;
         }
    }
    //继承控制器基类的控制器类需要覆盖的默认调用方法。
    public function initPage(){
       //$this->renderPage();
       //exit;
    }
    //继承控制器基类的控制器类需要覆盖的AJAX调用方法。
    public function ajaxPage(){
        //$this->renderPage();
        //exit;
    }
 } 

