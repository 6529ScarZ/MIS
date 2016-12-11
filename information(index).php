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
                        echo '<center>'.$date_start = DateThai2($date_start); //-----แปลงวันที่เป็นภาษาไทย
                        echo " ถึง ";
                        echo $date_end = DateThai2($date_end).'</center>'; //-----แปลงวันที่เป็นภาษาไทย
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
                    
                    $sql="SELECT 10dxg_code FROM opd_report_10dxg GROUP BY 10dxg_code order by dx_count desc";
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
                        @$sql3  = "select if(ISNULL(sum(dx_count)),0,sum(dx_count)) as dx_count from opd_report_10dxg     
						 where  10dxg_code='".$dx_code[$c]['10dxg_code']."' and vstmonth like '$month_sel%' order by dx_count desc";
                        
                        $conn_DB->imp_sql($sql3);
                        $rs3 = $conn_DB->select();
                        @$countnum2[$c].= $rs3[0]['dx_count'] . ',';
                        }
                        $name.=isset($month[0]['month_short']) ? "'".$month[0]['month_short']."'" . ',':'';
                        $I++;
                    }
                    ?>
                    <script src="plugins/Highcharts/js/highcharts.js"></script>
                    <script src="plugins/Highcharts/js/modules/exporting.js"></script>
                    <script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'รายงานผู้ป่วย OPD แยกชาย/หญิง'
        },
        subtitle: {
            text: 'แยกรายเดือน'
        },
        xAxis: {
            categories: [<?= $name?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'ราย'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} ราย</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [<?php for ($c = 0; $c <= 1; $c++) {?>
                                    {
                                            name: '<?= $sex[$c]?>',
                                            data: [<?= $countnum[$c]?>]
                                        },
                                                <?php }   ?>]
    });
});
		</script>
                                                        <script type="text/javascript">
$(function () {
    $('#container2').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'รายงานผู้ป่วย 10 โรค OPD'
        },
        subtitle: {
            text: 'แยกรายเดือน'
        },
        xAxis: {
            categories: [<?= $name?>
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'ราย'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} ราย</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [<?php for ($c = 0; $c < $num_rows; $c++) {?>
                                    {
                                            name: '<?= $name_dx10[$c]?>',
                                            data: [<?= $countnum2[$c]?>]
                                        },
                                                <?php }   ?>]
    });
});
		</script>
                <div class="row">    
                    <div class="col-lg-6 col-xs-12">
                    <div id="container" style="min-width: 100%; height: 100%; margin: 0 auto"></div>
                    </div>
                    <div class="col-lg-6 col-xs-12">
                    <div id="container2" style="min-width: 100%; height: 100%; margin: 0 auto"></div>
                    </div>
                    </div>
                    <br><br>
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