<?php

ini_set('display_errors', 1);

require_once("config.php");
// load composer
require_once(WWW_DIR.'../vendor/autoload.php');
// load global libs
require_once(WWW_DIR.'lib/page.php');
require_once(WWW_DIR.'lib/user.php');

$user = new UserClass();
$pager = new Page();


global $pager;
global $user;

if ( isset($_GET['page'])){
    $page = preg_replace('/[^a-zA-Z0-9-_]/', '', $_GET['page']);
} else {
    $page = 'index';
}

include(WWW_DIR.'pages/'.$page.'.php');
