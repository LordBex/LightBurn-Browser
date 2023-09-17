<?php

require_once(WWW_DIR.'/lib/user.php');

global $pager;
$user = new UserClass();

if (!REGISTRATION_STATUS) {
    die("Registration Closed !");
}

if (isset($_POST['username'], $_POST['password'], $_POST['password-2'])){
    if ($_POST['password'] == $_POST['password-2']) {
        if ($user->register($_POST['username'], $_POST['password'])) {
            header("Location: " . WWW_TOP);
        } else {
            $pager->assign('error', 'Irgendwas ist schiefgelaufen');
        }
    } else {
        $pager->assign('error', 'Passwörter sind nicht identisch');
    }
}


$pager->assign('username', $_POST['username'] ?? '');
$pager->assign('redirect', (isset($_GET['redirect'])) ? $_GET['redirect'] : '');

$pager->render('register.tpl', 'baseModal.tpl');

