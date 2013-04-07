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
}      
