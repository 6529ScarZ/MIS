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
                    $sex = '';                  
                    $sex[].='ชาย';
                    $sex[].='หญิง';
                    $I = 10;
                    $countnum[]='';
                    $rs[]='';
                    $rs2[]='';
                    $name='';
                    if ($report=='opd_5cx') {
                    /////////name 5dx
                    $sql="SELECT 10dxg_code FROM opd_report_10dxg where 10dxg_code in('F20','F41','F32','F10','F15') GROUP BY 10dxg_code order by dx_count desc";
                    $conn_DB->imp_sql($sql);
                    $dx_code = $conn_DB->select();
                    $num_rows= count($dx_code);
                    for ($c = 0; $c < $num_rows; $c++) {
                        @$name_dx10[].=$dx_code[$c]['10dxg_code'] . ',';
                    }
                    }
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
                        if($report=='opd_sex'){
                        /////////////opd patient
                        for ($c = 0; $c < count($sex); $c++) {
                            $ii=0;
                        $sql  = "select man from opd_report   
						 where  vstmonth like '$month_sel%' order by opd_id";
                        $conn_DB->imp_sql($sql);
                        $rs = $conn_DB->select();
                       $countnum[$ii].= isset($rs[$c]['man']) ? $rs[$c]['man']. ',' :'';
                       $ii++;
                        $sql2  = "select woman as woman from opd_report   
						 where  vstmonth like '$month_sel%' order by opd_id";
                        $conn_DB->imp_sql($sql2);
                        $rs2 = $conn_DB->select();
                       @$countnum[$ii].= isset($rs2[$c]['woman']) ? $rs2[$c]['woman']. ',' :'';
                        }
                          }elseif ($report=='opd_5cx') {
                        ///////////////5dx group

                        for ($c = 0; $c < $num_rows; $c++) {
                        @$sql3  = "select dx_count from opd_report_10dxg     
						 where  10dxg_code='".$dx_code[$c]['10dxg_code']."' and vstmonth like '$month_sel%' order by dx_count desc limit 5";
                        
                        $conn_DB->imp_sql($sql3);
                        $rs3 = $conn_DB->select();
                        @$countnum2[$c].= $rs3[0]['dx_count'] . ',';
                        }
                          }
                        
                        $name.=isset($month[0]['month_short']) ? "'".$month[0]['month_short']."'" . ',':'';
                        $I++;
                    }
                    if ($report=='opd_5province') {
                    //////////////5 province
                        $sql4 =  "SELECT IF(or5.PROVINCE_CODE = 0,'อื่นๆ',prov.PROVINCE_NAME) AS prov_name,SUM(or5.count_patient) AS patient
FROM opd_report_5prov or5
LEFT OUTER JOIN province prov ON prov.PROVINCE_CODE=or5.PROVINCE_CODE
WHERE or5.vstmonth BETWEEN '$date_start' and '$date_end'
GROUP BY or5.PROVINCE_CODE ORDER BY patient DESC";
                        $conn_DB->imp_sql($sql4);
                        $rs4 = $conn_DB->select();
                        $sss='';
                        $count_patient=count($rs4);
                for($c=0;$c<$count_patient;$c++) {
                    $sss.= "['".$rs4[$c]['prov_name']."',".$rs4[$c]['patient']."],";
                }
                    }
                    ///////////////////การใช้งาน class Charts  
                    $daimention='2';
                    if($report=='opd_sex'){
                        $charts=new Charts();
                        $container='chart1';
                        $type='column';
                        $title='รายงานผู้ป่วย OPD แยกชาย/หญิง';
                        $subtitle='แยกรายเดือน';
                        $unit ='ราย';    
                        $categories=$name;
                        $name =$sex; 
                        $data =$countnum;
                        $charts->ColumnLine_3D($daimention,$container, $type, $title, $unit, $categories, $name, $data, $subtitle);
                    }elseif ($report=='opd_5cx') {    
                        $charts2=new Charts();
                        $container2='chart2';
                        $type2='line';
                        $title2='รายงานผู้ป่วย 5 โรค OPD';
                        $subtitle='แยกรายเดือน';
                        $unit ='ราย';    
                        $categories=$name;
                        $name2 =$name_dx10; 
                        $data2 =$countnum2;
                        $charts2->ColumnLine_3D($daimention,$container2, $type2, $title2, $unit, $categories, $name2, $data2, $subtitle);
                    }elseif ($report=='opd_5province') {    
                        $charts3=new Charts();
                        $container3='chart3';
                        $type3='pie';
                        $title3='ผู้ป่วยมารับบริการในปีงบประมาณ';
                        $subtitle3='แยกรายจังหวัด';
                        $unit ='ราย';
                        $name3 ='ผู้มารับบริการ'; 
                        $data3 =$sss;
                        $charts3->Pie3D($daimention,$container3, $type3, $title3, $unit, $name3, $data3, $subtitle3);
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
                <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">
                      <img src="images/opd.png" width="30"> OPD</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
<center>รายงาน OPD&nbsp;&nbsp;ปีงบประมาณ : <?= $years?></center>
                <div class="row">
                    <?php if($report=='opd_sex'){?>
                    <div class="col-lg-12 col-xs-12">
                    <div class="alert alert-success" id="<?= $container?>" style="min-width: 100%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    <br><a class="btn btn-success" download="report_opdsex.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'ผู้ป่วยopdแยกเพศปีงบ <?= $years?>');">Export to Excel</a><br>
                    <table name="datatable" id="datatable" width="100%" border="0">
                        <tr>
                            <td><center>รายงาน OPD&nbsp;&nbsp;ปีงบประมาณ : <?= $years?></center></td>
                        </tr>
                        <tr>
                            <td>
                              <?php //////////table opd patient
                    $sql="SELECT m.month_name,opd.man,opd.woman ,opd.man+opd.woman as total
                            FROM opd_report opd 
                            RIGHT OUTER JOIN `month` m ON m.month_id=SUBSTR(vstmonth,6,2) 
                            WHERE vstmonth BETWEEN '$month_start' AND '$month_end' ORDER BY m.m_id";
                    $conn_DB->imp_sql($sql);
                    $conn_DB->select();
                    $column=array("เดือน","ชาย (คน)","หญิง (คน)","รวม (คน)");
                    $conn_DB->imp_columm($column);  
                    $conn_DB->createPDO_TBNoDivide();
                    ?>  
                            </td>
                        </tr>
                    </table>
                    
                    </div>
                    
                    <?php }elseif ($report=='opd_5cx') { ?>
                    <div class="col-lg-12 col-xs-12">
                    <div class="alert alert-success" id="<?= $container2?>" style="min-width: 100%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    <br><a class="btn btn-success" download="report_5dx.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'ผู้ป่วย5โรคopdปีงบ <?= $years?>');">Export to Excel</a><br>
                    <table name="datatable" id="datatable" width="100%" border="0">
                        <tr>
                            <td><center>รายงานผู้ป่วย5โรค OPD&nbsp;&nbsp;ปีงบประมาณ : <?= $years?></center></td>
                        </tr>
                        <tr>
                            <td>
                              <?php //////////table opd patient
                    $sql="SELECT m.month_name,
