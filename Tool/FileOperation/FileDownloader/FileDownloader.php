<?php
require_once dirname(__FILE__)."/FileDownloader.class.php";
require_once TOOL_MODULE."/Param/ParamManager.class.php";

if(ParamManager::getGet("Filter")){
    $filter = ParamManager::getGet("Filter");
}
if(ParamManager::getGet("File")){
    $file = ParamManager::getGet("File");
}
if(ParamManager::getGet("GetFileName")){
    $get_file_name = ParamManager::getGet("GetFileName");
}

if($file||$filter){
    new FileDownloader()->downloadFiles($file,$filter);
}
if($get_file_name){
    new FileDownloader()->getFileNames($filter);
}
