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

    public function __construct(){

    }

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
}

