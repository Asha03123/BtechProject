<!DOCTYPE html>
<html>
<body>

<h1>My first PHP page</h1>

<?php
include 'vendor/autoload.php';
use setasign\Fpdi\Fpdi;
// Source file and watermark config 
$file = 'new.pdf'; 
$text_image = 'tick2.png'; 
 
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
    //$xxx_final = ($size['width']-25); 
    //$yyy_final = ($size['height']-65); 
    
    $xxx_final = (100); 
    $yyy_final = (100); 
    $pdf->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png'); 
} 
 
// Output PDF with watermark 
$pdf->Output();


?>

</body>
</html>
