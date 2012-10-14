<?php
error_reporting(E_ALL ^ E_NOTICE);
define('EXT','.php');
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('SITEPATH', str_replace(SELF, '', $_SERVER["PHP_SELF"]));
define('BASEPATH', 'system/');
define('LIB', 'qlib/');
require_once LIB.'Q'.EXT;
?>