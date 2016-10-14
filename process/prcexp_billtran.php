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
        <body onLoad="KillMe();self.focus();window.opener.location.reload();">
            <DIV  align='center'><IMG src='../images/tororo_hero.gif' width='200'></div>
<?php
function __autoload($class_name) {
    include '../class/'.strtolower($class_name).'.php';
}
$conn_DB= new EnDeCode();
$read="../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->conn_PDO();

$check_ps=$_POST['check_ps'];
$values='';
$values2='';
$id='';
$InvNo='';
$i=0;
foreach ($check_ps as $key => $value) {
        $id[$value] = $conn_DB->sslDec($_POST['id'][$value]);
        $InvNo[$value]=$_POST['InvNo'][$value];
        if ($i != 0) {
                $values.=", ";
                $values2.=", ";
            }
            $values.="$id[$value]";
            $values2.="'$InvNo[$value]'";
            $i++;
        }
$sql="SELECT Station,AuthCode,DTTran,HCode,InvNo,BillNo,HN,MemberNo,Amount,Paid,VerCode,Tflag
FROM billtran
WHERE billtran_id in($values) order by DTTran asc";
$query1=$conn_DB->query($sql);
$sql2="SELECT InvNo,BillMuad,Amount,Paid
FROM billtran_item
WHERE InvNo in($values2) ORDER BY DTTran ASC";

$query2=$conn_DB->query($sql2);
$name="BILLTRAN".date("ymd");
$path="../file_export/";
$filName=$path.$name;
$symbol="|";
$export= new Export($filName, $symbol, $query1, $query2);
$export->Export_TXT_billtran();
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