<?php

use app\PDFer;

require_once "vendor/autoload.php";

$defaultPath = "FilesToConvert";

$pdfer = new PDFer();

$pdfer->getContentRecursively($defaultPath);

$pdfer->dompdf->loadHtml('<pre>' . $pdfer->implodeContentWithHtml("<br>"));
//                                  width height
$pdfer->dompdf->setPaper(array(0, 0, 1000, 1400));
$pdfer->dompdf->render();
$pdfer->dompdf->stream();