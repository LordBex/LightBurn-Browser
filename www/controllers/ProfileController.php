<?php

namespace Site\Controllers;
use UserController;

class ProfileController extends UserController
{
    public function index(): void
    {
        $currentUser = $this->user->getCurrentUser();
        $this->assign('user', $currentUser);
        $this->render('profile.tpl');
    }
}
