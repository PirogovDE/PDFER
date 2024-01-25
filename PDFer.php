<?php

namespace app;

use Dompdf\Dompdf;

class PDFer
{
    private array $content = [];
    public Dompdf $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }

    public function getContentRecursively(string $path): bool
    {
        $files = scandir($path);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || $file === '.git' || $file === '.gitignore') {
                continue;
            }
            if (is_dir($path . '/' . $file)) {
                $relativePath = $path . '/' . $file;
                $this->getContentRecursively($relativePath);
            } else {
                $content = file_get_contents($path . '/' . $file);
                $contentClean = str_replace("<?php", "", $content);
                array_push($this->content, "<h3>$file</h3>" . $contentClean);
            }
        }
        return true;
    }

    public function implodeContentWithHtml(string $html): string
    {
        return implode($html, $this->content);
    }
}