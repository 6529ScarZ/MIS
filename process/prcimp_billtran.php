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
$take_date_conv = $_POST['st_date'];
$st_date=insert_date($take_date_conv);
$take_date_conv = $_POST['en_date'];
$en_date=insert_date($take_date_conv);
$conn_DBHOS= new EnDeCode();
$read="../connection/conn_DBHosxp.txt";
$conn_DBHOS->para_read($read);
$conn_DBHOS->conn_PDO();
$sql="SELECT 
  '14644' AS Station, '' AS AuthCode, DATE_FORMAT(CONCAT(ov.vstdate,' ',ov.vsttime), '%Y-%m-%d %h:%i:%s') AS DTTran, 
  (SELECT     hospitalcode   FROM    opdconfig   LIMIT 1) AS HCode ,
  vn.vn AS  InvNo,
  IFNULL(r.rcpno,'') AS BillNo,
  vn.hn AS HN,
  '' AS MemberNo,
 CAST(vn.income AS DECIMAL(10,2))  AS  Amount,
 CAST(vn.inc06 AS DECIMAL(10,2)) AS Paid,
  '' AS VerCode ,
  '' AS Tflag  
  
FROM
  vn_stat vn 
  LEFT JOIN rcpt_print r ON vn.vn=r.vn
  JOIN ovst ov ON vn.vn=ov.vn
 WHERE ov.vstdate BETWEEN '$st_date' and '$en_date' and ov.pttype = '23' and isnull (ov.an)
ORDER BY ov.vstdate, ov.vsttime;";
$conn_DBHOS->imp_sql($sql);
$query1=$conn_DBHOS->select();

$sql2="SELECT 
    op.hos_guid,op.vn AS InvNo,
   i2.cscd_group AS BillMuad, 
  CAST(op.sum_price AS DECIMAL(10,2)) AS Amount, 
  '0.00'  AS Paid,DATE_FORMAT(CONCAT(ov.vstdate,' ',ov.vsttime), '%Y-%m-%d %h:%i:%s') AS DTTran
FROM
  opitemrece op 
  LEFT JOIN vn_stat v ON op.vn = v.vn 
	JOIN ovst ov ON v.vn=ov.vn
  LEFT JOIN income i1 ON i1.income=op.income 
  LEFT JOIN income_report2 i2 ON  i1.group2=i2.group_id  
  
WHERE op.vn IN 
  (SELECT 
    ov.vn 
  FROM
    ovst ov 
  WHERE ov.vstdate BETWEEN '$st_date' and '$en_date' and ov.pttype = '23' and isnull (ov.an));";
$conn_DBHOS->imp_sql($sql2);
$query2=$conn_DBHOS->select();
$conn_DBHOS->close_PDO();

$conn_DBMAIN= new EnDeCode();
$read="../connection/conn_DB.txt";
$conn_DBMAIN->para_read($read);
$conn_DBMAIN->conn_PDO();
$conv=new convers_encode();
$count_qr1=count($query1);
for($i=0;$i<$count_qr1;$i++){
    
    $data=array($query1[$i]['Station'],$query1[$i]['AuthCode'],$query1[$i]['DTTran'],$query1[$i]['HCode'],$query1[$i]['InvNo'],$query1[$i]['BillNo'],$query1[$i]['HN'],
        $query1[$i]['MemberNo'],$query1[$i]['Amount'],$query1[$i]['Paid'],$query1[$i]['VerCode'],
            $query1[$i]['Tflag'],0);
    $table="billtran";
    $chk="chk";
if(isset($method) and $method='upd'){
     $where="InvNo= :InvNo && HN= :HN";
     $execute=array(':InvNo' => $query1[$i]['InvNo'], ':HN' => $query1[$i]['HN']);
  $inert_tran=$conn_DBMAIN->update($table, $data, $where, '', $execute);   
 }else{     
 $inert_tran=$conn_DBMAIN->insert_update($table, $data, $chk); }   
}
$count_qr2=count($query2);
for($i=0;$i<$count_qr2;$i++){
    //$PackSize=$conv->tis620_to_utf8($query2[$i]['PackSize']);
    //$sigText=$conv->tis620_to_utf8($query2[$i]['sigText']);
    $data=array($query2[$i]['hos_guid'],$query2[$i]['InvNo'],$query2[$i]['BillMuad'],$query2[$i]['Amount'],$query2[$i]['Paid'],$query2[$i]['DTTran'],0);
    $table="billtran_item";
    $chk="chk";
    if(isset($method) and $method=='upd'){
     $where="hos_guid= :hos_guid";
     $execute=array(':hos_guid' => $query2[$i]['hos_guid']);
     $inert_tranitem=$conn_DBMAIN->update($table, $data, $where,  '', $execute);
    }else{
$inert_tranitem=$conn_DBMAIN->insert_update($table, $data, $chk);  }}

if(($inert_tran and $inert_tranitem)==FALSE){
    echo "<script>alert('การนำเข้าข้อมูลไม่สำเร็จจ้า!')</script>";
}else{
    echo "<script>alert('การนำเข้าข้อมูลสำเร็จแล้วจ้า!')</script>";
}
?>
</body>
<?phpinclude '../footer2.php';?>