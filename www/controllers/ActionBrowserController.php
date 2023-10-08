<?php

namespace Site\Controllers;

use FileBrowser;
use UserClass;

class ActionBrowserController {

    protected $pager;
    protected $user;
    protected $fileBrowser;

    public function __construct() {
        require_once WWW_DIR.'lib/fileManager.php';
        global $pager, $user;
        $this->pager = $pager;
        $this->user = $user;
        $this->fileBrowser = new FileBrowser();

        if (!$this->user->isLogged()) {
            $this->pager->raise_403();
        }
    }

    public function handleRequest() {
        if (empty($_REQUEST['action'])) {
            $this->sendErrorResponse("Fehlende oder ungültige 'action' Parameter");
        }

        $action = $_REQUEST['action'];

        switch ($action) {
            case 'rename-file':
                $this->renameFile();
                break;
            case 'delete-file':
                $this->deleteFile();
                break;
            case 'create-folder':
                $this->createFolder();
                break;
            case 'delete-folder':
                $this->deleteFolder();
                break;
            default:
                $this->sendErrorResponse("Ungültige 'action' Parameter");
        }
    }

    protected function renameFile(): void
    {
        if (empty($_POST['newName'])){
            header('HTTP/1.1 400 Bad Request');
            exit("Fehlende oder ungültige 'newName' Parameter");
        }
        if (empty($_POST['path'])){
            header('HTTP/1.1 400 Bad Request');
            exit("Fehlende oder ungültige 'path' Parameter");
        }
        $path = urldecode($_POST['path']);
        $newName = urldecode($_POST['newName']);

        if ($this->fileBrowser->rename_file($path, $newName)) {
            exit('Success');
        }
    }

    protected function deleteFile(): void
    {
        if (empty($_POST['path'])){
            header('HTTP/1.1 400 Bad Request');
            exit("Fehlende oder ungültige 'path' Parameter");
        }
        $path = urldecode($_POST['path']);
        if ($this->fileBrowser->delete_file($path)) {
            exit('Success');
        }
    }

    protected function createFolder(): void
    {
        if (empty($_POST['newFolderName'])) {
            header('HTTP/1.1 400 Bad Request');
            exit("Fehlender oder ungültiger 'newFolderName' Parameter");
        }
        if (empty($_POST['path'])) {
            header('HTTP/1.1 400 Bad Request');
            exit("Fehlender oder ungültiger 'path' Parameter");
        }
        $path = urldecode($_POST['path']);
        $folderName = urldecode($_POST['newFolderName']);

        if ($this->fileBrowser->create_folder($path, $folderName)) {
            exit('Success');
        }
    }

    protected function deleteFolder(): void
    {
        if (empty($_POST['path'])) {
            header('HTTP/1.1 400 Bad Request');
            exit("Fehlender oder ungültiger 'path' Parameter");
        }

        $path = urldecode($_POST['path']);

        if ($this->fileBrowser->delete_folder($path)) {
            exit('Erfolg beim Löschen des Ordners');
        }
    }

    protected function sendErrorResponse($message) {
        header('HTTP/1.1 400 Bad Request');
        exit($message);
    }
}
