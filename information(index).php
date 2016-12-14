                <div class="row">
             <?php
                        include_once ('plugins/funcDateThai.php');
                        include 'plugins/function_date.php';
                        ?>	
                    <div class="col-lg-12 col-xs-12">
                    <form method="post" action="" enctype="multipart/form-data" class="navbar-form navbar-right">
                        <div class="form-group col-lg-9 col-md-9 col-xs-8"> 
                            <select name='year'  class="form-control">
                                <option value=''>กรุณาเลือกปีงบประมาณ</option>
                                <?php
                                for ($i = 2559; $i <= 2565; $i++) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-3 col-xs-4"><button type="submit" class="btn btn-success">ตกลง</button></div> 						
                    </form>
                    </div>
                    <?php $d_start = 01;
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
                        echo '<center>'.DateThai2($date_start); //-----แปลงวันที่เป็นภาษาไทย
                        echo " ถึง ";
                        echo DateThai2($date_end).'</center>'; //-----แปลงวันที่เป็นภาษาไทย
                        ?>
          <div class="col-lg-12">
                <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">
                      <img src="images/opd.png" width="30"> OPD</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php
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
                    
              echo "<center>";



                    echo "รายงาน OPD";
                    echo "&nbsp;&nbsp;";
                    echo "ปีงบประมาณ : $years";
                    echo "</center>";

                    $month_start = "$Y-10-01";
                    $month_end = "$y-09-30";
                    $sex = '';                  
                    $sex[].='ชาย,';
                    $sex[].='หญิง,';
                    $I = 10;
                    $countnum[]='';
                    $rs[]='';
                    $rs2[]='';
                    $name='';
                    
                    $sql="SELECT 10dxg_code FROM opd_report_10dxg GROUP BY 10dxg_code order by dx_count desc limit 5";
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
/////////////////////////////                   /
                        echo "&nbsp;&nbsp;";
                        $ii=1;
                        /////////////opd patient
                        for ($c = 0; $c <= 1; $c++) {
                            
                        $sql  = "select man from opd_report   
						 where  vstmonth like '$month_sel%' order by opd_id";
                        $conn_DB->imp_sql($sql);
                        $rs = $conn_DB->select();
                       $countnum[$c].= isset($rs[$c]['man']) ? $rs[$c]['man']. ',' :'';
                       
                        $sql2  = "select woman as woman from opd_report   
						 where  vstmonth like '$month_sel%' order by opd_id";
                        $conn_DB->imp_sql($sql2);
                        $rs2 = $conn_DB->select();
                       @$countnum[$ii].= isset($rs2[$c]['woman']) ? $rs2[$c]['woman']. ',' :'';
                        $ii+2;
                        }
                        ///////////////10dx group
                        for ($c = 0; $c < $num_rows; $c++) {
                        @$sql3  = "select dx_count as dx_count from opd_report_10dxg     
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
                    ?>
                    
		<style type="text/css">
#container {
	height: 400px; 
	min-width: 310px; 
	max-width: 800px;
	margin: 0 auto;
}
		</style>
<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column',
            margin: 75,
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'รายงานผู้ป่วย OPD แยกชาย/หญิง'
        },
        tooltip: {
                                        enabled: true,
                                        formatter: function () {
                                            return '<b>' + this.series.name + '</b><br/>' +
                                                    this.x + ': ' + this.y + ' ราย';
                                        }
                                    },
        subtitle: {
            text: 'แยกรายเดือน'
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        xAxis: {
            categories: [<?= $name?>
            ]
        },
        yAxis: {
            title: {
                text: 'ราย'
            }
        },
        series: [<?php for ($c = 0; $c <= 1; $c++) {?>
                                    {
                                            name: '<?= $sex[$c]?>',
                                            data: [<?= $countnum[$c]?>],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '12px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
                                        },
                                                <?php }   ?>]
    });
});
		</script>
<style type="text/css">
#container2 {
	height: 400px; 
	min-width: 310px; 
	max-width: 800px;
	margin: 0 auto;
}
		</style>
<script type="text/javascript">
$(function () {
    $('#container2').highcharts({
        chart: {
            type: 'line',
            margin: 75,
            options3d: {
                enabled: true,
                alpha: 0,
                beta: 0,
                depth: 50
            }
        },
        title: {
            text: 'รายงานผู้ป่วย 5 โรค OPD'
        },tooltip: {
                                        enabled: true,
                                        formatter: function () {
                                            return '<b>' + this.series.name + '</b><br/>' +
                                                    this.x + ': ' + this.y + ' ราย';
                                        }
                                    },
        subtitle: {
            text: 'แยกรายเดือน'
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        xAxis: {
            categories: [<?= $name?>
            ]
        },
        yAxis: {
            title: {
                text: 'ราย'
            }
        },
        series: [<?php for ($c = 0; $c < $num_rows; $c++) {?>
                                    {
                                            name: '<?= $name_dx10[$c]?>',
                                            data: [<?= $countnum2[$c]?>],
            dataLabels: {
                enabled: true,
                rotation: 0,
                color: '#000000',
                align: 'right',
                format: '{point.y}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '9px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
                                        },
                                                <?php }   ?>]
    });
});
		</script>
<script type="text/javascript">
$(function () {
    $('#container3').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'ผู้ป่วยมารับบริการในปีงบ <?= $years?>'
        },
                subtitle: {
            text: 'แยกรายจังหวัด'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'+ '</b>: <br>' + '{y}' + ' ราย'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'ผู้มารับบริการ',
            /*data: [<?php $count_patient=count($rs4);
                for($c=0;$c<$count_patient;$c++) {
                    $name = $rs4[$c]['prov_name'];
                    $count = $rs4[$c]['patient'];
                    $sss.= "['".$name."',".$count."],";
                    echo $sss;
                }
                ?>
            ]*/
    data: [<?= $sss?>
            ]
        }]
    });
});
		</script> 
                
                    <script src="plugins/Highcharts/code/highcharts.js"></script>
                    <script src="plugins/Highcharts/code/modules/exporting.js"></script>
                    <script src="plugins/Highcharts/code/highcharts-3d.js"></script>
                <div class="row">    
                    <div class="col-lg-6 col-xs-12">
                    <div id="container" style="min-width: 50%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    </div>
                    <div class="col-lg-6 col-xs-12">
                    <div id="container2" style="min-width: 50%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    </div>
                    <div class="col-lg-12 col-xs-12">
                    <div id="container3" style="min-width: 50%; max-width: 100%; height: 100%; margin: 0 auto"></div>
                    </div>
                </div>
                </div>
          </div>
            <div class="col-lg-12">
                <div class="box box-warning box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">
                      <img src="images/ipd.ico" width="30"> IPD</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    #
                </div>
                </div>
          </div>
            <div class="col-lg-12">
                <div class="box box-danger box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">
                      <img src="images/er.ico" width="30"> ER</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    #
                </div>
                </div>
          </div>
        </div>