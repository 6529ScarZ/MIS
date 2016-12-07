<?php include '../header2.php';
ignore_user_abort(1); // run script in background
set_time_limit(180);
ini_set('max_execution_time', 0);?>
<script language="JavaScript" type="text/javascript">
            var StayAlive = 1; // เวลาเป็นวินาทีที่ต้องการให้ WIndows เปิดออก 
            function KillMe()
            {
                setTimeout("self.close()", StayAlive * 1000);
            }
        </script>
        <body onLoad="KillMe();self.focus();window.opener.location.reload();">
            <DIV  align='center'><IMG src='../images/tororo_hero.gif' width='200'></div>
<?php
function __autoload($class_name) {
    include '../class/'.strtolower($class_name).'.php';
}
if (null !== (filter_input(INPUT_POST, 'method'))) {  
    $method=filter_input(INPUT_POST, 'method');
}
if (isset($_POST['txt_year']) and isset($_POST['txt_month'])) {
$year = isset($_POST['txt_year']) ? mysql_real_escape_string($_POST['txt_year']) : '';
$month = isset($_POST['txt_month']) ? mysql_real_escape_string($_POST['txt_month']) : '';


$conn_DBHOS= new EnDeCode();
$read="../connection/conn_DBHosxp.txt";
$conn_DBHOS->para_read($read);
$conn_DBHOS->conn_PDO();
$sql="SELECT SUBSTR(ov.vstdate,1,7) AS vstmonth,
(select COUNT(ov.vn ) from vn_stat ov where ov.sex='1' and ov.vstdate LIKE '$year-$month%') as man,
(select COUNT(ov.vn ) from vn_stat ov where ov.sex='2' and ov.vstdate LIKE '$year-$month%') as woman
from vn_stat ov ,patient pt ,ovst ovst 
where  ov.vn=ovst.vn and pt.hn=ov.hn  and ov.hn=pt.hn and ov.vstdate LIKE '$year-$month%'
 and ov.age_y>= 0 
 and ov.age_y<= 200 
GROUP BY SUBSTR(ov.vstdate,1,7)";
$conn_DBHOS->imp_sql($sql);
$query1=$conn_DBHOS->select();

$conn_DBHOS->close_PDO();

$conn_DBMAIN= new EnDeCode();
$read="../connection/conn_DB.txt";
$conn_DBMAIN->para_read($read);
$conn_DBMAIN->conn_PDO();
$conv=new convers_encode();
$count_qr1=count($query1);
for($i=0;$i<$count_qr1;$i++){
    $table="opd_report";
    $chk="chk";
 if(isset($method) and $method=='upd'){
     $data=array($query1[$i]['man'],$query1[$i]['woman'],date("Y-m-d H:m:s"),0);
     $where="vstmonth= :vstmonth";
     $field=array("man","woman","update_date","chk");
     $execute=array(':vstmonth' => $query1[$i]['vstmonth']);
  $inert_opd=$conn_DBMAIN->update($table, $data, $where, $field, $execute);   
 }else{ 
     $data=array($query1[$i]['vstmonth'],$query1[$i]['man'],$query1[$i]['woman'],date("Y-m-d H:m:s"),date("Y-m-d H:m:s"),0);
 $inert_opd=$conn_DBMAIN->insert_update($table, $data, $chk);  }  
}

if(($inert_opd)==FALSE){
    echo "<script>alert('การนำเข้าข้อมูลไม่สำเร็จจ้า!')</script>";
}else{
    echo "<script>alert('การนำเข้าข้อมูลสำเร็จแล้วจ้า!')</script>";
}
}
?>
</body>
<?phpinclude '../footer2.php';?>