(SELECT opd.dx_count FROM opd_report_10dxg opd WHERE opd.10dxg_code='F20' AND opd.vstmonth=month)F20,
(SELECT opd.dx_count FROM opd_report_10dxg opd WHERE opd.10dxg_code='F41' AND opd.vstmonth=month)F41,
(SELECT opd.dx_count FROM opd_report_10dxg opd WHERE opd.10dxg_code='F32' AND opd.vstmonth=month)F32,
(SELECT opd.dx_count FROM opd_report_10dxg opd WHERE opd.10dxg_code='F10' AND opd.vstmonth=month)F10,
(SELECT opd.dx_count FROM opd_report_10dxg opd WHERE opd.10dxg_code='F15' AND opd.vstmonth=month)F15
FROM (select vstmonth 'month'
from opd_report_10dxg
where SUBSTR(vstmonth,1,7) BETWEEN '$month_start' AND '$month_end'
group by month) a
RIGHT OUTER JOIN `month` m ON m.month_id=SUBSTR(month,6,2) ";
                    $conn_DB->imp_sql($sql);
                    $conn_DB->select();
                    $column=array("เดือน","F20 (คน)","F41 (คน)","F32 (คน)","F10 (คน)","F15 (คน)");
                    $conn_DB->imp_columm($column);  
                    $conn_DB->createPDO_TBNoDivide();
                    ?>  
                            </td>
                        </tr>
                    </table>
                    </div>
                    <?php }elseif ($report=='opd_5province') { ?>
                    <div class="col-lg-12 col-xs-12">
                    <div class="alert alert-success" id="<?= $container3?>" style="min-width: 100%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    <br><a class="btn btn-success" download="report_5province.xls" href="#" onClick="return ExcellentExport.excel(this, 'datatable', 'ผู้ป่วยแยกจังหวัดopdปีงบ <?= $years?>');">Export to Excel</a><br>
                    <table name="datatable" id="datatable" width="100%" border="0">
                        <tr>
                            <td><center>รายงานผู้ป่วย OPD ที่มารับบริการแยกจังหวัด&nbsp;&nbsp;ปีงบประมาณ : <?= $years?></center></td>
                        </tr>
                        <tr>
                            <td>
                              <?php //////////table opd patient
                    $sql="SELECT m.month_name,
(SELECT opd.count_patient FROM opd_report_5prov opd WHERE opd.PROVINCE_CODE='42' AND opd.vstmonth=month)เลย,
(SELECT opd.count_patient FROM opd_report_5prov opd WHERE opd.PROVINCE_CODE='41' AND opd.vstmonth=month)อุดรธานี,
(SELECT opd.count_patient FROM opd_report_5prov opd WHERE opd.PROVINCE_CODE='43' AND opd.vstmonth=month)หนองคาย,
(SELECT opd.count_patient FROM opd_report_5prov opd WHERE opd.PROVINCE_CODE='39' AND opd.vstmonth=month)หนองบัว,
(SELECT opd.count_patient FROM opd_report_5prov opd WHERE opd.PROVINCE_CODE='67' AND opd.vstmonth=month)เพชรบูรณ์,
(SELECT opd.count_patient FROM opd_report_5prov opd WHERE opd.PROVINCE_CODE='0' AND opd.vstmonth=month)อื่นๆ,
(SELECT SUM(opd.count_patient) FROM opd_report_5prov opd WHERE opd.vstmonth=month)รวม
FROM (select vstmonth 'month'
from opd_report_5prov
where SUBSTR(vstmonth,1,7) BETWEEN '$month_start' AND '$month_end'
group by month) a
RIGHT OUTER JOIN `month` m ON m.month_id=SUBSTR(month,6,2)";
                    $conn_DB->imp_sql($sql);
                    $conn_DB->select();
                    $column=array("เดือน","เลย (คน)","อุดรธานี (คน)","หนองคาย (คน)","หนองบัว (คน)","เพชรบูรณ์ (คน)","อื่นๆ (คน)","รวม (คน)");
                    $conn_DB->imp_columm($column);  
                    $conn_DB->createPDO_TBNoDivide();
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