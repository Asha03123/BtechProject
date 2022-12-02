 

Let’s take a look with the GET or POST methods, as most developers use POST method due to privacy issues, the following example is based on POST method only: 

Program 2: This program uses isset() function to call PHP function. 

<!DOCTYPE html>
<html>
     
<head>
    <title>
        How to call PHP function
        on the click of a Button ?
    </title>
</head>
 
<body style="text-align:center;">
     
    <h1 style="color:green;">
        GeeksforGeeks
    </h1>
     
    <h4>
        How to call PHP function
        on the click of a Button ?
    </h4>
 
    <?php
             include 'vendor/autoload.php';
require('fpdf.php');
use setasign\Fpdi\Fpdi;
$file = 'par.pdf'; 
$pdf = new Fpdi(); 
if(file_exists("./".$file)){ 
    $pagecount = $pdf->setSourceFile($file); 
}else{ 
    die('Source PDF not found!'); 
} 


        if(isset($_POST['button1'])) {
for($i=1;$i<=$pagecount;$i++){ 
    $tpl = $pdf->importPage($i); 
    $size = $pdf->getTemplateSize($tpl); 
    $pdf->addPage(); 
    $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], TRUE); 
     
$width=$pdf->GetPageWidth(); // Width of Current Page
$height=$pdf->GetPageHeight(); // Height of Current Page

$pdf->Line(0, 0,$width,$height); // Line one Cross
$pdf->Line($width, 0,0,$height); // Line two Cross

} 

  $pdf->Output();         
        }
        if(isset($_POST['button2'])) {
            echo "This is Button2 that is selected";
        }
    ?>
     
    <form method="post">
        <input type="submit" name="button1"
                value="Button1"/>
         
        <input type="submit" name="button2"
                value="Button2"/>
    </form>
</head>
 
</html>
