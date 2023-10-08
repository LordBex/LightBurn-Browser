<?php
namespace Site\Controllers;
use GuestController;

class IndexController extends GuestController
{
    public function index(): void
    {
        $this->render('index.tpl');
    }
}