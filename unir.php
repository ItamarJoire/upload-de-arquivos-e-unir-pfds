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

class pdf extends FPDI
{
    function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial','I',12);
        // Print centered page number
        $this->Cell(0,10,''.$this->PageNo(),0,0,'R');
    }
}

$pdf = new pdf();
 
foreach ($files as $file) {
  $pageCount = $pdf->setSourceFile($file);

  for ($pagNo = 1; $pagNo <= $pageCount; $pagNo++) {
    $template = $pdf->importPage($pagNo);
    $size = $pdf->getTemplateSize($template);
    $pdf->AddPage($size['orientation'], $size);
    $pdf->useTemplate($template);
    $pdf->Image('selo.png', 190, 180, 16);
  }
} 

$pdf->Output();
