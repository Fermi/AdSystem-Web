<?php
require_once dirname(dirname(dirname(__FILE__)))."/Config/FileOperation.php"; 

class FileUploader{
    public function receiveFiles($dest_path = NULL){
        if(!empty($dest_path)){
            $file_path = FILE_PREFIX.$dest_path;
        } else {
            $file_path = FILE_PREFIX;
        }
        
        

    }


}
