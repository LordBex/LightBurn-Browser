<?php

global $pager;
global $user;

require_once (WWW_DIR.'lib/fileManager.php');

$fileBrowser = new FileBrowser();

$user = new UserClass();
if (!$user->isLogged()) {
    $pager->raise_403();
}

if (empty($_REQUEST['action'])){
    header('HTTP/1.1 400 Bad Request');
    exit("Fehlende oder ungültige 'action' Parameter");
}

$action = $_REQUEST['action'];

switch ($action){
    case 'rename-file':
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

        if ($fileBrowser->rename_file($path, $newName)) {
            exit('Success');
        }
        break;
    case 'delete-file':
        if (empty($_POST['path'])){
            header('HTTP/1.1 400 Bad Request');
            exit("Fehlende oder ungültige 'path' Parameter");
        }
        $path = urldecode($_POST['path']);
        if ($fileBrowser->delete_file($path)) {
            exit('Success');
        }
        break;
    case 'create-folder':
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

        if ($fileBrowser->create_folder($path, $folderName)) {
            exit('Success');
        }
        break;
    case 'delete-folder':
        if (empty($_POST['path'])) {
            header('HTTP/1.1 400 Bad Request');
            exit("Fehlender oder ungültiger 'path' Parameter");
        }

        $path = urldecode($_POST['path']);

        if ($fileBrowser->delete_folder($path)) {
            exit('Erfolg beim Löschen des Ordners');
        }
        break;
    default:
        header('HTTP/1.1 400 Bad Request');
        exit("Ungültige 'action' Parameter");
}

