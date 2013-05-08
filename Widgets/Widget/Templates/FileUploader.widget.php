<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/1999/xhtml">
<html>
    <head>
        <title>FileUploader Widget</title>
    </head>
    <!-- href location can be changed to style server -->
    <!-- style can be included here or within global style file -->
    <link rel="stylesheet" type="text/css" href="Static/Style/FileUploader.css" />
    <body>
        <form id="FileUploaderSection" class="FileUploader" action="FileUploader.php" enctype="multipart/form-data" method="post">
            <input type="hidden" id="FileNum" value="1" />
            <div id="FileUploaderItem" class="FileUploaderItem">
                <input type="file" id="FileUploaderSelector" class="FileUploaderSelector" name="FileUploader" /><input type="button" id="FileUploaderMoreButton" class="FileUploaderMoreButton" alt="添加上传文件" />
                <input type="text" id="FileUploaderLabel" class="FileUploaderLabel"  />
            </div>
        </form>
        <!-- scripts myst be included in a script file at the bottom of the file.In the header,because of the load time is ong,was forbidden. -->
    </body>
</html>
