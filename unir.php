<?php
$host = "localhost";
$db = "upload";
$user = "root";
$pass = "";

$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

$files = $conn->query("SELECT nome_do_arquivo FROM tb_arquivos")->fetchAll(PDO::FETCH_COLUMN);

use \setasign\Fpdi\Fpdi;

require 'fpdf/fpdf.php';
require 'fpdi/src/autoload.php';

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
