<?php

require_once(WWW_DIR.'lib/user.php');

$user = new UserClass();
$user->logout();

header("Location: ".WWW_TOP);