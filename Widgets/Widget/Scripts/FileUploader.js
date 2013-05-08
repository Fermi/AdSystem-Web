//Below include must be included in head of the template.
//Src must be changed to static server location.
<script type="text/javascript" src="Static/Libs/jquery-1.4.5.js"></script>

<script type="text/javascript">
    function AddMoreFile(){
        var item_num = $("FileNum").val();
        
        var append_string = "";
        append_string += "<div id='FileUploaderItem"+item_num;
        append_string += "' class='FileUploaderItem'> <input type='file' id='FileUploaderSelector"+item_num;
        append_string +="' class='FileUploaderSelector' name='FileUploader"+item_num;
        append_string +="' /><input type='button' class='FileUploaderDeleteButton' id='FileUploaderDeleteButton"+item_num;
        append_string +="' onclick='RemoveLastFile();' /><input type='button' id='FileUploaderMoreButton"+item_num;
        append_string +="' class='FileUploaderMoreButton' alt='添加上传文件' /> <input type='text' id='FileUploaderLabel"+item_num;
        append_string +="' class='FileUploaderLabel'  /> </div>"
        
        $("FileUploaderSection").append(append_string);
        $("FileUploaderMoreButton"+item_num).click(AddMoreFile);
        $("FileUploaderDeleteButton"+item_num-1).remove();
        $("FileNum").val(item_num+1);
    }
    function RemoveLastFile(){
        var item_num = $("FileNum").val();
        $("FileUploaderSection"+item_num-1).remove();
    }
    $("FileUploaderMoreButton").click(AddMoreFile);
</script>
