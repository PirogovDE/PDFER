<?php

use app\PDFer;

require_once "vendor/autoload.php";

$defaultPath = "FilesToConvert";

$pdfer = new PDFer();

$pdfer->getContentRecursively($defaultPath);

$pdfer->dompdf->loadHtml('<pre>' . $pdfer->implodeContentWithHtml("<br>"));

$pdfer->dompdf->render();
$pdfer->dompdf->stream();