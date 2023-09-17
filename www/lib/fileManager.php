<?php

require_once (WWW_DIR.'lib/utils.php');

class FileItem {
    public $type = 'file';
    public $name;
    public $full_path;
    public $relative_path;

    function __construct($name, $full_path, $relative_path) {
        $this->name = $name;
        $this->full_path = $full_path;
        $this->relative_path = $relative_path;
    }
}

class DirectoryItem {
    public $type = 'dir';
    public $name;
    public $full_path;
    public $relative_path;

    function __construct($name, $full_path, $relative_path) {
        $this->name = $name;
        $this->full_path = $full_path;
        $this->relative_path = $relative_path;
    }
}

class FileBrowser{

    public function __construct(){}

    public function get_files_in_path($sub_path = ''): array
    {
        $sub_path = cleanPath($sub_path);
        $selected_path = BROWSER_PATH . DIRECTORY_SEPARATOR . $sub_path;
        $files = scandir($selected_path);

        if ($files === false){
            return [];
        }

        foreach($files as $key=>$value) {
            $files[$key] = $sub_path .  DIRECTORY_SEPARATOR . $value;
        }

        $filtered_items = array_filter(array_map(array($this, 'format_dir_item'), $files), function ($item) {
            return $item !== false;
        });

        usort($filtered_items, function ($a, $b) {
            if ($a->type === 'dir' && $b->type !== 'dir') {
                return -1;
            }
            if ($a->type !== 'dir' && $b->type === 'dir') {
                return 1;
            }
            return strcmp($a->name, $b->name);
        });

        return $filtered_items;
    }

    public function format_dir_item($file): bool|DirectoryItem|FileItem
    {
        $full_path = BROWSER_PATH . DIRECTORY_SEPARATOR . $file;
        $base_name = basename($file);

        if (str_starts_with($base_name, '@')){
            return false;
        }

        if (str_ends_with($file, '.')){
            return false;
        }

        if (pathinfo($file, PATHINFO_EXTENSION) === 'lbrn' || pathinfo($file, PATHINFO_EXTENSION) === 'lbrn2') {
            return new FileItem($base_name, realpath($full_path), $file);
        } else if (is_dir($full_path)) {
            return new DirectoryItem($base_name, realpath($full_path), $file);
        } else {
            return false;
        }
    }

    public function rename_file($file, $new_name) {
        // Prüft, ob $file relative Pfadangaben enthält
        if (str_contains($file, '../') || str_contains($file, './')) {
            header('HTTP/1.1 403 Forbidden');
            exit('Permission Denied');
        }

        $full_path = BROWSER_PATH . DIRECTORY_SEPARATOR . $file;
        $new_full_path = dirname($full_path) . DIRECTORY_SEPARATOR . basename($new_name);

        // Überprüft, ob die Datei tatsächlich im angegebenen Pfad existiert
        if (!file_exists($full_path)) {
            header('HTTP/1.1 404 Not Found');
            exit('Datei nicht gefunden');
        }
        // Überprüft, ob die Datei tatsächlich im BROWSER_PATH liegt
        if (!str_starts_with(realpath($full_path), BROWSER_PATH)) {
            header('HTTP/1.1 403 Forbidden');
            exit('Nicht erlaubt, Dateien außerhalb des BROWSER_PATH umzubenennen');
        }
        // Versucht, die Datei umzubenennen
        if (!rename($full_path, $new_full_path)) {
            header('HTTP/1.1 500 Internal Server Error');
            exit('Datei konnte nicht umbenannt werden');
        }

        return true;
    }

    public function create_folder($folder_path, $new_folder_name) {
        // Prüft, ob $folder_path relative Pfadangaben enthält
        if (str_contains($folder_path, '../') || str_contains($folder_path, './')) {
            header('HTTP/1.1 403 Forbidden');
            exit('Permission Denied');
        }

        // Prüft, ob der neue Ordnername nur erlaubte Zeichen enthält
        if (!preg_match('/^[a-z0-9_-]+$/i', $new_folder_name)) {
            header('HTTP/1.1 400 Bad Request');
            exit('Ungültiger Ordnername');
        }

        $full_path = BROWSER_PATH . DIRECTORY_SEPARATOR . $folder_path;
        $new_full_path = $full_path . DIRECTORY_SEPARATOR . $new_folder_name;

        // Überprüft, ob der Ordner bereits existiert
        if (file_exists($new_full_path)) {
            header('HTTP/1.1 409 Conflict');
            exit('Ordner existiert bereits');
        }

        // Überprüft, ob der Ordner tatsächlich im BROWSER_PATH liegt
        if (!str_starts_with(realpath($full_path), BROWSER_PATH)) {
            header('HTTP/1.1 403 Forbidden');
            exit('Nicht erlaubt, Ordner außerhalb des BROWSER_PATH zu erstellen');
        }

        // Versucht, den Ordner zu erstellen
        if (!mkdir($new_full_path)) {
            header('HTTP/1.1 500 Internal Server Error');
            exit('Ordner konnte nicht erstellt werden');
        }

        return true;
    }

    public function delete_folder($folder_path) {
        // Prüft, ob $folder_path relative Pfadangaben enthält
        if (str_contains($folder_path, '../') || str_contains($folder_path, './')) {
            header('HTTP/1.1 403 Forbidden');
            exit('Permission Denied');
        }

        $full_path = BROWSER_PATH . DIRECTORY_SEPARATOR . $folder_path;

        // Überprüft, ob das Verzeichnis existiert
        if (!is_dir($full_path)) {
            header('HTTP/1.1 404 Not Found');
            exit('Ordner nicht gefunden');
        }

        // Überprüft, ob der Ordner tatsächlich im BROWSER_PATH liegt
        if (strpos(realpath($full_path), BROWSER_PATH) !== 0) {
            header('HTTP/1.1 403 Forbidden');
            exit('Nicht erlaubt, Ordner außerhalb des BROWSER_PATH zu löschen');
        }

        // Versucht, den Ordner zu löschen
        if (!rmdir($full_path)) {
            header('HTTP/1.1 500 Internal Server Error');
            exit('Ordner konnte nicht gelöscht werden. Stellen Sie sicher, dass der Ordner leer ist.');
        }

        return true;
    }
}

