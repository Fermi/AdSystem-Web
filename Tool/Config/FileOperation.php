<?php
require_once dirname(__FILE__)."Config.php";
//Widget root.
define("FILE_ROOT",dirname(dirname(__FILE__))."/FileOperation");
//File prefix.
define("FILE_PREFIX",ROOT_DIR."/Uploads");

define("FILE_UPLOADER",FILE_ROOT.'/FileUploader');
define("FILE_DOWNLOADER",FILE_ROOT.'FileDownloader');

