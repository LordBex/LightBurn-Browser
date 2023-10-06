<?php


function cleanPath($path): string
{
    if ($path === null || $path === '') {
        return '';
    }
    $path = preg_replace('/\/?\.{2,}\/?/i', '', $path);
    return $path;
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


