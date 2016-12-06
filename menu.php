  <body class="hold-transition skin-blue-light fixed sidebar-collapse sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>M</b>IS</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>MIS-</b>HOS v.1.0</span>
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
                                        
                                        $sql = "select concat(user_fname,' ',user_lname)as fullname,photo
                                            from user
                                                        WHERE user_id=:user_id";
                                         $execute=array(':user_id' => $user_id);
                                         $conn_DB->imp_sql($sql);
                                      $result=$conn_DB->select_a($execute);
                                      
                                      $empno_photo=$result['photo'];
                                        if (empty($empno_photo)) {
                                    $photo = 'person.png';
                                    $fold = "images/";
                                } else {
                                    $photo = $empno_photo;
                                    $fold = "photo/";
                                }
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
                      <?= $result['fullname']?>
                      <!--<small><?= $depname?></small>-->
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                        <a href="index.php?page=content/add_user&id=<?= $conn_DB->sslEnc($user_id)?>" class="btn btn-default btn-flat">ข้อมูลส่วนตัว</a>
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
              <a href="#"><i class="fa fa-circle text-success"></i> ระบบสารสนเทศโรงพยาบาล</a>
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
                  <img src="images/Import.ico" width="20">
                <span>ระบบนำเข้าข้อมูล</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li>
                  <a href="#"><i class="fa fa-circle-o text-blue"></i> ข้อมูลที่นำเข้าแล้ว <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#" onClick="window.open('content/pre_data_billimp.php?method=upd','','width=600,height=700'); return false;" title="Update ข้อมูล BILLDISP จาก HOS"><i class="fa fa-circle-o text-aqua"></i> ข้อมูล BILLDISP ที่นำเข้าแล้ว </a></li>
                    <li><a href="#" onClick="window.open('content/pre_data_billtran.php?method=upd','','width=600,height=700'); return false;" title="Update ข้อมูล BILLTRAN จาก HOS"><i class="fa fa-circle-o text-aqua"></i> ข้อมูล BILLTRAN ที่นำเข้าแล้ว </a></li>
                    </ul>
            </li>
                <li><a href="#" onClick="window.open('content/select_date_billimp.php?method=imp','','width=400,height=250'); return false;" title="นำเข้าข้อมูล BILLDISP จาก HOS"><i class="fa fa-circle-o text-green"></i> นำเข้า BILLDISP</a></li>
                <li><a href="#" onClick="window.open('content/select_date_billtran.php?method=imp','','width=400,height=250'); return false;" title="นำเข้าข้อมูล BILLTRAN จาก HOS"><i class="fa fa-circle-o text-green"></i> นำเข้า BILLTRAN</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o text-blue"></i> update ข้อมูล <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#" onClick="window.open('content/select_date_billimp.php?method=upd','','width=400,height=250'); return false;" title="Update ข้อมูล BILLDISP จาก HOS"><i class="fa fa-circle-o text-aqua"></i> update BILLDISP</a></li>
                    <li><a href="#" onClick="window.open('content/select_date_billtran.php?method=upd','','width=400,height=250'); return false;" title="Update ข้อมูล BILLTRAN จาก HOS"><i class="fa fa-circle-o text-aqua"></i> update BILLTRAN</a></li>
                    </ul>
            </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                  <img src="images/Document_Upload.ico" width="20">
                <span>ระบบส่งออก TXT</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li>
                  <a href="#"><i class="fa fa-circle-o text-blue"></i> ส่งออก BILLDISP <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                <li><a href="#" onClick="window.open('content/select_date_billimp.php?method=exp_total','','width=400,height=250'); return false;" title="ส่งออกข้อมูล BILLDISP ทั้งหมด"><i class="fa fa-circle-o text-green"></i> ส่งออก BILLDISP(ทั้งหมด)</a></li>
                <li><a href="#" onClick="window.open('content/select_date_billimp.php?method=exp','','width=900,height=700'); return false;" title="ส่งออกข้อมูล BILLDISP เลือกได้ไม่เกิน 124 ราย"><i class="fa fa-circle-o text-green"></i> ส่งออก BILLDISP(เลือก)</a></li>
                  </ul>
                  </li>
                  <li>
                  <a href="#"><i class="fa fa-circle-o text-blue"></i> ส่งออก BILLTRAN <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#" onClick="window.open('content/select_date_billtran.php?method=exp_total','','width=400,height=250'); return false;" title="ส่งออกข้อมูล BILLTRAN ทั้งหมด"><i class="fa fa-circle-o text-green"></i> ส่งออก BILLTRAN(ทั้งหมด)</a></li>
                    <li><a href="#" onClick="window.open('content/select_date_billtran.php?method=exp','','width=900,height=700'); return false;" title="ส่งออกข้อมูล BILLTRAN เลือกได้ไม่เกิน 124 ราย"><i class="fa fa-circle-o text-green"></i> ส่งออก BILLTRAN(เลือก)</a></li>
                  </ul>
                  </li>
                <li>
                  <a href="#"><i class="fa fa-circle-o text-orange"></i> รายงาน <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> #</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> #</a></li>
                    </ul>
                </li>
              </ul>
            </li>
            <?php }?>
            <li>
                <a href="#" onClick="return popup('#.php', popup, 820, 650);" title="ดูวันลาของบุคลากร">
                    <img src="images/opd.png" width="20"> <span>OPD</span>
              </a>
                <a href="#" onClick="return popup('#.php', popup, 820, 650);" title="ดูวันลาของบุคลากร">
                    <img src="images/ipd.ico" width="20"> <span>IPD</span>
              </a>
                <a href="#" onClick="return popup('#.php', popup, 820, 650);" title="ดูวันลาของบุคลากร">
                    <img src="images/er.ico" width="20"> <span>ER</span>
              </a>
                
                
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
