<?php


function cleanPath($path): string
{
    if ($path === null || $path === '') {
        return '';
    }
    return preg_replace('/\/?\.{2,}\/?/', '', $path);
}

function splitPathIntoSubPaths($path): array
{
    $subPaths = [];
    $parts = explode('/', $path);
    $currentPath = '';

    foreach ($parts as $part) {
        if (!empty($part)) {
            $currentPath .= '/' . $part;
            $subPaths[$part] = $currentPath;
        }
    }

    return $subPaths;
}


