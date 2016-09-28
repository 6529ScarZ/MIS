<?php session_start(); 
include '../class/TablePDO.php';
include '../class/Export.php';?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf8">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" /> 
         </head>

         <body>
             ทดสอบการ import
<?php
//function __autoload($class_name) {
    //include 'class/'.$class_name.'.php';
//}
set_time_limit(0);
$conn_DB= new EnDeCode();
$read="../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->conn_PDO();

$billdisp=$_POST['billdisp'];
$billdisp_item=$_POST['billdisp_item'];
echo $billdisp[0]."<br>";
echo "<pre>".print_r($billdisp,TRUE)."</pre>";
?>