<?php
require_once dirname(__FILE__).'/Config.php';
//According to different databases,choose different database adapters.
if (defined("DATABASE_MYSQL_DEFAULT")){
    define("DEFAULT_MASTER_HOST",'127.0.0.1');
    if(defined("DATABASE_MULTI_HOST")){
        define("DEFAULT_SLAVE_HOST",'127.0.0.1');
    }
    define("DEFAULT_HOST",DEFAULT_MASTER_HOST);
    define("DEFAULT_PORT",'3306');
    define("DEFAULT_USER",'root');
    define("DEFAULT_PASSWD",'^Ganji@201314$');
    define("DEFAULT_RESULT_STYLE_ARRAY",1);
}

