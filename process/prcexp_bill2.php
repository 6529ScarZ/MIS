<?php include '../header2.php';
ignore_user_abort(1); // run script in background
set_time_limit(180);
?>
<script language="JavaScript" type="text/javascript">
            var StayAlive = 9; // เวลาเป็นวินาทีที่ต้องการให้ WIndows เปิดออก 
            function KillMe()
            {
                setTimeout("self.close()", StayAlive * 1000);
            }
        </script>
        <!--<body onLoad="KillMe();self.focus();window.opener.location.reload();">--><body>
            <DIV  align='center'><IMG src='../images/tororo_hero.gif' width='200'></div>
<?php
function __autoload($class_name) {
    include '../class/'.strtolower($class_name).'.php';
}
$conn_DB= new EnDeCode();
$read="../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->conn_PDO();
if(!empty($_POST['method']) and $_POST['method']=='exp_total'){
    $take_date_conv = $_POST['st_date'];
    $st_date=insert_date($take_date_conv);
    $take_date_conv = $_POST['en_date']; 
    $en_date=insert_date($take_date_conv);
    $code_where1="SUBSTR(prescription_date,1,10) BETWEEN '$st_date' AND '$en_date'";
    $code_where2="SUBSTR(prescription_date,1,10) BETWEEN '$st_date' AND '$en_date'";
}
if(!empty($_POST['check_ps'])){
$check_ps=$_POST['check_ps'];
$values='';
$values2='';
$values3='';
$values4='';
$id='';
$dispenseID='';
$i=0;
$check=count($check_ps);
foreach ($check_ps as $key => $value) {
        $id[$key] = $_POST['id'][$value];
        $dispenseID[$value]=$_POST['1dispenseID'][$value];
        if (($i > 0 and $i<($check)) and strlen($values)<=980) {
                $values.=", ";
            }elseif (($i > 0 and $i<($check)) and strlen($values)>=980) {
                $values.=", ";
            }
            $values.="$id[$key]";
        if(strlen($values2)<980){
        if ($i != 0) {
                $values2.=", ";
            }
            $values2.="'$dispenseID[$value]'";
        }elseif(strlen($values2)>=980 and strlen($values3)<980){
        if ($i != 0) {
                $values3.=", ";
            }
            $values3.="'$dispenseID[$value]'";    
        }elseif (strlen($values3)>=980 and strlen($values4)<980) {
        if ($i != 0) {
                $values4.=", ";
            }
            $values4.="'$dispenseID[$value]'";  
    }   
            $i++;
        }
  
  $code_where1="billdisp_id in($values)";
        $code_where2="dispenseID in($values2$values3$values4)";

}
$sql="SELECT providerID,dispenseID,invoice_no,hn,PID,
CONCAT(SUBSTR(prescription_date,1,10),'T',SUBSTR(prescription_date,12,18))prescription_date,
CONCAT(SUBSTR(dispensed_date,1,10),'T',SUBSTR(dispensed_date,12,18))dispensed_date,
prescriber,item_count,charg_amount,claim_amount,paid_amount,other_amount,reimbuser,
benefit_plan,dispense_status
FROM billdisp
WHERE $code_where1 order by prescription_date asc";
echo $sql.'<br>';
$query1=$conn_DB->query($sql);

$sql2="SELECT dispenseID,productCategory,HospitalDrugID,drugID,dfsCode,dfstext,PackSize,singcode,
sigText,quantity,UnitPrice,Chargeamount,ReimbPrice,ReimbAmount,ProDuctselectionCode,refill,
claimControl,ClaimCategory
FROM billdisp_item
WHERE $code_where2 ORDER BY prescription_date ASC";
echo $sql2.'<br>';
$query2=$conn_DB->query($sql2);
$name="BILLDISP".date("Ymd");
$path="../file_export/";
$filName=$path.$name;
$symbol="|";
$export= new Export($filName, $symbol, $query1, $query2);
$export->Export_TXT_billdisp();
if($export==FALSE){
   echo "<script>alert('การส่งออกข้อมูลไม่สำเร็จจ้า!')</script>";  
} else {  
    echo "<script>alert('การส่งออกข้อมูลสำเร็จแล้วจ้า!')</script>";
    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=file_download.php?name=$name&path=$path'>";
    exit();
}
?>
</body>
<?phpinclude '../footer2.php';?>