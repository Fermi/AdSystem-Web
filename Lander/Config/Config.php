<?php
require_once dirname(dirname(dirname(__FILE__))).'/Config/Config.inc.php';

if(defined('IS_DEBUG')){
    error_reporting(E_ALL);
    ini_set('display_errors','On');
}
