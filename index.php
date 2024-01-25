<?php
require_once "vendor/autoload.php";

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dirName = "FilesToConvert";
$pages = [];
function getContentRecursively($relativePath, $dompdf, &$pages)
{
    $files = scandir($relativePath);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        if (is_dir($relativePath . '/' . $file)) {
            $path = $relativePath . '/' . $file;
            getContentRecursively($path, $dompdf, $pages);
        } else {
            $content = file_get_contents($relativePath . '/' . $file);
            $contentClean = str_replace("<?php", "", $content);
            array_push($pages, "<h3>$file</h3>" . $contentClean);
        }
    }
}

function implodePages($pages)
{
    return implode("<br>", $pages);
}

getContentRecursively($dirName, $dompdf, $pages);
$dompdf->loadHtml('<pre>' . implodePages($pages) . '<pre>');
$dompdf->render();
$dompdf->stream();