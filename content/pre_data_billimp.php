<?php

session_save_path("../session/");session_start(); 
include '../header2.php';include '../plugins/funcDateThai.php';
?>
<div class="row">
          <div class="col-lg-12">
                <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">
                      <img src='../images/Document_Upload.ico' width='25'> 
                     ข้อมูล BILLDISP ที่ได้รับการนำเข้าแล้ว</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php
                    function __autoload($class_name) {
    include '../class/'.strtolower($class_name).'.php';
}
$conn_DB= new TablePDO();
$read="../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->conn_PDO();
                    $sql="SELECT SUBSTR(prescription_date,1,10) AS prescription_date 
                            FROM billdisp 
                            GROUP BY SUBSTR(prescription_date,1,10) 
                            ORDER BY SUBSTR(prescription_date,1,10) DESC";
                    $conn_DB->imp_sql($sql);
        $conn_DB->select();
$column=array("วันที่");
$conn_DB->imp_columm($column);  
$conn_DB->createPDO_TB();
                    ?>
                </div>
                </div>
          </div>
</div>
 <?php include '../footer2.php';?>
