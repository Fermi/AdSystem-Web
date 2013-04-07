<?php
require_once dirname(__FILE__)."/FileDownloader.class.php";
require_once TOOL_MODULE."/Param/ParamManager.class.php";

if(ParamManager::getGet("Filter")){
    $filter = ParamManager::getGet("Filter");
}
if(ParamManager::getGet("File")){
    $file = ParamManager::getGet("File");
}

new FileDownloader()->downloadFiles($file,$filter);

