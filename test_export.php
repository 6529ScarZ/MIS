<?php session_start(); 
include 'class/TablePDO.php';
include 'class/Export.php';?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf8">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" /> 
         </head>

         <body>
             ทดสอบการ export
<?php
//function __autoload($class_name) {
    //include 'class/'.$class_name.'.php';
//}
set_time_limit(0);
$conn_DB= new EnDeCode();
$read="connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->conn_PDO();
/*$sql="select * from emppersonal";*/
$sql="SELECT * from billdisp order by prescription_date
";
$query1=$conn_DB->query($sql);
$sql2="select * from billdisp_item
";
/*$sql2="select * from department";*/
$query2=$conn_DB->query($sql2);
$filName="file_export/BILLDISP";
$symbol="|";
$export= new Export($filName, $symbol, $query1, $query2);
$export->Export_TXT_billdisp();
?>
         </body>
</html>