<?php include '../header2.php';
if(null !== (filter_input(INPUT_GET, 'method'))){
    $method=filter_input(INPUT_GET, 'method');
}
if (isset($method) and $method == 'imp') {
?>
<form class="" role="form" action='../process/prcimp_bill.php' enctype="multipart/form-data" method='post'>
<?php }elseif ($method == 'exp') {?>
<form class="" role="form" action='../process/prcexp_bill.php' enctype="multipart/form-data" method='post'>   
    <input type="hidden" name="method" value="exp">
<?php }?>
<div class="row">
          <div class="col-lg-12">
                <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='images/phonebook.ico' width='25'> นำเข้าข้อมูล BILL</h3>
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
    <input type="submit" class="btn btn-success" value="นำเข้า">
</div>
                </div>
                </div>
          </div>
</div></form>
    <?php //include '../footer2.php';?>
