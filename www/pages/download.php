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
    if (preg_match('/^([a-z0-9_\- \/]+\.?)*\.lbrn2?$/i', $file)) {
        $filepath = BROWSER_PATH . DIRECTORY_SEPARATOR . $file;
        // Process download
        if (file_exists($filepath)) {
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
        } else {
            http_response_code(404);
            die();
        }
    } else {
        die("Invalid file name!");
    }
}

