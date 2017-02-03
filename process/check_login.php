<?php
session_save_path("../session/");
session_start(); 
include '../header2.php';?>
<script language="JavaScript" type="text/javascript"> 
var StayAlive = 1; // เวลาเป็นวินาทีที่ต้องการให้ WIndows เปิดออก 
function KillMe()
{ 
setTimeout("self.close()",StayAlive * 1000); 
} 
</script>
<body class="hold-transition skin-green fixed sidebar-mini" onLoad="KillMe();self.focus();window.opener.location.reload();">
      <section class="content">
<?php
 //require_once '../class/dbPDO_mng.php';
function __autoload($class_name) {
    include_once '../class/'.$class_name.'.php';
}

$user_account = md5(trim(filter_input(INPUT_POST, 'user_account',FILTER_SANITIZE_ENCODED)));
$user_pwd = md5(trim(filter_input(INPUT_POST, 'user_pwd',FILTER_SANITIZE_ENCODED)));
// using PDO
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>
<div class='alert alert-dismissable alert-success'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div>
<?php
$dbh=new dbPDO_mng();
$read="../connection/conn_DB.txt";
$dbh->para_read($read);
$dbh->conn_PDO();
//$dbh->getDb();
$sql = "select u.user_id as id,concat(u.user_fname,' ',u.user_lname) as fullname,u.user_status as Status 
    from user u
           where u.user_account = :user_account AND u.user_pwd = :user_pwd";
$execute=array(':user_account' => $user_account, ':user_pwd' => $user_pwd);
$dbh->imp_sql($sql);
$result=$dbh->select_a($execute);

if ($result) {
    $_SESSION['user_mis'] = $result['id'];
    $_SESSION['fullname_mis'] = $result['fullname'];
    $_SESSION['status_mis'] = $result['Status'];
    
$date = new DateTime(null, new DateTimeZone('Asia/Bangkok'));//กำหนด Time zone
$date_login = $date->format('Y-m-d H:i:s');
$time_login = time();

                $table = "user";
                $data = array($date_login,$time_login);
                $field = array("date_login","time_login");
                $where = "user_account= :user_account && user_pwd= :user_pwd";
                $execute = array(':user_account' => $user_account, ':user_pwd' => $user_pwd);
                $edit_address = $dbh->update($table, $data, $where, $field, $execute);
}else{
	echo "<script>alert('ชื่อหรือรหัสผ่านผิด กรุณาตรวจสอบอีกครั้ง!')</script>";
    echo "<meta http-equiv='refresh' content='0;url=../login_page.php'>";
    exit();
}

?>
        </section>
<?phpinclude '../footer2.php';?>