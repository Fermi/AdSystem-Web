<?php
require_once dirname(__FILE__)."/FileUploader.class.php";
require_once TOOL_MODULE."/Param/ParamManager.class.php";

if(ParamManager::getGet("Filter")){
    $filter = ParamManager::getGet("Filter");
}

if(ParamManager::getGet("File")){
    $file = ParamManager::getGet("File");
}

new FileUploader->receiveFiles($file,$filter);

