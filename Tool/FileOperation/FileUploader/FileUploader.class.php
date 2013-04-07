<?php
require_once dirname(dirname(dirname(__FILE__)))."/Config/FileOperation.php"; 

class FileUploader{
    public function receiveFiles($file,$dest_path = NULL){
        if(!empty($dest_path)){
            $file_path = FILE_PREFIX.$dest_path;
        } else {
            $file_path = FILE_PREFIX;
        }
        
        //if(!empty($file)){
            //TODO:Rename files uploaded. 
        //} else {
        if(isset($_Files)){
            $this->_moveFiles($file_path,$_Files);    
        } else {
            return json_encode(array("Error"=>"File not uploaded!"));
        }
        //}

    }

    private function _moveFiles($file_path,$files){
        $result = array();
        
        foreach($files as $file_array){
            if($file_array['error'] > 0){
                $result['Unfinished']['File'] = $file_array['name'];
                switch($file_array['error']){
                    case 1:
                        $result['Unfinished']['Info'] = "UPLOAD_MAX_FILESIZE exceeded!";
                        break;
                    case 2:
                        $result['Unfinished']['Info'] = "MAX_FILE_SIZE exceeded!";
                        break;
                    case 3:
                        $result['Unfinished']['Info'] = "Upload incompleted!";
                        break;
                    case 4:
                        $result['Unfinished']['Info'] = "Non file uploaded!";
                        break;
                    //case 5:
                    //    break;
                    case 6:
                        $result['Unfinished']['Info'] = "Can not access Temp!";
                        break;
                    case 7:
                        $result['Unfinished']['Info'] = "Fail to write to Temp!";
                        break;
                    case 8:
                        $result['Unfinished']['Info'] = "Upload stoped unexpectly!";
                        break;
                    default:
                        $result['Unfinished']['Info'] = "Unknown error!";
                        break;
                }
                continue;
            } else {
                if(move_uploaded_file($file_array['tmp_name'],$file_path.$file_array['name'])){
                    $result['Finished']['File'] = $file_array['name'];
                    $result['Finished']['Path'] = $file_path.$file_array['name'];
                } else {
                    $result['Unfinished']['File'] = $file_array['name'];
                    $result['Unfinished']['Info'] = "Fail to move uploaded file ".$file_array['name']." !";
                }
            }
        }

        return json_encode($result);
    }

    //private function _moveFilesRename($file_path,$files,$names){
        
    //}


}
