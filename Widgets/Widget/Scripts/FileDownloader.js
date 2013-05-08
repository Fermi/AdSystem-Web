//Below include must be included at the head of the template.
//Src must be changed to static server location.
<script type="text/javascript" src="Static/Libs/jquery-1.4.5.js"></script>

<script type="text/javascript">
    function FillFileDownloader(obj){
        var filter = "";
        var count = 0;
        if(obj.Filter){
            filter = obj.Filter;
        }

        if(obj.result){
            $.each(obj.result,function(item){
                var append_string = "";

                if(count == 0){
                    append_string += "<div id='FileDownloaderItem' class='FileDownloaderItem'><label id='FileDownloaderLabel' class='FileDownloaderLabel' >XXX</label><a class='FileDownloaderButton' href='http://XXX.com/FileDownloader?Filter="+filter;
                    append_string += "&File="+item;
                    append_string += "' >下载</a></div>";
                } else {
                    append_string += "<div id='FileDownloaderItem"+count;
                    append_string += "' class='FileDownloaderItem'><label id='FileDownloaderLabel"+count;
                    append_string += "' class='FileDownloaderLabel' >XXX</label><a class='FileDownloaderButton"+count;
                    append_string += "' href='http://XXX.com/FileDownloader?Filter="+filter;
                    append_string += "&File="+item;
                    append_string += "' >下载</a></div>";
                }
                
                count ++;
                $("FileDownloaderSection").append(append_string);
            });
        }
    }

    var request_url = "FileDownloader.php";
    $.ajax({
        url:request_url,
        success:FillFileDownloader
    });
</script>
