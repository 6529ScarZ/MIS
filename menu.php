  <body class="hold-transition skin-green fixed sidebar-collapse sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>H</b>RD</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>HRD-</b>System v.2.0</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php if(empty($_SESSION['user_mis'])){?>
                <li class="dropdown messages-menu">
                    
                        <a href="#" onClick="return popup('login_page.php', popup, 300, 330);" title="เข้าสู่ระบบบุคลากร">
                            <img src="images/key-y.ico" width="18"> เข้าสู่ระบบ
                  </a>
                   
                </li>
                <?php }else{
                    
                    $user_id = $_SESSION['user_mis'];
                                    if (!empty($user_id)) {
                                        
                                        $sql = "select em.photo,po.posname ,d1.depName from emppersonal em 
                                                        INNER JOIN posid po on em.posid=po.posId
                                                        INNER JOIN department d1 on em.depid=d1.depId
                                                        WHERE empno='$user_id'";
                                        $conn_DB->imp_sql($sql);
                                      $result=$conn_DB->select_a();
                                      //$conn_DB->close_PDO();
                                      
                                      $empno_photo=$result['photo'];
                                      $posname=$result['posname'];
                                      $depname=$result['depName'];
                                        if (empty($empno_photo)) {
                                    $photo = 'person.png';
                                    $fold = "images/";
                                } else {
                                    $photo = $empno_photo;
                                    $fold = "photo/";
                                }
                                        //$db->close();
                                    }
                    
                    ?>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?= $fold.$photo?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?= $_SESSION['fullname_mis']?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?= $fold.$photo?>" class="img-circle" alt="User Image">
                    <p>
                      <?= $posname?>
                      <small><?= $depname?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">ข้อมูลส่วนตัว</a>
                    </div>
                    <div class="pull-right">
                        <a href="index.php?page=process/logout" class="btn btn-default btn-flat">ออกจากระบบ</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
                <?php }?>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $fol.$pic?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>โรงพยาบาลจิตเวชเลยฯ</p>
              <a href="#"><i class="fa fa-circle text-success"></i> ระบบข้อมูลบุคลากร</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">เมนูหลัก</li>
            <li class=""><a href="index.php">
                    <img src="images/gohome.ico" width="20"> <span>หน้าหลัก</span></a>
            </li>
            <?php if(isset($_SESSION['user_mis'])){ ?>
            <li class="treeview">
              <a href="#">
                  <img src="images/kuser.ico" width="20">
                <span>ระบบบุคลากร</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li><a href="index.php?page=personal/add_person"><i class="fa fa-circle-o text-green"></i> เพิ่มข้อมูลบุคลากร</a></li>
                <li><a href="index.php?page=personal/pre_person"><i class="fa fa-circle-o text-green"></i> ข้อมูลบุคลากร</a></li>
                <li><a href="index.php?page=personal/pre_educate"><i class="fa fa-circle-o text-green"></i> ประวัตฺการศึกษา</a></li>
                <li><a href="index.php?page=personal/resign_person"><i class="fa fa-circle-o text-green"></i> ข้อมูลบุคลากรย้าย/ลาออก</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o text-blue"></i> รายงาน <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="index.php?page=personal/statistics_person"><i class="fa fa-circle-o text-aqua"></i> สถิติบุคลากร</a></li>
                    <li><a href="#" onClick="window.open('personal/detial_type.php','','width=400,height=350'); return false;" title="สถิติประเภทพนักงาน"><i class="fa fa-circle-o text-aqua"></i> สถิติประเภทพนักงาน</a></li>
                    <li><a href="#" onClick="window.open('personal/detial_position.php','','width=600,height=680'); return false;" title="สถิติตำแหน่งพนักงาน"><i class="fa fa-circle-o text-aqua"></i> สถิติตำแหน่งพนักงาน</a></li>
                    </ul>
            </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                  <img src="images/Letter.png" width="20">
                <span>ระบบการลา</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li><a href="index.php?page=leave/receive_leave"><i class="fa fa-circle-o text-red"></i> บันทึกทะเบียนรับใบลา</a></li>
                <li><a href="index.php?page=leave/pre_leave"><i class="fa fa-circle-o text-red"></i> บันทึกการลาบุคลากร</a></li>
                <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o text-red"></i> ยกเลิกใบลา</a></li>
                <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o text-red"></i> การลาชั่วโมง</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o text-orange"></i> รายงาน <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> สถิติการลาแยกหน่วยงาน</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> สถิติการลา</a></li>
                    </ul>
                </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                  <img src="images/training.ico" width="20">
                <span>ระบบอบรมภายนอก</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o text-maroon"></i> บันทึกโครงการฝึกอบรมภายนอก</a></li>
                <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o text-maroon"></i> บันทึกการฝึกอบรมภายนอก</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o text-fuchsia"></i> รายงาน <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-fuchsia"></i> สถิติการฝึกอบรมภายนอก</a></li>
                    </ul>
                </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                  <img src="images/trainin.ico" width="20">
                <span>ระบบอบรมภายใน</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o text-purple"></i> บันทึกโครงการฝึกอบรมภายใน</a></li>
                <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o text-purple"></i> บันทึกการฝึกอบรมภายใน</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o text-maroon"></i> รายงาน <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-fuchsia"></i> สถิติการฝึกอบรมภายใน</a></li>
                    </ul>
                </li>
              </ul>
            </li>
                        <li>
                <a href="plugins/fullcalendar/fullcalendar1.php">
                    <img src="images/notes.ico" width="20"> <span>ประชาสัมพันธ์</span>
                <small class="label pull-right bg-red">3</small>
              </a>
            </li>
            <?php }?>
            <li>
                <a href="#" onClick="return popup('plugins/fullcalendar/fullcalendar1.php', popup, 820, 650);" title="ดูวันลาของบุคลากร">
                    <img src="images/Calendar.ico" width="20"> <span>ปฏิทินการลา</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
