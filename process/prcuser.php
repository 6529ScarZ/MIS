<section class="content">
    <?php
    echo "<p>&nbsp;</p>	";
    echo "<p>&nbsp;</p>	";
    echo "<div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>";
    echo "<div class='alert alert-dismissable alert-success'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div>";
    if (isset($_POST['check']) == 'plus') {
        require '../class/EnDeCode.php';
        $mydata= new TablePDO();
        $read="../connection/conn_DB.txt";
        $mydata->para_read($read);
        $db=$mydata->conn_PDO();
    } else {
        $mydata= new TablePDO();
        $read="connection/conn_DB.txt";
        $mydata->para_read($read);
        $db=$mydata->conn_PDO();
    }
    $date = new DateTime(null, new DateTimeZone('Asia/Bangkok'));//กำหนด Time zone
    if (null !== (filter_input(INPUT_POST, 'method'))) {
        $method = filter_input(INPUT_POST, 'method');
        if ($method == 'add_user'){
            $username=  trim(md5(filter_input(INPUT_POST,'user_account')));
            $pass_word=  trim(md5(filter_input(INPUT_POST,'user_pwd')));
            if (trim($_FILES["image"]["name"] != "")) {
                $upload = new file_upload("image", "photo");
                $image = $upload->upload();
            } else {
                $image = '';
            }
        $data=array($_POST['fname'],$_POST['lname'],$_POST['user_account'],$username,$pass_word,$_POST['admin'],$image);
        $table="user";
        $check_user=$mydata->insert($table, $data);
        if($check_user=false){
        echo "<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='?page=content/add_user&ss_id=".$_POST['name']."' >กลับ</a>";
    } else {
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=?page=content/add_user'>";
        }
        }elseif ($method == 'update_user'){
        if(!empty($_POST['user_pwd'])){
            $username=  trim(md5($_POST['user_account']));
            $pass_word=  trim(md5($_POST['user_pwd']));
         if (trim($_FILES["image"]["name"] != "")) {
                $sql="select photo from user where user_id='".$_POST['id']."'";
                $mydata->imp_sql($sql);
                $photo=$mydata->select_a();
                if(!empty($photo['photo'])){
                $location="photo/".$photo['photo'];
                include 'function/delet_file.php';
                fulldelete($location);
            }
                $upload = new file_upload("image", "photo");
                $image = $upload->upload();
        $data=array($_POST['fname'],$_POST['lname'],$_POST['user_account'],$username,$pass_word,$_POST['admin'],$image);
        $field=array("user_fname","user_lname","user_name","user_account","user_pwd","user_status","photo");
        } else {
        $data=array($_POST['fname'],$_POST['lname'],$_POST['user_account'],$username,$pass_word,$_POST['admin']);  
        $field=array("user_fname","user_lname","user_name","user_account","user_pwd","user_status");
        }
        $table="user";
        $where="user_id=:user_id";
        $execute=array(':user_id' => $_POST['id']);
        
        $check_user=$mydata->update($table, $data, $where, $field, $execute);  
        }else{
            $username=  trim(md5($_POST['user_account']));
            if (trim($_FILES["image"]["name"] != "")) {
                $sql="select photo from user where user_id='".$_POST['id']."'";
                $mydata->imp_sql($sql);
                $photo=$mydata->select_a();
                if(!empty($photo['photo'])){
                $location="photo/".$photo['photo'];
                include 'function/delet_file.php';
                fulldelete($location);
            }
                $upload = new file_upload("image", "photo");
                $image = $upload->upload();
        $data=array($_POST['fname'],$_POST['lname'],$_POST['user_account'],$username,$_POST['admin'],$image);
        $field=array("user_fname","user_lname","user_name","user_account","user_status","photo");
        } else {
        $data=array($_POST['fname'],$_POST['lname'],$_POST['user_account'],$username,$_POST['admin']);  
        $field=array("user_fname","user_lname","user_name","user_account","user_status");
        }
        $table="user";
        $where="user_id=:user_id";
        $execute=array(':user_id' => $_POST['id']);
        
        $check_user=$mydata->update($table, $data, $where, $field, $execute);  
        }
        if($check_user=false){
        echo "<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='?page=content/add_user&ss_id=".$_POST['name']."' >กลับ</a>";
    } else {
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=?page=content/add_user'>";
        }
    }
        
    } elseif (null !== (filter_input(INPUT_GET, 'method'))) {
        $method = filter_input(INPUT_GET, 'method');
        $del_id=  filter_input(INPUT_GET, 'del_id');
        $delete_id=$mydata->sslDec($del_id);
        if($method=='delete_user') {
            $sql="select photo from user where user_id='$delete_id'";
                $mydata->imp_sql($sql);
                $photo=$mydata->select_a();
                if(!empty($photo['photo'])){
                $location="photo/".$photo['photo'];
                include 'function/delet_file.php';
                fulldelete($location);}
        $table="user";
        $where="user_id=:user_id";
        $execute=array(':user_id' => $delete_id);
        $del=$mydata->delete($table, $where, $execute);
        
        if($del=false){
        echo "<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='?page=content/add_user&id=".$delete_id."' >กลับ</a>";
    } else {
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=?page=content/add_user'>";
        }
    }
    }
    ?>
</section>