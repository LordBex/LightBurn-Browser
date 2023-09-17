<?php

require_once (WWW_DIR.'lib/utils.php');

class LightburnParser {

    public function __construct() {
    }

    public function parse($relativePath) {
        $relativePath = cleanPath($relativePath);
        $filePath = BROWSER_PATH . DIRECTORY_SEPARATOR . $relativePath;

        $xmlString = file_get_contents($filePath);
        $xmlDoc = new DOMDocument();
        $xmlDoc->loadXML($xmlString);

        $xpath = new DOMXPath($xmlDoc);

        $shapeNodes = $xpath->query("//Shape[@Font]");
        $fonts = [];
        foreach ($shapeNodes as $shape) {
            $fonts[] = $shape->getAttribute('Font');
        }
        $uniqueFonts = array_unique($fonts);

        $data = [
            'AppVersion' => $xmlDoc->documentElement->getAttribute('AppVersion'),
            'FormatVersion' => $xmlDoc->documentElement->getAttribute('FormatVersion'),
            'Fonts' => $uniqueFonts
        ];

        $thumbnailElement = $xpath->query("//Thumbnail")->item(0);
        if ($thumbnailElement) {
            $data['Thumbnail'] = $thumbnailElement->getAttribute('Source');
        } else {
            $data['Thumbnail'] = null;
        }

        return [
            'path' => $relativePath,
            'info' => $data
        ];
    }
}

