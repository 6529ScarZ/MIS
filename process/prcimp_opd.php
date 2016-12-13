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
$year = isset($_POST['txt_year']) ? filter_input(INPUT_POST,'txt_year') : '';
$month = isset($_POST['txt_month']) ? filter_input(INPUT_POST,'txt_month') : '';


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

$sql2="select SUBSTR(a.vstdate,1,7) as vstmonth,i.code3,count(a.pdx) as pdx_count ,i.name as icdname 
from vn_stat a 
left outer join icd101 i on i.code=a.pdx
where SUBSTR(a.vstdate,1,7) LIKE '$year-$month%'
and a.pdx<>'' and a.pdx is not null 
group by i.code3 
order by pdx_count desc 
limit 10
";
$conn_DBHOS->imp_sql($sql2);
$query2=$conn_DBHOS->select();

$sql3="select SUBSTR(ov.vstdate,1,7) as vstmonth,IF((SUBSTR(ov.aid,1,2)in(42,41,67,39,43)),SUBSTR(ov.aid,1,2),'00') as province,
COUNT(ov.hn) as count_patient
from vn_stat ov ,patient pt ,ovst ovst 
where  ov.vn=ovst.vn and pt.hn=ov.hn and ov.hn=pt.hn 
 and SUBSTR(ov.vstdate,1,7) LIKE '$year-$month%'
 and ov.age_y>= 0 
 and ov.age_y<= 200 
GROUP BY province ORDER BY count_patient desc;";
$conn_DBHOS->imp_sql($sql3);
$query3=$conn_DBHOS->select();

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
     $execute=array(':vstmonth' => "$year-$month");
  $inert_opd=$conn_DBMAIN->update($table, $data, $where, $field, $execute);   
 }else{ 
     $data=array($query1[$i]['vstmonth'],$query1[$i]['man'],$query1[$i]['woman'],date("Y-m-d H:m:s"),date("Y-m-d H:m:s"),0);
 $inert_opd=$conn_DBMAIN->insert_update($table, $data, $chk);  }  
}
$count_qr2=count($query2);
for($i=0;$i<$count_qr2;$i++){
    $icdname=$conv->tis620_to_utf8($query2[$i]['icdname']);
    $table="opd_report_10dxg";
    $chk="chk";
    if(isset($method) and $method=='upd'){
     $data=array($query2[$i]['code3'],$query2[$i]['pdx_count'],$icdname,date("Y-m-d H:m:s"),0);    
     $where="substr(vstmonth,1,7)= :vstmonth and 10dxg_code= :10dxg_code";
     $field=array("10dxg_code","dx_count","icdname","update_date","chk");
     $execute=array(':vstmonth' => "$year-$month", ':10dxg_code' => $query2[$i]['code3']);
     $inert_10dxg=$conn_DBMAIN->update($table, $data, $where, $field, $execute);
    }else{
        $vstmonth=$query2[$i]['vstmonth'].'-01';
     $data=array($vstmonth,$query2[$i]['code3'],$query2[$i]['pdx_count'],$icdname,date("Y-m-d H:m:s"),date("Y-m-d H:m:s"),0);
    $inert_10dxg=$conn_DBMAIN->insert_update($table, $data, $chk);  }}
    $count_qr3=count($query3);
    for($i=0;$i<$count_qr3;$i++){
    $table="opd_report_5prov";
    $chk="chk";
    if(isset($method) and $method=='upd'){
     $data=array($query3[$i]['count_patient'],date("Y-m-d H:m:s"),0);    
     $where="substr(vstmonth,1,7)= :vstmonth and PROVINCE_CODE= :province";
     $field=array("count_patient","update_date","chk");
     $execute=array(':vstmonth' => "$year-$month", ':province' => $query3[$i]['province']);
     $inert_5prov=$conn_DBMAIN->update($table, $data, $where, $field, $execute);
    }else{
        $vstmonth=$query3[$i]['vstmonth'].'-01';
     $data=array($vstmonth,$query3[$i]['province'],$query3[$i]['count_patient'],date("Y-m-d H:m:s"),date("Y-m-d H:m:s"),0);
    $inert_5prov=$conn_DBMAIN->insert_update($table, $data, $chk);  }}

if(($inert_opd and $inert_10dxg and $inert_5prov)==FALSE){
    echo "<script>alert('การนำเข้าข้อมูลไม่สำเร็จจ้า!')</script>";
}else{
    echo "<script>alert('การนำเข้าข้อมูลสำเร็จแล้วจ้า!')</script>";
}
}
?>
</body>
<?phpinclude '../footer2.php';?>