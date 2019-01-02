<?php
//echo $_GET['file'];
$str = $_GET['file'];

$file = explode('journal/',$str);

//header('Content-disposition: inline');
//header('Content-type: application/msword'); // not sure if this is the correct MIME type
//readfile($_GET["file"]);
//header("Content-Type: application/octet-stream");
//exit();
//$file = $_GET["file"] .".pdf";
header("Content-Disposition: attachment; filename=" . urlencode($file));   
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Description: File Transfer");            
header("Content-Length: " . filesize($file));
flush(); // this doesn't really matter.
$fp = fopen($file, "r");
while (!feof($fp))
{
    echo fread($fp, 65536);
    flush(); // this is essential for large downloads
} 
fclose($fp); 
?>
