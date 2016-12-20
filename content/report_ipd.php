<?php
$conn_DB= new TablePDO();
$read="connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_db=$conn_DB->Read_Text();
$conn_DB->conn_PDO();
?>
<div class="row">
             <?php
                        include_once ('plugins/funcDateThai.php');
                        include 'plugins/function_date.php';
                        
                        $report=(null !== filter_input(INPUT_GET, 'report')? filter_input(INPUT_GET, 'report'):'');
                        $d_start = 01;
                        $m_start = 01;
                        $d = date("d");
                        if (empty($_POST['year'])) {
                            
                            if($date >= $bdate and $date <= $edate){
                             $y= $Yy;
                             $Y= date("Y");
                            }else{
                            $y = date("Y");
                            $Y = date("Y") - 1;
                            }
                        } else {
                            $y = $_POST['year'] - 543;
                            $Y = $y - 1;
                        }
                        $date_start = "$Y-10-01";
                        $date_end = "$y-09-30";
                        
                     if (empty($_POST['year'])) {
                        
                            if($date >= $bdate and $date <= $edate){
                          $year = $Yy;
                        $years = $year + 543;      
                            }else{
                        $year = date('Y');
                        $years = $year + 543;
                            }
                    } else {
                        $year = $_POST['year'] - 543;
                        $years = $year + 543;
                    }

                    $month_start = "$Y-10";
                    $month_end = "$y-09";
                    $ward = '';                  
                    $ward[].='ชาย1';
                    $ward[].='ชาย2';
                    $ward[].='หญิง';
                    $adch='';
                    $adch[].='admit ชาย1';
                    $adch[].='admit ชาย2';
                    $adch[].='admit หญิง';
                    $adch[].='discharge ชาย1';
                    $adch[].='discharge ชาย2';
                    $adch[].='discharge หญิง';
                    $adch_sex='';
                    $adch_sex[].='admit ชาย';
                    $adch_sex[].='admit หญิง';
                    $adch_sex[].='discharge ชาย';
                    $adch_sex[].='discharge หญิง';
                    $stack='';
                    $stack[].='admit';$stack[].='admit';$stack[].='admit';
                    $stack[].='discharge';$stack[].='discharge';$stack[].='discharge';
                    $stack_sex='';
                    $stack_sex[].='admit';$stack_sex[].='admit';
                    $stack_sex[].='discharge';$stack_sex[].='discharge';
                    $I = 10;
                    $countnum[]='';
                    $rs[]='';
                    $rs2[]='';
                    $name='';
                    for ($i = -2; $i <= 9; $i++) {
                        
                        $sql="select * from month where m_id='$i'";
                        $conn_DB->imp_sql($sql);
                        $month = $conn_DB->select();
//////////////////////////เตรียมเดือน
                       if ($i <= 0) {
                            $month_sel  = "$Y-$I";
                       } elseif ($i >= 1 and $i <= 9) {
                            $month_sel  = "$year-0$i";
                        } else {
                            $month_sel  = "$year-$i";
                        }
                        if($report=='ipd_stable'){
                        //////////////ipd stable
                        for ($c = 0; $c < count($ward); $c++) {
                            $iii=0;
                        $sql  = "select ROUND(AVG(stable_m1)) avg_stable_m1 from ipd_report_stable   
						 where  admdate like '$month_sel%' order by ipd_st_id";
                        $conn_DB->imp_sql($sql);
                        $rs = $conn_DB->select();
                       @$countnum3[$iii].= isset($rs[$c]['avg_stable_m1']) ? $rs[$c]['avg_stable_m1']. ',' :'';
                       $iii++;
                        $sql2  = "select ROUND(AVG(stable_m2)) avg_stable_m2 from ipd_report_stable   
						 where  admdate like '$month_sel%' order by ipd_st_id";
                        $conn_DB->imp_sql($sql2);
                        $rs2 = $conn_DB->select();
                       @$countnum3[$iii].= isset($rs2[$c]['avg_stable_m2']) ? $rs2[$c]['avg_stable_m2']. ',' :'';
                       $iii++;
                       $sql3  = "select ROUND(AVG(stable_w)) avg_stable_w from ipd_report_stable   
						 where  admdate like '$month_sel%' order by ipd_st_id";
                        $conn_DB->imp_sql($sql3);
                        $rs3 = $conn_DB->select();
                       @$countnum3[$iii].= isset($rs3[$c]['avg_stable_w']) ? $rs3[$c]['avg_stable_w']. ',' :'';
                        }
                        }elseif ($report=='ipd_adchward') {
                        //////////////admit & discharge แยกตึก
                        for ($c = 0; $c < count($adch); $c++) {
                          $iii=0;
                          $sql4  = "select sum(admit_m1) admit_m1 from ipd_report_stable   
						 where  admdate like '$month_sel%' order by ipd_st_id";
                        $conn_DB->imp_sql($sql4);
                        $rs = $conn_DB->select();
                       @$countnum4[$iii].= isset($rs[$c]['admit_m1']) ? $rs[$c]['admit_m1']. ',' :'';
                       $iii++;
                       $sql5  = "select sum(admit_m2) admit_m2 from ipd_report_stable   
						 where  admdate like '$month_sel%' order by ipd_st_id";
                        $conn_DB->imp_sql($sql5);
                        $rs = $conn_DB->select();
                       @$countnum4[$iii].= isset($rs[$c]['admit_m2']) ? $rs[$c]['admit_m2']. ',' :'';
                       $iii++;
                       $sql6  = "select sum(admit_w) admit_w from ipd_report_stable   
						 where  admdate like '$month_sel%' order by ipd_st_id";
                        $conn_DB->imp_sql($sql6);
                        $rs = $conn_DB->select();
                       @$countnum4[$iii].= isset($rs[$c]['admit_w']) ? $rs[$c]['admit_w']. ',' :'';
                       $iii++;
                       $sql7  = "select sum(dch_m1) dch_m1 from ipd_report_stable   
						 where  admdate like '$month_sel%' order by ipd_st_id";
                        $conn_DB->imp_sql($sql7);
                        $rs = $conn_DB->select();
                       @$countnum4[$iii].= isset($rs[$c]['dch_m1']) ? $rs[$c]['dch_m1']. ',' :'';
                       $iii++;
                       $sql8  = "select sum(dch_m2) dch_m2 from ipd_report_stable   
						 where  admdate like '$month_sel%' order by ipd_st_id";
                        $conn_DB->imp_sql($sql8);
                        $rs = $conn_DB->select();
                       @$countnum4[$iii].= isset($rs[$c]['dch_m2']) ? $rs[$c]['dch_m2']. ',' :'';
                       $iii++;
                       $sql9  = "select sum(dch_w) dch_w from ipd_report_stable   
						 where  admdate like '$month_sel%' order by ipd_st_id";
                        $conn_DB->imp_sql($sql9);
                        $rs = $conn_DB->select();
                       @$countnum4[$iii].= isset($rs[$c]['dch_w']) ? $rs[$c]['dch_w']. ',' :'';
                        }
                        }elseif ($report=='ipd_adchsex') {
                        //////////////admit & discharge แยกเพศ
                        for ($c = 0; $c < count($adch_sex); $c++) {
                          $iii=0;
                          $sql10  = "select sum(admit_m) admit_m from ipd_report_sex   
						 where  admdate like '$month_sel%' order by ipd_sex_id";
                        $conn_DB->imp_sql($sql10);
                        $rs = $conn_DB->select();
                       @$countnum5[$iii].= isset($rs[$c]['admit_m']) ? $rs[$c]['admit_m']. ',' :'';
                       $iii++;
                       $sql11  = "select sum(admit_w) admit_w from ipd_report_sex   
						 where  admdate like '$month_sel%' order by ipd_sex_id";
                        $conn_DB->imp_sql($sql11);
                        $rs = $conn_DB->select();
                       @$countnum5[$iii].= isset($rs[$c]['admit_w']) ? $rs[$c]['admit_w']. ',' :'';
                       $iii++;
                       $sql12  = "select sum(dch_m) dch_m from ipd_report_sex  
						 where  admdate like '$month_sel%' order by ipd_sex_id";
                        $conn_DB->imp_sql($sql12);
                        $rs = $conn_DB->select();
                       @$countnum5[$iii].= isset($rs[$c]['dch_m']) ? $rs[$c]['dch_m']. ',' :'';
                       $iii++;
                       $sql13  = "select sum(dch_w) dch_w from ipd_report_sex   
						 where  admdate like '$month_sel%' order by ipd_sex_id";
                        $conn_DB->imp_sql($sql13);
                        $rs = $conn_DB->select();
                       @$countnum5[$iii].= isset($rs[$c]['dch_w']) ? $rs[$c]['dch_w']. ',' :'';
                        }
                        }
                        
                        $name.=isset($month[0]['month_short']) ? "'".$month[0]['month_short']."'" . ',':'';
                        $I++;
                    }
                    ///////////////////การใช้งาน class Charts 
                        $daimention='2';
                        $categories=$name;
                        $charts=new Charts();
                        if($report=='ipd_stable'){
                        $charts4=new Charts();
                        $container4='chart4';
                        $type4='column';
                        $title4='คงพยาบาลในปีงบประมาณ';
                        $subtitle4='แยกตึก';
                        $unit4 ='คน (เฉลี่ย/เดือน)';
                        $name4 =$ward; 
                        $data4 =$countnum3;
                        $charts4->Columnstacking3D($daimention,$container4, $type4, $title4, $unit4, $categories, $name4, $data4,null, $subtitle4);
                        }elseif ($report=='ipd_adchward') {
                        $charts5=new Charts();
                        $container5='chart5';
                        $type5='column';
                        $title5='admit/discharge ในปีงบประมาณ';
                        $subtitle5='แยกตึก';
                        $unit5 ='คน';
                        $name5 =$adch; 
                        $data5 =$countnum4;
                        $charts5->Columnstacking3D($daimention,$container5, $type5, $title5, $unit5, $categories, $name5, $data5,$stack, $subtitle5);
                        }elseif ($report=='ipd_adchsex') {
                        $charts6=new Charts();
                        $container6='chart6';
                        $type6='column';
                        $title6='admit/discharge ในปีงบประมาณ';
                        $subtitle6='แยกเพศ';
                        $unit6 ='คน';
                        $name6 =$adch_sex; 
                        $data6 =$countnum5;
                        $charts6->Columnstacking3D($daimention,$container6, $type6, $title6, $unit6, $categories, $name6, $data6,$stack_sex, $subtitle6);
                        }
                    ?>
                    
                    <script src="plugins/Highcharts/code/highcharts.js"></script>
                    <script src="plugins/Highcharts/code/modules/exporting.js"></script>
                    <script src="plugins/Highcharts/code/modules/data.js"></script>
                    <script src="plugins/Highcharts/code/modules/drilldown.js"></script>
                    <script src="plugins/Highcharts/code/highcharts-3d.js"></script>
                    <form method="post" action="" enctype="multipart/form-data" class="navbar-form">
                        <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-xs-12" align="right">
                            <select name='year'  class="form-control">
                                <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                <?php
                                for ($i = 2559; $i <= 2565; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                            <button type="submit" class="btn btn-success">ตกลง</button>
                        </div></div>
                    </form>
            <div class="col-lg-12">
                        <center><?=DateThai2($date_start)?> ถึง <?=DateThai2($date_end)?></center>
                <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">
                      <img src="images/ipd.ico" width="30"> IPD</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
<center>รายงาน IPD&nbsp;&nbsp;ปีงบประมาณ : <?= $years?></center>
                <div class="row">  
                    <?php if($report=='ipd_stable'){?>
                    <div class="col-lg-12 col-xs-12">
                    <div class="alert alert-warning" id="<?= $container4?>" style="min-width: 100%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    <br><a class="btn btn-success" download="report_ipdstable.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'คงพยาบาลยipdปีงบ <?= $years?>');">Export to Excel</a><br>
                    <table name="datatable" id="datatable" width="100%" border="0">
                        <tr>
                            <td><center>รายงานคงพยาบาล IPD&nbsp;&nbsp;ปีงบประมาณ : <?= $years?></center></td>
                        </tr>
                        <tr>
                            <td>
                              <?php //////////table opd patient
                    $sql="SELECT m.month_name,ROUND(AVG(ipd.stable_m1)) AS m1,ROUND(AVG(ipd.stable_m2)) AS m2,ROUND(AVG(ipd.stable_w)) AS w
FROM ipd_report_stable ipd
RIGHT OUTER JOIN `month` m ON m.month_id=SUBSTR(ipd.admdate,6,2)
where SUBSTR(ipd.admdate,1,7) BETWEEN '$month_start' AND '$month_end'
GROUP BY m.month_name
ORDER BY m.m_id";
                    $conn_DB->imp_sql($sql);
                    $conn_DB->select();
                    $column=array("เดือน","ชาย1 (เฉลี่ยคน/เดือน)","ชาย2 (เฉลี่ยคน/เดือน)","หญิง (เฉลี่ยคน/เดือน)");
                    $conn_DB->imp_columm($column);  
                    $conn_DB->createPDO_TBNoDivide();
                    ?>  
                            </td>
                        </tr>
                    </table>
                    </div>
                    <?php }elseif ($report=='ipd_adchward') {?>
                    <div class="col-lg-12 col-xs-12">
                    <div class="alert alert-warning" id="<?= $container5?>" style="min-width: 100%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    <br><a class="btn btn-success" download="report_ipd_adch.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'admit&dischartแยกตึกปีงบ <?= $years?>');">Export to Excel</a><br>
                    <table name="datatable" id="datatable" width="100%" border="0">
                        <tr>
                            <td><center>รายงาน admit&discharge แยกตึก IPD&nbsp;&nbsp;ปีงบประมาณ : <?= $years?></center></td>
                        </tr>
                        <tr>
                            <td>
                              <?php //////////table opd patient
                    $sql="SELECT m.month_name,SUM(ipd.admit_m1) AS adm1,SUM(ipd.admit_m2) AS adm2,SUM(ipd.admit_w) AS adw
