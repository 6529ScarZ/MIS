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
$take_date_conv = $_POST['st_date'];
$st_date=insert_date($take_date_conv);
$take_date_conv = $_POST['en_date'];
$en_date=insert_date($take_date_conv);
$conn_DB= new EnDeCode();
$read="../connection/conn_DB.txt";
$conn_DB->para_read($read);
$conn_DB->conn_PDO();

$sql="SELECT Station,AuthCode,DTTran,HCode,InvNo,BillNo,HN,MemberNo,Amount,Paid,VerCode,Tflag
FROM billtran
WHERE SUBSTR(DTTran,1,10) BETWEEN '$st_date' AND '$en_date' order by DTTran asc";
$query1=$conn_DB->query($sql);
$sql2="SELECT InvNo,BillMuad,Amount,Paid
FROM billtran_item
WHERE SUBSTR(DTTran,1,10) BETWEEN '$st_date' AND '$en_date' ORDER BY DTTran ASC";

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