<?php session_start(); 
include 'class/TablePDO.php';
include 'class/Export.php';
include 'class/convers_encode.php';?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf8">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" /> 
         </head>

         <body>
             ทดสอบการ export
<?php
//function __autoload($class_name) {
    //include 'class/'.$class_name.'.php';
//}
set_time_limit(0);
$conn_DB= new EnDeCode();
$read="connection/conn_DBHosxp.txt";
$conn_DB->para_read($read);
$conn_DB->conn_PDO();
/*$sql="select * from emppersonal";*/
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
 WHERE ov.vstdate BETWEEN '2016-09-01' and '2016-09-15' and ov.pttype = '23' and isnull (ov.an)
ORDER BY ov.vstdate, ov.vsttime";
$conn_DB->imp_sql($sql);
$query1=$conn_DB->select();
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
'' as claimControl,
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
   WHERE ov.vstdate BETWEEN '2016-09-01' and '2016-09-15' and ov.pttype = '23' and isnull (ov.an) and i2.cscd_group IN(3,4,5) 
ORDER BY ov.vstdate, ov.vsttime
";
$conn_DB->imp_sql($sql2);
$query2=$conn_DB->select();

$conn_DB2= new EnDeCode();
$read="connection/conn_DB.txt";
$conn_DB2->para_read($read);
$conn_DB2->conn_PDO();
$conv=new convers_encode();
for($i=0;$i<count($query1);$i++){
    
    $data=array($query1[$i]['providerID'],$query1[$i]['dispenseID'],$query1[$i]['invoice_no'],$query1[$i]['hn'],$query1[$i]['PID'],$query1[$i]['prescription_date'],$query1[$i]['dispensed_date'],
        $query1[$i]['prescriber'],$query1[$i]['item_count'],$query1[$i]['charg_amount'],$query1[$i]['claim_amount'],
            $query1[$i]['paid_amount'],$query1[$i]['other_amount'],$query1[$i]['reimbuser'],$query1[$i]['benefit_plan'],$query1[$i]['dispense_status'],0);
    $table="billdisp";
    $chk="chk";
$conn_DB2->insert_update($table, $data, $chk);    
}
for($i=0;$i<count($query2);$i++){
    $PackSize=$conv->tis620_to_utf8($query2[$i]['PackSize']);
    $sigText=$conv->tis620_to_utf8($query2[$i]['sigText']);
    $data=array($query2[$i]['hos_guid'],$query2[$i]['dispenseID'],$query2[$i]['productCategory'],$query2[$i]['HospitalDrugID'],$query2[$i]['drugID'],$query2[$i]['dfsCode'],$query2[$i]['dfstext'],$PackSize,
            $query2[$i]['singcode'],$sigText,$query2[$i]['quantity'],$query2[$i]['UnitPrice'],$query2[$i]['Chargeamount'],$query2[$i]['ReimbPrice'],$query2[$i]['ReimbAmount']
            ,$query2[$i]['ProDuctselectionCode'],$query2[$i]['refill'],$query2[$i]['claimControl'],$query2[$i]['ClaimCategory'],$query2[$i]['prescription_date'],0);
    $table="billdisp_item";
    $chk="chk";
$conn_DB2->insert_update($table, $data, $chk);    
}
?>
             <a href="test_export.php" class="btn btn-primary"><i class="fa fa-print"></i> Export TXT</a> 
             <?php 
             echo "<pre>".print_r($query2,TRUE)."</pre>";?>
         </body>
</html>