<?php
//Include File Config.
//require_once 
require_once FILE_DOWNLOADER."/FileDownloader.class.php";
require_once TOOL_MODULE."/Param/ParamManager.class.php";

if(ParamManager::getGet("Filter")){
    $filter = ParamManager::getGet("Filter");
}
if(ParamManager::getGet("File")){
    $file = ParamManager::getGet("File");
}
if(ParamManager::getGet("SearchFileNames")){
    $search_file_names = ParamManager::getGet("SearchFileNames");
}

//If wanna get infos from Database.Just fetch from Database. FileDownloader only downloads Files from places.
if($file){
    new FileDownloader()->downloadFiles($file,$filter);
}
if($search_file_names){
    new FileDownloader()->searchFileNames($filter);
}
