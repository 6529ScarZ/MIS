<?php 
session_save_path("../session/");
session_start(); 
include '../header2.php';include '../plugins/funcDateThai.php';
if(null !== (filter_input(INPUT_GET, 'method'))){
    $method=filter_input(INPUT_GET, 'method');
}elseif(null !== (filter_input(INPUT_POST, 'method'))){
    $method=filter_input(INPUT_POST, 'method');
}


if (isset($method) and $method != 'show') {
if (isset($method) and $method == 'imp') {
?>
<form class="" role="form" action='../process/prcimp_bill.php' enctype="multipart/form-data" method='post'>
<?php }elseif ($method == 'exp') {?>
    <form class="" role="form" action='select_date_billimp.php' enctype="multipart/form-data" method='post'>   
    <input type="hidden" name="method" value="show">
<?php }elseif ($method == 'upd') {?>
    <form class="" role="form" action='../process/prcimp_bill.php' enctype="multipart/form-data" method='post'>
        <input type="hidden" name="method" value="upd">
<?php }elseif ($method == 'exp_total') {?>
    <form class="" role="form" action='../process/prcexp_bill.php' enctype="multipart/form-data" method='post'>   
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
                     <?php if (isset($method) and $method == 'imp') {?>นำเข้าข้อมูล BILLDISP<?php }elseif($method =='upd'){?>Update ข้อมูล BILLDISP<?php }else{?>ส่งออกข้อมูล BILLDISP<?php }?></h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
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
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="select_date_billimp.php?method=exp"><img src="../images/icon_set1/direction_left.ico" width="25"><img src="../images/icon_set1/direction_left.ico" width="25"><img src="../images/icon_set1/direction_left.ico" width="25"></a>
            <br>
                <?php    if(!empty($_POST['check_ps'])){
$check_ps=$_POST['check_ps'];

foreach ($check_ps as $key => $value) {
        $id[$key] = $_POST['id'][$value];
        $dispenseID[$value] = $_POST['1dispenseID'][$value];
        $_SESSION['id'][] = $id[$key];
        $_SESSION['dispenseID'][] = "'$dispenseID[$value]'";
        
}
}

?>
      
    <!--<form name="form2" class="" role="form" action='../process/prcexp_bill.php' enctype="multipart/form-data" method='post'>-->
        
            <?php
            if(!empty($_POST['check_ps']) or !empty($_SESSION['dispenseID'])){
            echo 'dispenseID : ';
        foreach ($_SESSION['dispenseID'] as $key => $value) {    
            echo $value." ,";}}
function __autoload($class_name) {
    include '../class/'.strtolower($class_name).'.php';
}
if(!empty($_POST['st_date'])){
$take_date_conv1 = $_POST['st_date'];
}elseif (!empty($_GET['st_date'])) {
$take_date_conv1 = $_GET['st_date'];        
    }
$st_date=insert_date($take_date_conv1);
if(!empty($_POST['en_date'])){
$take_date_conv2 = $_POST['en_date'];
}elseif (!empty($_GET['en_date'])) {
$take_date_conv2 = $_GET['en_date'];        
    }
$en_date=insert_date($take_date_conv2);
if(isset($_POST['check'])){$check=$_POST['check'];}else{$check=null;}
$conn_DB= new TablePDO();
$read="../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->conn_PDO();
/////////////////////////////สร้างฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
function page_navigator($before_p,$plus_p,$total,$total_p,$chk_page){   
	global $e_page;
	global $querystr;
        if(null !== (filter_input(INPUT_GET, 'method'))){
    $method=filter_input(INPUT_GET, 'method');
}elseif(null !== (filter_input(INPUT_POST, 'method'))){
    $method=filter_input(INPUT_POST, 'method');
}
        if(!empty($_POST['st_date'])){
$take_date_conv1 = $_POST['st_date'];
}elseif (!empty($_GET['st_date'])) {
$take_date_conv1 = $_GET['st_date'];        
    }
$st_date=insert_date($take_date_conv1);
if(!empty($_POST['en_date'])){
$take_date_conv2 = $_POST['en_date'];
}elseif (!empty($_GET['en_date'])) {
$take_date_conv2 = $_GET['en_date'];        
    }
$en_date=insert_date($take_date_conv2);
	$urlfile=""; // ส่วนของไฟล์เรียกใช้งาน ด้วย ajax (ajax_dat.php)
	$per_page=100;
	$num_per_page=floor($chk_page/$per_page);
	$total_end_p=($num_per_page+1)*$per_page;
	$total_start_p=$total_end_p-$per_page;
	$pPrev=$chk_page-1;
	$pPrev=($pPrev>=0)?$pPrev:0;
	$pNext=$chk_page+1;
	$pNext=($pNext>=$total_p)?$total_p-1:$pNext;		
	$lt_page=$total_p-4;
	if($chk_page>0){  
		echo "<a  href='$urlfile?s_page=$pPrev".$querystr."&st_date=".$take_date_conv1."&en_date=".$take_date_conv2."&method=$method' class='naviPN'><< Prev</a>";
	}
	for($i=$total_start_p;$i<$total_end_p;$i++){  
		$nClass=($chk_page==$i)?"class='selectPage'":"";
		if($e_page*$i<=$total){
		echo "<a href='$urlfile?s_page=$i".$querystr."&st_date=".$take_date_conv1."&en_date=".$take_date_conv2."&method=$method' $nClass  >".intval($i+1)."</a> ";   
		}
	}		
	if($chk_page<$total_p-1){
		echo "<a href='$urlfile?s_page=$pNext".$querystr."&st_date=".$take_date_conv1."&en_date=".$take_date_conv2."&method=$method'  class='naviPN'>Next >></a>";
	}
}
/////////////////////////////
?>
        <form name="form2" class="" role="form" action='' enctype="multipart/form-data" method='post'>
        <input type="hidden" name="method" value="show">
        <input type="hidden" name="st_date" value="<?= $take_date_conv1?>">
        <input type="hidden" name="en_date" value="<?= $take_date_conv2?>">
        <div align="center"><input class="btn btn-primary" type="submit" value="เลือกข้อมูล"></div>
        <?php
echo "<div align='center'><h4>".DateThai2($st_date)." ถึง ".DateThai2($en_date)."</h4></div>";
        $sql="SELECT dispenseID,invoice_no,hn,prescription_date,charg_amount,claim_amount,billdisp_id
FROM billdisp
WHERE SUBSTR(prescription_date,1,10) BETWEEN '$st_date' AND '$en_date'";
        $conn_DB->imp_sql($sql);
        $num=$conn_DB->query();
        $total=$num->rowcount();
    ////////////////////////    
$e_page=100; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
if(empty($_GET['s_page'])){   
	$_GET['s_page']=0; 
        $chk_page=$_GET['s_page']; 
}else{   
	$chk_page=$_GET['s_page'];     
	$_GET['s_page']=$_GET['s_page']*$e_page;   
}   
$sql.=" LIMIT ".$_GET['s_page'].",$e_page";
$qr=$conn_DB->query();
if($qr->rowcount()>=1){   
	$plus_p=($chk_page*$e_page)+$qr->rowcount();   
}else{   
	$plus_p=($chk_page*$e_page);       
}   
$total_p=ceil($total/$e_page);   
$before_p=($chk_page*$e_page)+1;  
    //////////////////////////////////   
        $conn_DB->imp_sql($sql);
        $conn_DB->select();
$column=array("dispenseID","invoice_no","hn","prescription_date","charg_amount","claim_amount","check");
$conn_DB->imp_columm($column);  
$conn_DB->createPDO_TB_Check($check,$chk_page,$e_page);
if($total>0){
?>
<div class="browse_page">
 
 <?php   
 // เรียกใช้งานฟังก์ชั่น สำหรับแสดงการแบ่งหน้า   
  page_navigator($before_p,$plus_p,$total,$total_p,$chk_page);    

  echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size='2'>มีจำนวนทั้งหมด  <B>$total รายการ</B> จำนวนหน้าทั้งหมด ";
  echo  $count=ceil($total/100)."&nbsp;<B>หน้า</B></font>" ;
}
        ?>
    </form>
    <?php if(isset($_SESSION['id'])){?>
    <form name="form3" class="" role="form" action='../process/prcexp_bill2.php' enctype="multipart/form-data" method='post'>
        <input type="hidden" name="method" value="exp_select">
        <div align="center"><input class="btn btn-success" type="submit" value="ส่งออก"></div> 
    </form><?php }?>
 <?php } include '../footer2.php';?>
