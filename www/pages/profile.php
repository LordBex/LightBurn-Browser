<?php
global $user;
global $pager;

if (!$user->isLogged()) {
    $pager->raise_403();
}

$current_user = $user->getCurrentUser();
$pager->assign('user', $current_user);
$pager->render('profile.tpl');
