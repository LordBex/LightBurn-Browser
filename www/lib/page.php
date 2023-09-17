<?php

class Page {

    /**
     * @var Smarty
     */
    public $smarty;

    public function __construct(){
        global $user;
        $smarty = new Smarty();

        $smarty->setTemplateDir(TEMPLATE_DIR);
        $smarty->setCompileDir(MY_SMARTY_DIR.'templates_c/');
        $smarty->setCacheDir(MY_SMARTY_DIR.'cache/');
        $smarty->setConfigDir(MY_SMARTY_DIR.'configs/');

        $smarty->assign('WWW_TOP', WWW_TOP);

        // init default values
        $smarty->assign('page_title', 'LightBurn - Browser');
        $smarty->assign('error', '');


        $smarty->assign('isLogged', $user->isLogged());

        $this->smarty = $smarty;
    }

    public function assign($key, $value){
        $this->smarty->assign($key, $value);
    }

    public function render($template, $base='baseTemplate.tpl'): void
    {
        $content = $this->smarty->fetch($template);
        $this->assign('content', $content);
        $this->smarty->display($base);
    }

    public function render_with($content, $base='baseTemplate.tpl'): void
    {
        $this->assign('content', $content);
        $this->smarty->display($base);
    }

    public function raise_403()
    {
        header("Location: ".WWW_TOP."/login?redirect=".urlencode($_SERVER["REQUEST_URI"]));
        die();
    }

}