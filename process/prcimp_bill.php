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
(SELECT hospitalcode FROM opdconfig LIMIT 1 ) AS providerID,
  CONCAT(ov.vn,RIGHT(CONCAT('000',ov.doctor),3))AS dispenseID,
  ov.vn  AS invoice_no ,
  ov.hn,
  pt.cid AS PID, 
 CONCAT( ov.vstdate,' ',ov.vsttime) AS prescription_date ,
 IFNULL(CONCAT(ov.vstdate,'T',st.service16),REPLACE((DATE_ADD(CONCAT(ov.vstdate,'T',st.service12),INTERVAL 1 MINUTE )),' ',' ') )AS dispensed_date,
  (SELECT  CONCAT('ว',d.licenseno) as p FROM doctor d WHERE d.code=ov.doctor) AS prescriber,
  (SELECT COUNT(*) FROM  opitemrece o LEFT OUTER JOIN income i  ON o.income = i.income LEFT OUTER JOIN income_report2 i2 ON i.group2=i2.group_id  WHERE o.vn=ov.vn AND i2.cscd_group IN(3,4,5)) AS item_count,
  IFNULL(CAST((SELECT sum(o.sum_price) FROM  opitemrece o LEFT OUTER JOIN income i  ON o.income = i.income LEFT OUTER JOIN income_report2 i2 ON i.group2=i2.group_id  WHERE o.vn=ov.vn AND i2.cscd_group IN(3,4,5)) AS DECIMAL(10,2)),'0.00') AS charg_amount,
  IFNULL(CAST((SELECT sum(o.sum_price) FROM  opitemrece o LEFT OUTER JOIN income i  ON o.income = i.income LEFT OUTER JOIN income_report2 i2 ON i.group2=i2.group_id  WHERE o.vn=ov.vn AND i2.cscd_group IN(3,4,5) AND o.paidst='02' ) AS DECIMAL(10,2)),'0.00') AS claim_amount,
  IFNULL(CAST((SELECT sum(o.sum_price) FROM  opitemrece o LEFT OUTER JOIN income i  ON o.income = i.income LEFT OUTER JOIN income_report2 i2 ON i.group2=i2.group_id  WHERE o.vn=ov.vn AND i2.cscd_group IN(3,4,5) AND o.paidst='03' ) AS DECIMAL(10,2)),'0.00') AS paid_amount,
  CAST(0 AS DECIMAL(10,2)) AS other_amount,
  'HP' AS reimbuser,
  'CS' AS benefit_plan,
  '1' AS dispense_status
  
FROM
  ovst ov 
  LEFT OUTER JOIN patient pt 
    ON pt.hn = ov.hn 
  LEFT OUTER JOIN kskdepartment sp 
    ON sp.depcode = ov.cur_dep 
  LEFT OUTER JOIN vn_stat vt 
    ON vt.vn = ov.vn 
   LEFT OUTER JOIN service_time st ON ov.vn=st.vn 
 WHERE ov.vstdate BETWEEN '$st_date' and '$en_date' and ov.pttype = '23' and isnull (ov.an)
ORDER BY ov.vstdate, ov.vsttime";
$conn_DBHOS->imp_sql($sql);
$query1=$conn_DBHOS->select();

$sql2="SELECT 
  op.hos_guid,   
  CONCAT(ov.vn,RIGHT(CONCAT('000',ov.doctor),3))AS dispenseID,
  '1' as productCategory ,op.icode as HospitalDrugID ,
  t1.tpu_code as drugID,
  t1.strength as dfsCode,
   concat(d.name,' ',d.strength) as dfstext,
 d.units as PackSize,
 op.drugusage as singcode,
 d1.name1 as sigText,
 op.qty as quantity,
 op.unitprice as UnitPrice,
  op.sum_price as Chargeamount,
 op.unitprice as ReimbPrice,
 op.sum_price as ReimbAmount,
