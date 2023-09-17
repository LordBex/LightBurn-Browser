<?php
global $user;
global $pager;

if (!$user->isLogged()) {
    $pager->raise_403();
}

require_once (WWW_DIR.'lib/lightburnParser.php');
require_once (WWW_DIR.'lib/utils.php');

$parser = new LightburnParser();

if (empty($_GET['path'])){
    $pager->render_with(file_get_contents(TEMPLATE_DIR.'viewer_drop.html'));
    die();
}

$data = $parser->parse($_GET['path']);

$pager->assign('data', $data['info']);
$pager->assign('path', $data['path']);
$pager->assign('path_tree', splitPathIntoSubPaths($data['path']));

$pager->render('viewer.tpl');
