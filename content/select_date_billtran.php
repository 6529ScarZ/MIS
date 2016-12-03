<?php session_start();  
include '../header2.php';include '../plugins/funcDateThai.php';
if(null !== (filter_input(INPUT_GET, 'method'))){
    $method=filter_input(INPUT_GET, 'method');
}elseif(null !== (filter_input(INPUT_POST, 'method'))){
    $method=filter_input(INPUT_POST, 'method');
}


if (isset($method) and $method != 'show') {
if (isset($method) and $method == 'imp') {
?>
<form class="" role="form" action='../process/prcimp_billtran.php' enctype="multipart/form-data" method='post'>
<?php }elseif ($method == 'exp') {?>
    <form class="" role="form" action='select_date_billtran.php' enctype="multipart/form-data" method='post'>   
    <input type="hidden" name="method" value="show">
<?php }elseif ($method == 'upd') {?>
<form class="" role="form" action='../process/prcimp_billtran.php' enctype="multipart/form-data" method='post'>
    <input type="hidden" name="method" value="upd">
    <?php }elseif ($method == 'exp_total') {?>
    <form class="" role="form" action='../process/prcexp_billtran.php' enctype="multipart/form-data" method='post'>   
    <input type="hidden" name="method" value="exp_total">
<?php }?>
<div class="row">
          <div class="col-lg-12">
                <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">
                      <?php if (isset($method) and $method == 'exp'){?>
                      <img src='../images/Document_Upload.ico' width='25'> 
                      <?php }else{?>
                      <img src='../images/Import.ico' width='25'> 
                      <?php }?>
                     <?php if (isset($method) and $method == 'imp') {?>นำเข้าข้อมูล BILLTRAN<?php }elseif($method =='upd'){?>Update ข้อมูล BILLTRAN<?php }else{?>ส่งออกข้อมูล BILLTRAN<?php }?></h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="col-lg-12" style="color: red"><b>** ไม่ควรเลือกช่วงเวลาเกิน15วัน</b></div>
<div class="col-lg-2 col-xs-6"> 
                <label>วันเริ่มต้น &nbsp;</label>
                <p><input name="st_date" type="text" id="datepicker"  placeholder='รูปแบบ 22/07/2557' class="form-control" required></p>
                </div>
<div class="col-lg-2 col-xs-6"> 
                <label>วันสิ้นสุด &nbsp;</label>
                <p><input name="en_date" type="text" id="datepicker2"  placeholder='รูปแบบ 22/07/2557' class="form-control" required></p>
                </div>
                    <?php if (isset($method) and $method == 'exp') {?>
                    <div class="col-lg-2 col-xs-12">
    <input type="checkbox" name="check" class="icheckbox_flat-green" value="checked"> ส่งออกทั้งหมด
</div><?php }?>
<div class="col-lg-2 col-xs-12" align="center">
    <?php if (isset($method) and $method == 'imp') {$val='นำเข้า';}elseif($method =='upd'){$val='Update';}elseif($method =='exp_total'){$val='ส่งออก';}else{$val='แสดง';}?>
    <input type="submit" class="btn btn-success" value="<?= $val?>">
</div>
                </div>
                </div>
          </div>
</div></form>
<?php  }elseif (isset($method) and $method == 'show') {?>
          &nbsp;&nbsp;&nbsp;&nbsp;<a href="select_date_billtran.php?method=exp"><img src="../images/icon_set1/direction_left.ico" width="25"><img src="../images/icon_set1/direction_left.ico" width="25"><img src="../images/icon_set1/direction_left.ico" width="25"></a>
          <br>  
 <?php   if(!empty($_POST['check_ps'])){
$check_ps=$_POST['check_ps'];

foreach ($check_ps as $key => $value) {
        $id[$key] = $_POST['id'][$value];
        $InvNo[$value] = $_POST['1InvNo'][$value];
        $_SESSION['id'][] = $id[$key];
        $_SESSION['InvNo'][] = "'$InvNo[$value]'";
}
}

    
?>
    
    <!--<form name="form2" class="" role="form" action='../process/prcexp_billtran2.php' enctype="multipart/form-data" method='post'>-->
        <form name="form2" class="" role="form" action='' enctype="multipart/form-data" method='post'>
        <input type="hidden" name="method" value="show">
        <input type="hidden" name="st_date" value="<?= $_POST['st_date']?>">
        <input type="hidden" name="en_date" value="<?= $_POST['en_date']?>">
        <div align="center"><input class="btn btn-primary" type="submit" value="เลือกข้อมูล"></div>
            <?php
            if(!empty($_POST['check_ps']) or !empty($_SESSION['InvNo'])){
            echo 'InvNo : ';
            foreach ($_SESSION['InvNo'] as $key => $value) {    
            echo $value." ,";}}
function __autoload($class_name) {
    include '../class/'.strtolower($class_name).'.php';
}
$take_date_conv = $_POST['st_date'];
$st_date=insert_date($take_date_conv);
$take_date_conv = $_POST['en_date'];
$en_date=insert_date($take_date_conv);
$limit="limit 0,165";
if(isset($_POST['check'])){$check=$_POST['check'];}else{$check=null;}
$conn_DB= new TablePDO();
$read="../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->conn_PDO();
echo "<div align='center'><h4>".DateThai2($st_date)." ถึง ".DateThai2($en_date)."</h4></div>";
        $sql="SELECT HN,InvNo,DTTran,Amount,billtran_id
FROM billtran
WHERE SUBSTR(DTTran,1,10) BETWEEN '$st_date' AND '$en_date' $limit";
        $conn_DB->imp_sql($sql);
        $conn_DB->select();
$column=array("HN","invoice_no","DTTran","Amount","check");
$conn_DB->imp_columm($column);  
$conn_DB->createPDO_TB_Check2($check);

        ?>

    </form>
    <form name="form-" class="" role="form" action='../process/prcexp_billtran2.php' enctype="multipart/form-data" method='post'>
        <input type="hidden" name="method" value="exp_select">
        <div align="center"><input class="btn btn-success" type="submit" value="ส่งออก"></div> 
    </form>
 <?php } include '../footer2.php';?>
