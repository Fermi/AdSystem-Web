<?php
require_once dirname(dirname(dirname(__FILE__))).'/Config/FileOperation.php';

class FileDownloader{
    public function downloadFiles($file,$source_path = NULL){
        if(!empty($source_path)){
            $file_path = FILE_PREFIX.$source_path;
        } else {
            $file_path = FILE_PREFIX;
        }
        
        if(!empty($file)){
            if(file_exists($file_path,$file)){
                header("Content-Type: application/octet-stream");
                header("Content-Length: ".filesize($file_path.$file));
                $fp = fopen($file_path.$file,"r");
                echo fread($fp,filesize($file_path.$file));
                fclose($fp);
                return json_encode(array("Error"=>""));
            } else {
                return json_encode(array("Error"=>"File does not exist!"));
            }
        } else {
            return json_encode(array("Error"=>"Filename must be wrong!"));
        }

    }

    public function searchFileNames($filter){
        if(!empty($filter)){
            $file_path = FILE_PREFIX.$filter;
        } else {
            $file_path = FILE_PREFIX;
        }

        $result_array = array();

        if($dp = opendir($file_path)){
            while(($file_handle = readdir($file_path)) !== false){
                if(is_file($file_handle)){
                    $result_array[] = $file_handle;
                } else {
                    continue;
                }
            }

            if(!empty($result_array)){
                return json_encode(array("filter"=>$filter,"result"=>$result_array));
            } else {
                return json_encode(array("Error"=>"No files found!"));
            }
        } else {
            return json_encode(array("Error"=>"Dir could not found!"));
        }
    }
}      
