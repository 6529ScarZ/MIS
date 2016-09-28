<?php require 'up_header.php'; require 'header.php'; require 'menu.php';?>
<!-- Content Header (Page header) -->
<?php
if (isset($_SESSION['user'])) {
    if (NULL !== (filter_input(INPUT_GET, 'page'))) {
        $page = filter_input(INPUT_GET, 'page');
        require 'class/render.php';
        $render_php = new render($page);
        $render = $render_php->getRenderedPHP();
        echo $render;
    } else {
        ?>

        <section class="content-header">
            <div>
                <ol class="breadcrumb">
              <!--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>-->
                    <li class="active"><i class="glyphicon glyphicon-home"></i> หน้าหลัก</li>
                </ol>  
            </div>
        </section>
        <section class="content">
            <?php
            $sql = "select hospital from hospital order by hospital desc limit 1";
            $conn_DB1 = new EnDeCode();
            $read = "connection/conn_DB.txt";
            $conn_DB1->para_read($read);
            $db=$conn_DB1->conn_PDO();
            $conn_DB1->getDb();
            $conn_DB1->imp_sql($sql);
            $comm = $conn_DB1->select('');
            $conn_DB1->close_PDO();
            ?>
            <!--<a href="#" class="btn btn-success" onclick="window.open('content/detial_comm.php?id=<?php echo $conn_DB1->sslEnc($comm[0]['comm_id']);?>', '', 'width=800,height=650');
                    return false;">
                รายละเอียดกลุ่มออมทรัพย์</a>--> 
        </section>
    <?php }
} else { ?>


    <!-- Main content -->
    <section class="content">
        <?php
        if ($db == false) {
            $check = md5(trim('check'));
            ?>
            <center>
                <h3>ยังไม่ได้ตั้งค่า Config <br>กรุณาตั้งค่า Config เพื่อเชื่อมต่อฐานข้อมูล</h3>
                <a href="#" class="btn btn-danger" onClick="return popup('set_conn_db.php?method=<?= $check ?>', popup, 400, 515);" title="Config Database">Config Database</a>

            </center> 
    <?php } ?>
        NO LOGIN.           

    </section>
<?php } ?>


<?php 
require 'menu_footer.php';
require 'footer.php'; ?>