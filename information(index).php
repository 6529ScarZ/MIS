                <div class="row">
             <?php
                        include_once ('plugins/funcDateThai.php');
                        include 'plugins/function_date.php';
                        
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

                    $month_start = "$Y-10-01";
                    $month_end = "$y-09-30";
                    $sex = '';                  
                    $sex[].='ชาย';
                    $sex[].='หญิง';
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
                    $sql="SELECT 10dxg_code FROM opd_report_10dxg where 10dxg_code in('F20','F41','F32','F10','F15') GROUP BY 10dxg_code order by dx_count desc";
                    $conn_DB->imp_sql($sql);
                    $dx_code = $conn_DB->select();
                    $num_rows= count($dx_code);
                    for ($c = 0; $c < $num_rows; $c++) {
                        @$name_dx10[].=$dx_code[$c]['10dxg_code'] . ',';
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
                        ///////////////10dx group
                        for ($c = 0; $c < $num_rows; $c++) {
                        @$sql3  = "select dx_count from opd_report_10dxg     
						 where  10dxg_code='".$dx_code[$c]['10dxg_code']."' and vstmonth like '$month_sel%' order by dx_count desc limit 5";
                        
                        $conn_DB->imp_sql($sql3);
                        $rs3 = $conn_DB->select();
                        @$countnum2[$c].= $rs3[0]['dx_count'] . ',';
                        }
                        
                        
                        $name.=isset($month[0]['month_short']) ? "'".$month[0]['month_short']."'" . ',':'';
                        $I++;
                    }
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
                    ///////////////////การใช้งาน class Charts   
                        $charts=new Charts();
                        $daimention='2';
                        $container='chart1';
                        $type='column';
                        $title='รายงานผู้ป่วย OPD แยกชาย/หญิง';
                        $subtitle='แยกรายเดือน';
                        $unit ='ราย';    
                        $categories=$name;
                        $name =$sex; 
                        $data =$countnum;
                        $charts->ColumnLine_3D($daimention,$container, $type, $title, $unit, $categories, $name, $data, $subtitle);
                        
                        $charts2=new Charts();
                        $container2='chart2';
                        $type2='line';
                        $title2='รายงานผู้ป่วย 5 โรค OPD';
                        $name2 =$name_dx10; 
                        $data2 =$countnum2;
                        $charts2->ColumnLine_3D($daimention,$container2, $type2, $title2, $unit, $categories, $name2, $data2, $subtitle);
                        
                        $charts3=new Charts();
                        $container3='chart3';
                        $type3='pie';
                        $title3='ผู้ป่วยมารับบริการในปีงบประมาณ';
                        $subtitle3='แยกรายจังหวัด';
                        $name3 ='ผู้มารับบริการ'; 
                        $data3 =$sss;
                        $charts3->Pie3D($daimention,$container3, $type3, $title3, $unit, $name3, $data3, $subtitle3);
                        
                        $charts4=new Charts();
                        $container4='chart4';
                        $type4='column';
                        $title4='คงพยาบาลในปีงบประมาณ';
                        $subtitle4='แยกตึก';
                        $unit4 ='คน (เฉลี่ย/เดือน)';
                        $name4 =$ward; 
                        $data4 =$countnum3;
                        $charts4->Columnstacking3D($daimention,$container4, $type4, $title4, $unit4, $categories, $name4, $data4,null, $subtitle4);
                        
                        $charts5=new Charts();
                        $container5='chart5';
                        $type5='column';
                        $title5='admit/discharge ในปีงบประมาณ';
                        $subtitle5='แยกตึก';
                        $unit5 ='คน';
                        $name5 =$adch; 
                        $data5 =$countnum4;
                        $charts5->Columnstacking3D($daimention,$container5, $type5, $title5, $unit5, $categories, $name5, $data5,$stack, $subtitle5);
                        
                        $charts6=new Charts();
                        $container6='chart6';
                        $type6='column';
                        $title6='admit/discharge ในปีงบประมาณ';
                        $subtitle6='แยกเพศ';
                        $unit6 ='คน';
                        $name6 =$adch_sex; 
                        $data6 =$countnum5;
                        $charts6->Columnstacking3D($daimention,$container6, $type6, $title6, $unit6, $categories, $name6, $data6,$stack_sex, $subtitle6);
                    ?>
                    
                    <style type="text/css">
                        #container {
    height: 100%; 
    min-width: 50%; 
    max-width: 100%;
    margin: 0 auto;
}
                    </style>
                    <script type="text/javascript">
                    $(function () {
    // Create the chart
    Highcharts.chart('container', {
        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70,
                viewDistance: 25
               
            }
        },
        title: {
            text: 'Browser market shares. January, 2015 to May, 2015'
        },
        subtitle: {
            text: 'Click the columns to view versions. Source: <a href="http://netmarketshare.com">netmarketshare.com</a>.'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total percent market share'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },

        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Microsoft Internet Explorer',
                y: 56.33,
                drilldown: 'Microsoft Internet Explorer'
            }, {
                name: 'Chrome',
                y: 24.03,
                drilldown: 'Chrome'
            }, {
                name: 'Firefox',
                y: 10.38,
                drilldown: 'Firefox'
            }, {
                name: 'Safari',
                y: 4.77,
                drilldown: 'Safari'
            }, {
                name: 'Opera',
                y: 0.91,
                drilldown: 'Opera'
            }, {
                name: 'Proprietary or Undetectable',
                y: 0.2,
                drilldown: null
            }]
        }],
        drilldown: {
            series: [{
                name: 'Microsoft Internet Explorer',
                id: 'Microsoft Internet Explorer',
                data: [
                    [
                        'v11.0',
                        24.13
                    ],
                    [
                        'v8.0',
                        17.2
                    ],
                    [
                        'v9.0',
                        8.11
                    ],
                    [
                        'v10.0',
                        5.33
                    ],
                    [
                        'v6.0',
                        1.06
                    ],
                    [
                        'v7.0',
                        0.5
                    ]
                ]
            }, {
                name: 'Chrome',
                id: 'Chrome',
                data: [
                    [
                        'v40.0',
                        5
                    ],
                    [
                        'v41.0',
                        4.32
                    ],
                    [
                        'v42.0',
                        3.68
                    ],
                    [
                        'v39.0',
                        2.96
                    ],
                    [
                        'v36.0',
                        2.53
                    ],
                    [
                        'v43.0',
                        1.45
                    ],
                    [
                        'v31.0',
                        1.24
                    ],
                    [
                        'v35.0',
                        0.85
                    ],
                    [
                        'v38.0',
                        0.6
                    ],
                    [
                        'v32.0',
                        0.55
                    ],
                    [
                        'v37.0',
                        0.38
                    ],
                    [
                        'v33.0',
                        0.19
                    ],
                    [
                        'v34.0',
                        0.14
                    ],
                    [
                        'v30.0',
                        0.14
                    ]
                ]
            }, {
                name: 'Firefox',
                id: 'Firefox',
                data: [
                    [
                        'v35',
                        2.76
                    ],
                    [
                        'v36',
                        2.32
                    ],
                    [
                        'v37',
                        2.31
                    ],
                    [
                        'v34',
                        1.27
                    ],
                    [
                        'v38',
                        1.02
                    ],
                    [
                        'v31',
                        0.33
                    ],
                    [
                        'v33',
                        0.22
                    ],
                    [
                        'v32',
                        0.15
                    ]
                ]
            }, {
                name: 'Safari',
                id: 'Safari',
                data: [
                    [
                        'v8.0',
                        2.56
                    ],
                    [
                        'v7.1',
                        0.77
                    ],
                    [
                        'v5.1',
                        0.42
                    ],
                    [
                        'v5.0',
                        0.3
                    ],
                    [
                        'v6.1',
                        0.29
                    ],
                    [
                        'v7.0',
                        0.26
                    ],
                    [
                        'v6.2',
                        0.17
                    ]
                ]
            }, {
                name: 'Opera',
                id: 'Opera',
                data: [
                    [
                        'v12.x',
                        0.34
                    ],
                    [
                        'v28',
                        0.24
                    ],
                    [
                        'v27',
                        0.17
                    ],
                    [
                        'v29',
                        0.16
                    ]
                ]
            }]
        }
    });
});
                    </script>
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
                    <div class="alert alert-success">
                    <div class="row">
                    <div class="col-lg-12 col-xs-12">
                    <div id="<?= $container?>" style="min-width: 100%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    </div><div class="col-lg-12">&nbsp;</div>
                    <div class="col-lg-12 col-xs-12">
                    <div id="<?= $container2?>" style="min-width: 100%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    </div><div class="col-lg-12">&nbsp;</div>
                    <div class="col-lg-12 col-xs-12">
                    <div id="<?= $container3?>" style="min-width: 100%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    </div>
                    </div>
                </div>
                </div>
                </div>
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
<div class="alert alert-warning">
                <div class="row">  
                    <div class="col-lg-12 col-xs-12">
                    <div id="<?= $container4?>" style="min-width: 100%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    </div><div class="col-lg-12">&nbsp;</div>
                    <div class="col-lg-12 col-xs-12">
                    <div id="<?= $container5?>" style="min-width: 100%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    </div><div class="col-lg-12">&nbsp;</div>
                    <div class="col-lg-12 col-xs-12">
                    <div id="<?= $container6?>" style="min-width: 100%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    </div>
                </div>
</div>
                </div>
                </div>
                <div class="box box-danger box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">
                      <img src="images/er.ico" width="30"> ER</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
<center>รายงาน ER&nbsp;&nbsp;ปีงบประมาณ : <?= $years?></center>
<div class="row">
                    <div class="col-lg-12 col-xs-12">
                    <div class="alert alert-danger" id="container" style="min-width: 100%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    </div>
</div>
                </div>
                </div>
          </div>
        </div>