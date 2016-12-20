<?php require 'up_header.php'; require 'header.php'; require 'menu.php';?>
<!-- Content Header (Page header) -->
<?php
if (isset($_SESSION['user_mis'])) {
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
            <?php include 'information(index).php';?>
        </section>
    <?php }
} else { 
    if (isset($_GET['NLI']) and (NULL !== (filter_input(INPUT_GET, 'page')))) {
        $page = filter_input(INPUT_GET, 'page');
        require 'class/render.php';
        $render_php = new render($page);
        $render = $render_php->getRenderedPHP();
        echo $render;
    } else {?>


    <!-- Main content -->
    <section class="content">
        <?php
        if ($db == false) {
            $check = md5(trim('check'));
            ?>
            <center>
                <h3>ยังไม่ได้ตั้งค่า Config <br>กรุณาตั้งค่า Config เพื่อเชื่อมต่อฐานข้อมูล</h3>
                <a href="#" class="btn btn-danger" onClick="return popup('set_conn_db.php?method=<?= $check ?>&host=main', popup, 400, 600);" title="Config Database">Config Database</a>

            </center> 
    <?php } ?>
        <center><h2><b>M I S</b></h2><p><h3>( Management Information System )</h3></center>
<?php include 'information(index).php';?>

        NO LOGIN.           

    </section>
<?php }} ?>


<?php 
require 'menu_footer.php';
require 'footer.php'; ?>