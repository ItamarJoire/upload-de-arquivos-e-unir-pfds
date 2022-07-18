<?php

use \setasign\Fpdi\Fpdi;

require 'fpdf/fpdf.php';
require 'fpdi/src/autoload.php';

$files = array("734281760-pdf2.pdf", "1206501173-pdf2.pdf", "84790181-pdf1.pdf", "418825944-pdf2.pdf");

$pdf = new Fpdi();

foreach ($files as $file) {
  $pageCount = $pdf->setSourceFile($file);
  for ($pagNo = 1; $pagNo <= $pageCount; $pagNo++) {
    $template = $pdf->importPage($pagNo);
    $size = $pdf->getTemplateSize($template);
    $pdf->AddPage($size['orientation'], $size);
    $pdf->useTemplate($template);
    $pdf->Image('picapau.png', 186, 170, 22);
  }
}

$pdf->Output();
