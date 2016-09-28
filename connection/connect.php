<?php
require 'class/read_conn.php';
require 'class/conn_db.php';
$connDB=new read_conn();
$read="connection/conn_DB.txt";
$connDB->para_read($read);
$dbh=$connDB->Read_Text();
////////////connect database
$connDBi=new Conn_DB($dbh);
$db=$connDBi->conn_mysqli();
                
/*require 'class/conn_db.php';
$my_conn = new Conn_DB();
$my_conn->read="../connection/conn_DB.txt";
$db=$my_conn->conn_mysqli();
$dbh=$my_conn->conn_POD();
$reader=$my_conn->config();
print_r($reader);*/
?>
