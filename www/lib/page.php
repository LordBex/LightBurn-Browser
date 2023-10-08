<?php

declare(strict_types=1);


class GuestController
{
    protected Smarty $smarty;
    protected UserClass $user;

    public function __construct(UserClass $user)
    {
        $this->user = $user;
        $this->smarty = new Smarty();

        $this->smarty->setTemplateDir(TEMPLATE_DIR);
        $this->smarty->setCompileDir(MY_SMARTY_DIR . 'templates_c/');
        $this->smarty->setCacheDir(MY_SMARTY_DIR . 'cache/');
        $this->smarty->setConfigDir(MY_SMARTY_DIR . 'configs/');

        $this->smarty->assign('WWW_TOP', WWW_TOP);

        $this->smarty->assign('page_title', 'LightBurn - Browser');
        $this->smarty->assign('error', '');

        $this->smarty->assign('isLogged', $this->user->isLogged());
    }

    public function assign(string $key, mixed $value): void
    {
        $this->smarty->assign($key, $value);
    }

    protected function render(string $template, string $base = 'baseTemplate.tpl'): void
    {
        $content = $this->smarty->fetch($template);
        $this->assign('content', $content);
        $this->smarty->display($base);
    }

    protected function renderWith(mixed $content, string $base = 'baseTemplate.tpl'): void
    {
        $this->assign('content', $content);
        $this->smarty->display($base);
    }

    protected function raise403(): void
    {
        header("Location: " . WWW_TOP . "/login?redirect=" . urlencode($_SERVER["REQUEST_URI"]));
        exit();
    }

    // Hier können Sie zusätzliche gemeinsame Methoden hinzufügen
}

class UserController extends GuestController
{
    public function checkPermission(): void {
        $user = new UserClass();
        if (!$user->isLogged()) {
            $this->raise403();
        }
    }

    public function __construct(UserClass $user)
    {
        parent::__construct($user);
        $this->checkPermission();
    }
}
