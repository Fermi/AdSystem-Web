<?php
//Include File Config.
//require_once
require_once FILE_UPLOADER."/FileUploader.class.php";
require_once TOOL_MODULE."/Param/ParamManager.class.php";

if(ParamManager::getGet("Filter")){
    $filter = ParamManager::getGet("Filter");
}

if(ParamManager::getGet("File")){
    $file = ParamManager::getGet("File");
}

if($file||$filter){
    new FileUploader->receiveFiles($file,$filter);
}
