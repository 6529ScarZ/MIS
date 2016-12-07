<?php session_start(); 
include '../header2.php';include '../plugins/funcDateThai.php';
if(null !== (filter_input(INPUT_GET, 'method'))){
    $method=filter_input(INPUT_GET, 'method');
}elseif(null !== (filter_input(INPUT_POST, 'method'))){
    $method=filter_input(INPUT_POST, 'method');
}
if (isset($method) and $method == 'imp') {
?>
<form class="" role="form" action='../process/prcimp_opd.php' enctype="multipart/form-data" method='post'>
    <input type="hidden" name="method" value="imp">
<?php }elseif ($method == 'upd') {?>
    <form class="" role="form" action='../process/prcimp_opd.php' enctype="multipart/form-data" method='post'>
        <input type="hidden" name="method" value="upd">
<?php }?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><img src='../images/Import.ico' width='25'> 
                     <?php if (isset($method) and $method == 'imp') {?>นำเข้าข้อมูล OPD<?php }elseif($method =='upd'){?>Update ข้อมูล OPD<?php }?></h3>
            </div>
            <div class="panel-body"><div class="col-lg-12">
                            <div class="form-group" align="right"> 
                                    
                                    <div class="col-lg-2 col-xs-6">
                                        <label> ระบุเดือน-ปี : </label>
                                        <select name="txt_month" class="form-control">
                                            <option value="">--------------</option>
                                            <?php
                                            $month = array('01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน',
                                                '05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม',
                                                '09' => 'กันยายน ', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม');
                                            $txtMonth = isset($_POST['txt_month']) && $_POST['txt_month'] != '' ? $_POST['txt_month'] : date('m');
                                            foreach ($month as $i => $mName) {
                                                $selected = '';
                                                if ($txtMonth == $i)
                                                    $selected = 'selected="selected"';
                                                echo '<option value="' . $i . '" ' . $selected . '>' . $mName . '</option>' . "\n";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-xs-6"> <label>&nbsp;</label>
                                        <select name="txt_year" class="form-control">
                                            <option value="">--------------</option>
                                            <?php
                                            $txtYear = (isset($_POST['txt_year']) && $_POST['txt_year'] != '') ? $_POST['txt_year'] : date('Y');

                                            $yearStart = date('Y');
                                            $yearEnd = $txtYear - 5;

                                            for ($year = $yearStart; $year > $yearEnd; $year--) {
                                                $selected = '';
                                                if ($txtYear == $year)
                                                    $selected = 'selected="selected"';
                                                echo '<option value="' . $year . '" ' . $selected . '>' . ($year + 543) . '</option>' . "\n";
                                            }
                                            ?>
                                        </select>
                                    </div><p>&nbsp;</p>
                                    <div class="col-lg-12 col-xs-12">
                                    <input type="submit" class="btn btn-success" value="ตกลง" />
                                    </div>
                               </div>
                    </div></div></div></div></div>
 </form>
 <?php include '../footer2.php';?>
