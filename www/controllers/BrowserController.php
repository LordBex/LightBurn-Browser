<?php
declare(strict_types=1);
namespace Site\Controllers;

use FileBrowser;
use UserController;

class BrowserController extends UserController
{
    public function index(string $path = ""): void
    {
        require_once(WWW_DIR . 'lib/fileManager.php');

        $fileBrowser = new FileBrowser();
        $path = urldecode($path);
        $items = $fileBrowser->get_files_in_path($path);

        require_once(WWW_DIR . 'lib/utils.php');
        $this->assign('path_tree', splitPathIntoSubPaths($path));
        $this->assign("path", $path);
        $this->assign("items", $items);

        $this->render('browser.tpl');
    }

    public function download(string $path)
    {
        $path = urldecode($path);

        /* Check if the file name includes illegal characters like "../" using the regular expression */
        if (!preg_match('/^([\w0-9_\- \/]+\.?)*\.lbrn2?$/iu', $path)) {
            die("Invalid file name!");
        }

        $filepath = BROWSER_PATH . DIRECTORY_SEPARATOR . $path;

        // Process download
        if (!file_exists($filepath)) {
            http_response_code(404);
            die();
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        exit();
    }

    public function upload(string $path)
    {
        require_once (WWW_DIR.'lib/utils.php');

        $path = cleanPath(urldecode($path));
        if (!preg_match('/^[\w0-9-_\/. ]*$/iu', $path)) {
            die("Invalid path!");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['file'])) {
                $file = $_FILES['file'];
                $fileName = $file['name'];
                $fileTmp = $file['tmp_name'];

                $targetDir = BROWSER_PATH . DIRECTORY_SEPARATOR . $path;
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

        header('Location: '.WWW_TOP.'/browser/'.$path);
        exit();
    }
}