,SUM(ipd.dch_m1) AS dchm1,SUM(ipd.dch_m2) AS dchm2,SUM(ipd.dch_w) AS dchw
FROM ipd_report_stable ipd
RIGHT OUTER JOIN `month` m ON m.month_id=SUBSTR(ipd.admdate,6,2)
where SUBSTR(ipd.admdate,1,7) BETWEEN '$month_start' AND '$month_end'
GROUP BY m.month_name
ORDER BY m.m_id";
                    $conn_DB->imp_sql($sql);
                    $conn_DB->select();
                    $column= array(
                            "เดือน"=>array(),
                            "admit"=>array(0=>"ชาย1", 1=>"ชาย2", 2=>"หญิง"),
                            "discharge"=>array(0=>"ชาย1", 1=>"ชาย2", 2=>"หญิง")
                            );
                    $conn_DB->imp_columm($column);  
                    $conn_DB->createPDO_TB_HeadNoDivide();
                    ?>  
                            </td>
                        </tr>
                    </table>
                    </div>
                    <?php }elseif ($report=='ipd_adchsex') {?>
                    <div class="col-lg-12 col-xs-12">
                    <div class="alert alert-warning" id="<?= $container6?>" style="min-width: 100%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    <br><a class="btn btn-success" download="report_opdsex.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'ผู้ป่วยopdแยกเพศปีงบ <?= $years?>');">Export to Excel</a><br>
                    <table name="datatable" id="datatable" width="100%" border="0">
                        <tr>
                            <td><center>รายงาน OPD&nbsp;&nbsp;ปีงบประมาณ : <?= $years?></center></td>
                        </tr>
                        <tr>
                            <td>
                              <?php //////////table opd patient
                    $sql="SELECT m.month_name,SUM(ipd.admit_m) AS adm,SUM(ipd.admit_w) AS adw
,SUM(ipd.dch_m) AS dchm,SUM(ipd.dch_w) AS dchw
FROM ipd_report_sex ipd
RIGHT OUTER JOIN `month` m ON m.month_id=SUBSTR(ipd.admdate,6,2)
where SUBSTR(ipd.admdate,1,7) BETWEEN '$month_start' AND '$month_end'
GROUP BY m.month_name
ORDER BY m.m_id
";
                    $conn_DB->imp_sql($sql);
                    $conn_DB->select();
                    $column= array(
                            "เดือน"=>array(),
                            "admit"=>array(0=>"ชาย", 1=>"หญิง"),
                            "discharge"=>array(0=>"ชาย", 1=>"หญิง")
                            );
                    $conn_DB->imp_columm($column);  
                    $conn_DB->createPDO_TB_HeadNoDivide();
                    ?>  
                            </td>
                        </tr>
                    </table>
                    </div>
                    <?php }?>
                </div>
                </div>
                </div>
          </div>
        </div>