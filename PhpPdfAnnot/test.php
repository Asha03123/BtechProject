<?php 
include 'vendor/autoload.php';
use setasign\Fpdi\Fpdi;

// Source file and watermark config 
$file = 'par.pdf'; 
$text_image = 'plugone.png'; 
 
// Set source PDF file 
$pdf = new Fpdi(); 
if(file_exists("./".$file)){ 
    $pagecount = $pdf->setSourceFile($file); 
}else{ 
    die('Source PDF not found!'); 
} 
 
// Add watermark image to PDF pages 
for($i=1;$i<=$pagecount;$i++){ 
    $tpl = $pdf->importPage($i); 
    $size = $pdf->getTemplateSize($tpl); 
    $pdf->addPage(); 
    $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], TRUE); 
     
    //Put the watermark 
    $xxx_final = ($size['width']-60); 
    $yyy_final = ($size['height']-25); 
    $pdf->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png'); 
} 
 
// Output PDF with watermark 
$pdf->Output('F', 'mynt.pdf');
