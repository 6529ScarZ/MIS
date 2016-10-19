<script type="text/javascript">
    function nextbox(e, id) {
        var keycode = e.which || e.keyCode;
        if (keycode == 13) {
            document.getElementById(id).focus();
            return false;
        }
    }
</script>
  <!--<script language="javascript">
function fncSubmit()
        {
         if(document.form1.name_dep.value=='')
                {
                        alert('กรุณากรอกชื่อฝ่าย/ศูนย์/กลุ่มงาน');
                        document.form1.name_dep.focus();		
                        return false;
                }else{	
                        return true;
                        document.form1.submit();
                }
}
</script>-->
<section class="content-header">
    <h1><font color="blue">ตั้งค่าองค์กร/ผู้บริหาร</font></h1>
    <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
        <li class="active"><i class="fa fa-gear"></i> ตั้งค่าองค์กร/ผู้บริหาร</li>
    </ol>
</section><!-- /.row -->
<?php
$conn_DB = new TablePDO();
$read = "connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->conn_PDO();
$sql = "select * from  hospital order by hospital limit 1";
$conn_DB->imp_sql($sql);
$resultGet = $conn_DB->select_a();
?>  
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เปลี่ยนแปลงค่า องค์กร/ผู้บริหาร</h3>
                </div>
                <div class="panel-body">

                    <div class="col-lg-4">       
                        <form name='form2' class="navbar-form navbar-left"  action='index.php?page=process/prchos' method='post' enctype="multipart/form-data" OnSubmit="return fncSubmit();">
                            <div class="form-group">	
                                <label>องค์กร </label>
                                <input type='text' name='name'  id='name' placeholder='องค์กร' class='form-control'  value='<?= $resultGet['name']; ?>' size="50" required>
                            </div><p> 
                                <div class="form-group">	
                                <label>ชื่อย่อองค์กร </label>
                                <input type='text' name='name_mini'  id='name_mini' placeholder='ชื่อย่อองค์กร' class='form-control'  value='<?= $resultGet['name2']; ?>' size="50" required>
                            </div><p>
                            <div class="form-group">	
                                <label>ผู้บริหาร </label>
                                <input type="text" name="m_name" id="m_name" required size="50" class="form-control" value="<?= $resultGet['manager'];?>"> 
                            </div><p> 
                            <div class="form-group">	
                                <label>URL </label>
                                <input type='text' name='url'  id='url' placeholder='เช่น http://sample.go.th/' class='form-control'  value='<?= $resultGet['url']; ?>' size="50" required>
                            </div><p> 
                                <?php  if (empty($resultGet['logo'])) {
                                    $photo = 'agency.ico';
                                    $fold = "images/";
                                } else {
                                    $photo = $resultGet['logo'];
                                    $fold = "logo/";
                                }
                                echo "<img src='$fold$photo' width='120'><br>";
                                ?>
                            <div class="form-group">
                                <label>สัญลักษณ์องค์กร &nbsp;</label>
                                <input type="file" name="image"  id="image" class="form-control"/>
                            </div><p>
                                <input type='hidden' name='id' value='<?= $resultGet['hospital']?>'>
                            <input type='hidden' name='method' value='update_hos'>
                            <p><button  class="btn btn-success" id='save'> บันทึก </button > <input type='reset' class="btn btn-danger"   > </p>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  row of columns -->
