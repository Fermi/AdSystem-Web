<?php
require_once dirname(dirname(__FILE__)).'/Config/AjaxLanderConfig.php';

require_once TOOL_MODULE.'/Param/ParamManager.class.php';
require_once LOADER_MODULE.'/Page/PageLoader.class.php';

$loader = new PageLoader();

$loader->AjaxLoadPage(ParamManager::getGet('module_name'),ParamManager::getGet('page_name'));
