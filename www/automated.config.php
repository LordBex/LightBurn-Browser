<?php

$www_top = str_replace("\\","/",dirname( $_SERVER['PHP_SELF'] ));
if(strlen($www_top) == 1)
	$www_top = "";

//
// used everywhere an href is output
//
define('WWW_TOP', $www_top);

//
// used to refer to the /www/lib class files
//
define('WWW_DIR', realpath(dirname(__FILE__)).'/');

//
// path to smarty files
//
define('MY_SMARTY_DIR', WWW_DIR.'lib/smarty/');

//
// smarty template dir
//
define('TEMPLATE_DIR', WWW_DIR.'templates/');