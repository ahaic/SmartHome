<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require LIB.'common/common'.EXT;
header("Content-type:text/html;charset=utf-8");
define('IMG_PATH', SITEPATH.'static/images/');
define('JS_PATH', SITEPATH.'static/scripts/');
define('CSS_PATH', SITEPATH.'static/styles/');
define('CACHE_PATH', SITEPATH.'static/cache/');
define('IS_SINA_APP', FALSE);
define('SINA_APP_DOMAIN', 'qcms');
load_file(array(
	'Base'			=>	'class', 
	'Db_base'		=>	'db',  
	'Db_class'		=>	'class', 
	'Temp_base'		=>  'temp', 
	'Temp'			=>  'class',
	'Upload'		=>	'class',
	'Pinyin'		=>  'class',
	'Cache'			=>	'class',)
);
load_class('Router');
?>