<?php
//This don't communicate with Database.If wanna communicate with Database,write another file like this one.
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

//Don't used now.
if(ParamManager::getGet("SetFileNames")){
    $set_file_name = ParamManager::getGet("SetFileNames");
}

//$file don't use now.
if($filter||$file){
    new FileUploader->receiveFiles($file,$filter);
}