'' as ProDuctselectionCode,
'' as refill,
opn.presc_reason as claimControl,
'' as ClaimCategory,
CONCAT( ov.vstdate,' ',ov.vsttime) AS prescription_date
 
  
FROM
  opitemrece op 
  LEFT OUTER JOIN ovst ov on ov.vn = op.vn
  LEFT OUTER JOIN patient pt ON pt.hn = ov.hn 
  LEFT OUTER JOIN kskdepartment sp ON sp.depcode = ov.cur_dep 
  LEFT OUTER JOIN vn_stat vt ON vt.vn = ov.vn 
   LEFT OUTER JOIN service_time st ON ov.vn=st.vn 
  LEFT OUTER JOIN income i  ON op.income = i.income
  LEFT OUTER JOIN income_report2 i2 ON i.group2=i2.group_id
  LEFT OUTER JOIN drugitems d on op.icode = d.icode
  left outer join tmt_tpu_code t1 on d.tpu_code_list = t1.tpu_code
  left outer join drugusage d1 on op.drugusage = d1.drugusage
  LEFT OUTER JOIN ovst_presc_ned opn ON opn.vn=op.vn and opn.icode=op.icode
   WHERE ov.vstdate BETWEEN '$st_date' and '$en_date' and ov.pttype = '23' and isnull (ov.an) and i2.cscd_group IN(3,4,5) 
ORDER BY ov.vstdate, ov.vsttime
";
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
    
    $data=array($query1[$i]['providerID'],$query1[$i]['dispenseID'],$query1[$i]['invoice_no'],$query1[$i]['hn'],$query1[$i]['PID'],$query1[$i]['prescription_date'],$query1[$i]['dispensed_date'],
        $query1[$i]['prescriber'],$query1[$i]['item_count'],$query1[$i]['charg_amount'],$query1[$i]['claim_amount'],
            $query1[$i]['paid_amount'],$query1[$i]['other_amount'],$query1[$i]['reimbuser'],$query1[$i]['benefit_plan'],$query1[$i]['dispense_status'],0);
    $table="billdisp";
    $chk="chk";
 if(isset($method) and $method='upd'){
     $where="dispenseID= :dispenseID && invoice_no= :invoice_no && hn= :hn";
     $execute=array(':dispenseID' => $query1[$i]['dispenseID'], ':invoice_no' => $query1[$i]['invoice_no'], ':hn' =>$query1[$i]['hn']);
  $inert_disp=$conn_DBMAIN->update($table, $data, $where, '', $execute);   
 }else{ 
 $inert_disp=$conn_DBMAIN->insert_update($table, $data, $chk);  }  
}
$count_qr2=count($query2);
for($i=0;$i<$count_qr2;$i++){
    $PackSize=$conv->tis620_to_utf8($query2[$i]['PackSize']);
    $sigText=$conv->tis620_to_utf8($query2[$i]['sigText']);
    $data=array($query2[$i]['hos_guid'],$query2[$i]['dispenseID'],$query2[$i]['productCategory'],$query2[$i]['HospitalDrugID'],$query2[$i]['drugID'],$query2[$i]['dfsCode'],$query2[$i]['dfstext'],$PackSize,
            $query2[$i]['singcode'],$sigText,$query2[$i]['quantity'],$query2[$i]['UnitPrice'],$query2[$i]['Chargeamount'],$query2[$i]['ReimbPrice'],$query2[$i]['ReimbAmount']
            ,$query2[$i]['ProDuctselectionCode'],$query2[$i]['refill'],$query2[$i]['claimControl'],$query2[$i]['ClaimCategory'],$query2[$i]['prescription_date'],0);
    $table="billdisp_item";
    $chk="chk";
    if(isset($method) and $method=='upd'){
     $where="hos_guid= :hos_guid";
     $execute=array(':hos_guid' => $query2[$i]['hos_guid']);
     $inert_dispitem=$conn_DBMAIN->update($table, $data, $where,  '', $execute);
    }else{
    $inert_dispitem=$conn_DBMAIN->insert_update($table, $data, $chk);  }}

if(($inert_disp and $inert_dispitem)==FALSE){
    echo "<script>alert('การนำเข้าข้อมูลไม่สำเร็จจ้า!')</script>";
}else{
    echo "<script>alert('การนำเข้าข้อมูลสำเร็จแล้วจ้า!')</script>";
}
?>
</body>
<?phpinclude '../footer2.php';?>