<?php
require_once dirname(dirname(__FILE__)).'/Config/AjaxLanderConfig.php';

require_once TOOL_MODULE.'/Param/ParamManager.class.php';
require_once LOADER_MODULE.'/Page/PageLoader.class.php';

$loader = new PageLoader();
if(session_start()){
    $loader->AjaxLoadPage(ParamManager::getGet('module_name'),ParamManager::getGet('page_name'));
} else {
    echo "用户Session出现错误!";
}
