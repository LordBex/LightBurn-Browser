<?php

global $pager;
global $user;

require_once (WWW_DIR.'lib/fileManager.php');

$fileBrowser = new FileBrowser();

$user = new UserClass();
if (!$user->isLogged()) {
    $pager->raise_403();
}

$browser_path = $_GET['path'] ?? '';
$items = $fileBrowser->get_files_in_path($browser_path);

require_once (WWW_DIR.'lib/utils.php');
$pager->assign('path_tree', splitPathIntoSubPaths($browser_path));
$pager->assign("path", $browser_path );
$pager->assign("items", $items );

$pager->render('browser.tpl');
