<?php session_start(); 
//require_once 'class/TablePDO.php';
function __autoload($class_name) {
    include 'class/'.strtolower($class_name).'.php';
}
set_time_limit(0);
$conn_DB= new TablePDO();
$read="connection/conn_DB.txt";
$conn_DB->para_read($read);
$db=$conn_DB->conn_PDO();
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