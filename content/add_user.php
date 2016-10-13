  <script language="javascript">
function fncSubmit()
	{
	 if(document.form1.user_pwd.value != document.form1.user_pwd2.value)
		{
			alert('การยืนยันรหัสผ่านไม่ตรงกัน กรุณาตรวจสอบ');
			document.form1.user_pwd.focus();		
			return false;
		}else{	
			return true;
			document.form1.submit();
		}
}
</script>
<section class="content-header">
               <h1> <font color="blue">ตั้งค่าผู้ใช้งาน</font></h1>
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-gear"></i> ตั้งค่าผู้ใช้งาน</li>
            </ol>
</section>
			<?php 
                $mydata=new TablePDO();
                $read='connection/conn_DB.txt';
                $mydata->para_read($read);
                
			 if(null !==(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_ENCODED))){ 
			 $user_id=filter_input(INPUT_GET, 'id', FILTER_SANITIZE_ENCODED);
                         $user_idGet=$mydata->sslDec($user_id);
                          /*if(filter_input(INPUT_GET, 'method', FILTER_SANITIZE_STRING)=='update_user'){
                             $status= filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);
                         }elseif(filter_input(INPUT_GET, 'method', FILTER_SANITIZE_STRING)=='edit'){
                         $status=$_SESSION['Status'];}*/
			 $sql="select * from  user where user_id='$user_idGet'";
			 $mydata->conn_PDO();
                         $mydata->imp_sql($sql);
                         $resultGet=$mydata->select_a();
			 }
			   ?> 
<section class="content">
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มผู้ใช้งานระบบ</h3>
                    </div>
                <div class="panel-body">
                    <div class="col-lg-4 col-xs-12">
                        <div class="row well well-sm">   
                    <form name='form1' class="navbar-form navbar-left"  action='index.php?page=process/prcuser' method='post' enctype="multipart/form-data" OnSubmit="return fncSubmit();">
                        <b>ชื่อ-นามสกุล </b><br>
                        <div class="form-group">	
                        <?php if($_SESSION['status_mis']==1){?>
                            <input type="text" name='fname'   id='names' class='form-control' value='<?php if(!empty($user_idGet)){ echo $resultGet['user_fname'];}?>' readonly="">
                            <input type="text" name='lname'   id='names' class='form-control' value='<?php if(!empty($user_idGet)){ echo $resultGet['user_lname'];}?>' readonly="">
                            <?php }else{?>
                            <input type="text" name='fname' size="15" id='names' class='form-control' value='<?php if(!empty($user_idGet)){ echo $resultGet['user_fname'];}?>'>
                            <input type="text" name='lname'   id='names' class='form-control' value='<?php if(!empty($user_idGet)){ echo $resultGet['user_lname'];}?>'>
                            <?php }?>
			 </div> 
                        <br>
                        <div class="form-group">
        <label>ระดับการใช้งาน &nbsp;</label><br>
                    <?php if($_SESSION['status_mis']== 0){ ?>
	<select name='admin' id='admin'class='form-control' onchange="data_show(this.value,'process');"  required >
			<?php 		
				echo "<option value=''>เลือกระดับการใช้งาน</option>";			
		 		if($resultGet['user_status']=="0"){$ok='selected';}
				if($resultGet['user_status']=="1"){$selected='selected';}
				echo "<option value='1'  $selected>ผู้ใช้ทั่วไป</option>";	
				echo "<option value='0'  $ok >ผู้ดูแลระบบ</option>";						
				?>
			</select>
                         <?php }else{?>
                                <input type="text" name=''   id='' class='form-control'  value='<?= 'ผู้ใช้ทั่วไป'?>' readonly >
                                <input type="hidden" name="admin" id="admin" value="<?= $resultGet['user_status']?>">
                         <?php }?>
                        </div>
                        <br>
                        <?php if($_SESSION['status_mis']==0){
                            $read='';
                        }else{
                            $read='readonly';
                        }
?>
			<div class="form-group">	
                            <b>ชื่อผู้ใช้งาน</b><br>
                        <input type='text' name='user_account'  id='user_account' placeholder='ชื่อผู้ใช้งาน' class='form-control'  onkeydown="return nextbox(event, 'user_pwd');"   value='<?php if(!empty($user_idGet)){ echo $resultGet['user_name'];}?>' required <?= $read?>>
			 </div> 
                        <br>
			<?PHP 
			if(empty($user_idGet)){
			 	$required='required';			
			}else{
				$required='';
			}
			?> 
			<div class="form-group">
                            <b>รหัสผ่าน</b><br>
			<input type="password" name='user_pwd'  id='user_pwd' placeholder='รหัสผ่าน' class='form-control'  value=''  onkeydown="return nextbox(event, 'user_pwd2');" <?= $required?>>
			 </div><br>
	 		<div class="form-group">
                            <label for="user_pwd2">ยืนยันรหัสผ่าน</label><br>
			<input type="password" name='user_pwd2' id='user_pwd2' placeholder='ยืนยันรหัสผ่าน' class='form-control'  value=''  onkeydown="return nextbox(event, 'save');" <?= $required?>>
			 </div><br>
                         <?php if(!empty($user_idGet)){echo "<font color='red'>*หากไม่เปลี่ยนรหัสผ่านไม่ต้องแก้ไข <br>";?></font>
                         <?php  if (empty($resultGet['photo'])) {
                                    $photo = 'person.png';
                                    $fold = "images/";
                                } else {
                                    $photo = $resultGet['photo'];
                                    $fold = "photo/";
                                }
                                echo "<img src='$fold$photo' width='150'><br>";
                         }    ?>
                         
  <div class="form-group">
                            <label for="user_pwd2">รูปภาพ</label><br>
                            <input type="file" name='image' id='image' placeholder='รูปถ่าย' class='form-control'  value=''  onkeydown="return nextbox(event, 'save');" <?= $required?>>
  </div><p>
 <?PHP 
	if(!empty($user_idGet)){
		echo "<input type='hidden' name='id' value='$user_idGet'>";
		echo "<input type='hidden' name='method' value='update_user'>";
                ?>
        <p><button  class="btn btn-warning" id='save'> แก้ไข </button > <input type='reset' class="btn btn-danger"   > </p>
	<?php }  else {?>
        <input type="hidden" name="method" value="add_user">
         <p><button  class="btn btn-success" id='save'> บันทึก </button > <input type='reset' class="btn btn-danger"   > </p>
              <?php } ?>
		</form>
                        </div>
      </div> <?php
      $mydata->close_PDO();
      if($_SESSION['status_mis']== 0){?>
                    <div class="col-lg-8 col-xs-12">
                        <div class="well well-sm">
                      <?php include 'list_user.php';?>   
                        </div></div>
      <?php}?>
    </div>
              </div>
    </div>
  </div>
        
         <?php }?>
</section>
