<?php
global $user;
global $pager;
require_once (WWW_DIR.'lib/utils.php');

if (!$user->isLogged()) {
    $pager->raise_403();
}

$target_path = $_GET['path'] ?? '';
$target_path = cleanPath($target_path);
if (!preg_match('/^[\w0-9-_\/. ]*$/iu', $target_path)) {
    die("Invalid path!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $fileName = $file['name'];
        $fileTmp = $file['tmp_name'];

        $targetDir = BROWSER_PATH . DIRECTORY_SEPARATOR . $target_path;
        $targetFile = $targetDir . DIRECTORY_SEPARATOR . basename($fileName);

        if (!preg_match('/^([\w0-9_\- \/]+\.?)*\.lbrn2?$/iu', $fileName)) {
            die("Invalid File Name!");
        }

        if (move_uploaded_file($fileTmp, $targetFile)) {
            echo "File has been uploaded successfully.";
        } else {
            echo "Failed to upload file.";
        }
    }
}

header('Location: '.WWW_TOP.'/browser?path='.urlencode($target_path));
