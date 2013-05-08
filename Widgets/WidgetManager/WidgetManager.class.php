<?php
require_once dirname(dirname(__FILE__)).'/Config/Config.php';
class WidgetManager{
    //所有widget的三个组成部分.
    private $css;
    private $template;
    private $script;
    private $template_path;
    private $css_path;
    private $script_path;

    //构造方法
    public function __construct(){
        $this->template_path = dirname(dirname(__FILE__)).'/Widget/Templates/';
        $this->css_path = dirname(dirname(__FILE__)).'/Widget/Styles';
        $this->script_path = dirname(dirname(__FILE__)).'/Widget/Scripts';
        $this->css = '';
        $this->template = array();
        $this->script = '';
    }
    //添加并处理控件方法
    public function regist($name,$params){
        $css_file_path = $this->css_path.$name.'.css';
        $template_file_path = $this->template_path.$name.'.widget.php';
        $script_file_path = $this->script_path.$name.'.js';
        if(file_exists($css_file_path)){
            $this->css .='<link rel="stylesheet" type="text/css" href="'.HTTP_PATH.$css_file_path.'" />';
        }
        if(file_exists($template_file_path)){
            $this->template[$name] = template_parser($this,$template_file_path,$params);
        }
        if(file_exists($script_file_path)){
            $this->script .= template_parser($this,$script_file_path,$params);
        }

    }
    //输出处理完成的css
    public function getStyles(){
        return $this->css;
    }
    //输出处理完成的template
    public function getTemplate($name){
        return $this->template[$name];
    }
    //输出处理完成的脚本.
    public function getScripts(){
        return $this->script;
    }

}
