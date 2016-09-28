<?php session_start(); 
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
 require '../class/dbPDO_mng.php';
$user_account = md5(trim(filter_input(INPUT_POST, 'user_account',FILTER_SANITIZE_ENCODED)));
$user_pwd = md5(trim(filter_input(INPUT_POST, 'user_pwd',FILTER_SANITIZE_ENCODED)));
// using PDO

echo	 "<p>&nbsp;</p>	"; 
echo	 "<p>&nbsp;</p>	";
echo "<div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>";
echo "<div class='alert alert-dismissable alert-success'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div>";
$dbh=new DbPDO_mng();
$read="../connection/conn_DB.txt";
$dbh->para_read($read);
$dbh->conn_PDO();
$db=$dbh->getDb();
$sql = "select m1.Name as id,concat(e1.firstname,' ',e1.lastname) as fullname,e1.depid as dep,m1.Status as Status from member m1 
           inner join emppersonal e1 on m1.Name=e1.empno
           inner join department d1 on e1.depid=d1.depId
           inner join posid p1 on e1.posid=p1.posId
           where m1.Username = :user_account AND m1.Password = :user_pwd";
$execute=array(':user_account' => $user_account, ':user_pwd' => $user_pwd);
$dbh->imp_sql($sql);
$result=$dbh->select($execute);

if ($result) {
    $_SESSION['user'] = $result[0]['id'];
    $_SESSION['fullname'] = $result[0]['fullname'];
    $_SESSION['Status'] = $result[0]['Status'];
$date = new DateTime(null, new DateTimeZone('Asia/Bangkok'));//กำหนด Time zone
$date_login=$date->format('Y-m-d');
$time_login=$date->format('H:m:s');

                $table = "member";
                $data = array($date_login,$time_login);
                $field = array("date_login","time_login");
                $where = "Username= :user_account && Password= :user_pwd";
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