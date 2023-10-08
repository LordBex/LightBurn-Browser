<?php

namespace Site\Controllers;

use Exception;
use GuestController;

class OpenIDController extends GuestController
{
    public function login($key): void
    {
        require_once WWW_DIR.'lib/openid.php';
        try {
            if(!isset(CONFIGS['oidc_providers'][$key])) {
                die("Unbekannter OIDC Provider");
            }
            $conf = CONFIGS['oidc_providers'][$key];
            $oidc = new \OpenID($conf['name'], $conf['url'], $conf['client_id'], $conf['secret']);
            if ($oidc->loginOpenId()) {
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

}