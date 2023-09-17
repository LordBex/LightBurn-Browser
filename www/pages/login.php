<?php

require_once(WWW_DIR.'/lib/user.php');

global $pager;
$user = new UserClass();

if (isset($_POST['username'], $_POST['password'])){
    if ($user->login($_POST['username'], $_POST['password'])){
        header("Location: ".WWW_TOP);
    } else {
        $pager->assign('error', 'Incorrect');
    }
}

$pager->assign('username', $_POST['username'] ?? '');
$pager->assign('rememberme', $_POST['rememberme'] ?? 0);
$pager->assign('redirect', (isset($_GET['redirect'])) ? $_GET['redirect'] : '');

$pager->render('login.tpl', 'baseModal.tpl');

