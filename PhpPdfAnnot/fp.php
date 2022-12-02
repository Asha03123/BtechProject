<?Php
include 'vendor/autoload.php';
require('fpdf.php');
use setasign\Fpdi\Fpdi;
$file = 'ger.pdf'; 
$pdf = new Fpdi(); 
if(file_exists("./".$file)){ 
    $pagecount = $pdf->setSourceFile($file); 
}else{ 
    die('Source PDF not found!'); 
} 

for($i=1;$i<=$pagecount;$i++){ 
    $tpl = $pdf->importPage($i); 
    $size = $pdf->getTemplateSize($tpl); 
    $pdf->addPage(); 
    $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], TRUE); 
     
$width=$pdf->GetPageWidth(); // Width of Current Page
$height=$pdf->GetPageHeight(); // Height of Current Page

$pdf->Line(0, $height/2,$width,$height/2);
$pdf->Line(0, 3*$height/2,$width,$height/2);

$pdf->SetFont('Helvetica');
$pdf->SetFontSize(20);
$pdf->SetTextColor(250, 150,0);
$pdf->SetXY(20, $height-70);
$pdf->Write(0, 'Text can be inserted over PDF using FPDF/FPDI');
} 

$pdf->Output('F','outp.pdf');
?>
