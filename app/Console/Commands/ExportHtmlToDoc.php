<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use voku\helper\HtmlDomParser;

class ExportHtmlToDoc extends Command
{
    protected $signature = 'export:html2doc';
    protected $description = 'Consolidate HTML files into DOCX files';

    private $sourceDir = 'P:/Biblib/BDE/spa/html';
    private $destinationDir = 'P:/Biblib/BDE/spa/docx';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->consolidateHtmlToDocx($this->sourceDir, $this->destinationDir);
        $this->info("Proceso completado. Los archivos DOCX se han creado en el directorio correspondiente.");
    }

    private function consolidateHtmlToDocx($htmlDir, $docxDir)
    {
        $phpWord = new PhpWord();

        // Crear el directorio de destino si no existe
        if (!is_dir($docxDir)) {
            mkdir($docxDir, 0777, true);
        }

        $directoryIterator = new RecursiveDirectoryIterator($htmlDir);
        $iterator = new RecursiveIteratorIterator($directoryIterator);
        $filteredIterator = new RegexIterator($iterator, '/^.+\.html$/i', RecursiveRegexIterator::GET_MATCH);

        $fileGroups = [];

        // Agrupar archivos por directorio
        foreach ($filteredIterator as $file) {
            $filePath = $file[0];
            $relativePath = str_replace($htmlDir . DIRECTORY_SEPARATOR, '', $filePath);
            $dirName = dirname($relativePath);
            $fileGroups[$dirName][] = $filePath;
        }

        foreach ($fileGroups as $dirName => $files) {
            // Ordenar los archivos por el prefijo numérico
            usort($files, function($a, $b) {
                return strnatcmp(basename($a), basename($b));
            });

            $section = $phpWord->addSection();

            // Leer y agregar el contenido HTML al documento Word
            foreach ($files as $file) {
                $htmlContent = file_get_contents($file);
                $cleanHtml = $this->cleanHtmlWithSimpleHtmlDom($htmlContent);
                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $cleanHtml, false, false);
            }

            // Guardar el archivo DOCX
            $docxFilePath = $docxDir . DIRECTORY_SEPARATOR . $dirName . '.docx';
            $docxDirPath = dirname($docxFilePath);

            // Crear el subdirectorio si no existe
            if (!is_dir($docxDirPath)) {
                mkdir($docxDirPath, 0777, true);
            }

            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save($docxFilePath);
        }
    }

    private function cleanHtmlWithSimpleHtmlDom($html)
    {
        $dom = HtmlDomParser::str_get_html($html);
        return $dom->save();
    }
}
