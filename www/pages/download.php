<?php
global $user;
global $pager;

if (!$user->isLogged()) {
    $pager->raise_403();
}

if (isset($_REQUEST["path"])) {
    // Get parameters
    $file = urldecode($_REQUEST["path"]); // Decode URL-encoded string

    /* Check if the file name includes illegal characters like "../" using the regular expression */
    if (!preg_match('/^([\w0-9_\- \/]+\.?)*\.lbrn2?$/iu', $file)) {
        die("Invalid file name!");
    }

    $filepath = BROWSER_PATH . DIRECTORY_SEPARATOR . $file;
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
    header('Location: '.$_SERVER["REQUEST_URI"]);
    die();

}

