<?php
//Dir.
define("ROOT_DIR",dirname(dirname(__FILE__)));
define("CONFIG_DIR",dirname(__FILE__));

//Module.
define("CONTROLLER_MODULE",ROOT_DIR.'/Controller');
define("LANDER_MODULE",ROOT_DIR.'/Lander');
define("LOADER_MODULE",ROOT_DIR.'/Loader');
define("TOOL_MODULE",ROOT_DIR.'/Tool');
define("DATA_MODULE",ROOT_DIR.'/Data');
define("EXTENSION_MODULE",ROOT_DIR.'/Extension');

//Switch.
define("IS_DEBUG",1);
#define("IS_PRODUCT",1);
//Options.
//Database.
define("DATABASE_NOT_POOL",1);
#define("DATABASE_MULTI_HOST",1);
define("DATABASE_MYSQL_DEFAULT",1);
