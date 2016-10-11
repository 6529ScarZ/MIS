<?php include '../header2.php';
if(null !== (filter_input(INPUT_GET, 'method'))){
    $method=filter_input(INPUT_GET, 'method');
}
if (isset($method) and $method == 'imp') {
?>
<form class="" role="form" action='../process/prcimp_billtran.php' enctype="multipart/form-data" method='post'>
<?php }elseif ($method == 'exp') {?>
<form class="" role="form" action='../process/prcexp_billtran.php' enctype="multipart/form-data" method='post'>   
    <input type="hidden" name="method" value="exp">
<?php }elseif ($method == 'upd') {?>
<form class="" role="form" action='../process/prcimp_billtran.php' enctype="multipart/form-data" method='post'>
    <input type="hidden" name="method" value="upd">
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
<div class="col-lg-2 col-xs-6"> 
                <label>วันเริ่มต้น &nbsp;</label>
                <p><input name="st_date" type="text" id="datepicker"  placeholder='รูปแบบ 22/07/2557' class="form-control" required></p>
                </div>
<div class="col-lg-2 col-xs-6"> 
                <label>วันสิ้นสุด &nbsp;</label>
                <p><input name="en_date" type="text" id="datepicker2"  placeholder='รูปแบบ 22/07/2557' class="form-control" required></p>
                </div>
<div class="col-lg-2 col-xs-12" align="center">
    <?php if (isset($method) and $method == 'imp') {$val='นำเข้า';}elseif($method =='upd'){$val='Update';}else{$val='ส่งออก';}?>
    <input type="submit" class="btn btn-success" value="<?= $val?>">
</div>
                </div>
                </div>
          </div>
</div></form>
    <?php //include '../footer2.php';?>