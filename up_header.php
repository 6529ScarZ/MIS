<?php 
session_save_path("./session/");
session_start(); 
//require_once 'class/TablePDO.php';
function __autoload($class_name) {
    include 'class/'.strtolower($class_name).'.php';
}
set_time_limit(0);
$conn_DB= new TablePDO();
$read="connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_db=$conn_DB->Read_Text();
$dbconfig["hostname"]= trim($conn_db[0]) ;
$db=$conn_DB->conn_PDO();

$conn_HosDB= new TablePDO();
$read_Hos="connection/conn_DBHosxp.txt";
$conn_HosDB->para_read($read_Hos);
$conn_Hosdb=$conn_HosDB->Read_Text();
        $dbHosconfig["hostname"]= trim($conn_Hosdb[0]) ;
if($db != FALSE){
//$db=$conn_DB->getDb();
//===ชื่อกลุ่ม
                    $sql = "select * from  hospital order by hospital limit 1";
                    $conn_DB->imp_sql($sql);
                    $resultComm=$conn_DB->select_a();
                    if (!empty($resultComm['logo'])) {
                                    $pic = $resultComm['logo'];
                                    $fol = "logo/";
                                } else {
                                    $pic = 'agency.ico';
                                    $fol = "images/";
                                }
}else {
                                    $pic = 'agency.ico';
                                    $fol = "images/";
                                }
                    ?>