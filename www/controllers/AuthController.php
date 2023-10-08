<?php
namespace Site\Controllers;

use Exception;
use GuestController;
use UserClass;


class AuthController extends GuestController {

    public function login(): void
    {
        if (isset($_POST['username'], $_POST['password'])) {
            if ($this->user->login($_POST['username'], $_POST['password'])) {
                header("Location: ".WWW_TOP."/profile");
            } else {
                $this->assign('error', 'Fehler beim Anmelden. Überprüfen Sie Benutzername/Passwort.');
            }
        }

        $this->assign('username', $_POST['username'] ?? '');
        $this->assign('rememberme', $_POST['rememberme'] ?? 0);
        $this->assign('redirect', (isset($_GET['redirect'])) ? $_GET['redirect'] : '');


        $this->render('login.tpl', 'baseModal.tpl');
    }

    public function logout(): void
    {
        $this->user->logout();
        header("Location: ".WWW_TOP."/login");
    }

    public function oidcLogin(): void
    {
        try {
            if ($this->user->loginOpenId()) {
                header("Location: ".WWW_TOP."/profile");
            }
        } catch (Exception $e) {
            $this->assign('username', $_POST['username'] ?? '');
            $this->assign('rememberme', $_POST['rememberme'] ?? 0);
            $this->assign('redirect', (isset($_GET['redirect'])) ? $_GET['redirect'] : '');

            $this->assign('error', $e->getMessage());
            $this->render('login.tpl', 'baseModal.tpl');
        }
    }

    public function register(): void
    {
        if (isset($_POST['username'], $_POST['password'])) {
            if ($this->user->register($_POST['username'], $_POST['password'])) {
                header("Location: /login");
            } else {
                $this->assign('error', 'Fehler bei der Registrierung. Bitte versuchen Sie es später erneut.');
            }
        }

        $this->render('register.tpl', 'baseModal.tpl');
    }
}
