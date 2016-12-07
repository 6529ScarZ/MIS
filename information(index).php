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
                        echo $date_start = DateThai2($date_start); //-----แปลงวันที่เป็นภาษาไทย
                        echo " ถึง ";
                        echo $date_end = DateThai2($date_end); //-----แปลงวันที่เป็นภาษาไทย
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
                    
                    $num_license = mysqli_query($db,"select count(license_id) as count_cl from ss_carlicense");
                        $count_license = mysqli_fetch_assoc($num_license);
                        $count_cl = $count_license['count_cl'];
                    
                    for ($c = 1; $c <= $count_cl; $c++) {
                    $sql2 = mysqli_query($db, "select license_name from ss_carlicense where license_id='$c'");
                    $rs2 = mysqli_fetch_assoc($sql2);
                    $name_license[$c].=$rs2['license_name'] . ',';
                    }
                    $I = 10;
                    for ($i = -2; $i <= 9; $i++) {

                        $sqlMonth = mysqli_query($db,"select * from month where m_id='$i'");
                        $month = mysqli_fetch_assoc($sqlMonth);

                        if ($i <= 0) {
                            $month_start = "$Y-$I-01";
                            $month_end = "$Y-$I-31";
                            /* if(date("Y-m-d")=="$y-$I-$d"){
                              $month_start = "$y-$I-01";
                              $month_end = "$y-$I-31";
                              } */
                        } elseif ($i >= 1 and $i <= 9) {
                            $month_start = "$year-0$i-01";
                            $month_end = "$year-0$i-31";
                        } else {
                            $month_start = "$year-$i-01";
                            $month_end = "$year-$i-31";
                        }

                        $month_start;
                        echo "&nbsp;&nbsp;";
                        $month_end;
                        
                        for ($c = 1; $c <= $count_cl; $c++) {
                        $sql  = mysqli_query($db,"select if(ISNULL(sum(bath)),0,sum(bath)) as sum_oil from ss_detial_oil   
						 where  license_id='$c' and reg_date between '$month_start' and '$month_end' order by license_id");
                        
                        $rs = mysqli_fetch_assoc($sql);
                       
                        $countnum[$c].= $rs['sum_oil'] . ',';
                        }
                        $name.="'".$month['month_short']."'" . ',';
                        $I++;
                    }
                    echo mysql_error();?>
                    <script src="plugins/Highcharts/js/highcharts.js"></script>
                    <script src="plugins/Highcharts/js/modules/exporting.js"></script>
                    <script type="text/javascript" src="plugins/Highcharts/api/js/j"></script>
                    <script type="text/javascript">
                        $(function () {
                            var chart;
                            $(document).ready(function () {
                                chart = new Highcharts.Chart({
                                    chart: {
                                        renderTo: 'container',
                                        type: 'line'
                                    },
                                    title: {
                                        text: 'จำนวนการใช้น้ำมันในแต่ละเดือน'
                                    },
                                    subtitle: {
                                        text: ''
                                    },
                                    xAxis: {
                                        categories: [<?= $name; ?>
                                        ]
                                    },
                                    yAxis: {
                                        title: {
                                            text: 'จำนวนเงิน (บาท)'
                                        }
                                    },
                                    tooltip: {
                                        enabled: true,
                                        formatter: function () {
                                            return '<b>' + this.series.name + '</b><br/>' +
                                                    this.x + ': ' + this.y + ' บาท';
                                        }
                                    },
                                    plotOptions: {
                                        line: {
                                            dataLabels: {
                                                enabled: true
                                            },
                                            enableMouseTracking: true
                                        }
                                    },
                                    series: [
                                    <?php for ($c = 1; $c <= $count_cl; $c++) {?>
                                    {
                                        
                                            name: '<?= $name_license[$c]?>',
                                            data: [<?= $countnum[$c]?>]
                                        
                                        },
                                                <?php }   ?>
                                    ]
                                });
                            });

                        });


                    </script>
                <div class="row">    
                    <div class="col-lg-12 col-xs-12">
                    <div class="col-lg-12" id="container" style="margin: 0 auto"></div>
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
