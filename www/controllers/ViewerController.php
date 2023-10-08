<?php
namespace Site\Controllers;
use LightburnParser;
use UserController;

class ViewerController extends UserController
{
    public function view($path): void
    {
        require_once (WWW_DIR.'lib/lightburnParser.php');
        require_once (WWW_DIR.'lib/utils.php');

        $parser = new LightburnParser();
        $path = urldecode($path);
        $data = $parser->parse($path);

        $this->assign('data', $data['info']);
        $this->assign('path', $data['path']);
        $this->assign('path_tree', splitPathIntoSubPaths($data['path']));

        $this->render('viewer.tpl');
    }

    public function drop(){
        $this->renderWith(file_get_contents(VIEWS_DIR.'viewer_drop.html'));
    }
}
