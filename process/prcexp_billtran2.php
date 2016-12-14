<?php
session_save_path("../session/");
session_start(); include '../header2.php';
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
if(!empty($_POST['method']) and $_POST['method']=='exp_total'){
    $take_date_conv = $_POST['st_date'];
    $st_date=insert_date($take_date_conv);
    $take_date_conv = $_POST['en_date']; 
    $en_date=insert_date($take_date_conv);
    $code_where1="SUBSTR(DTTran,1,10) BETWEEN '$st_date' AND '$en_date'";
    $code_where2="SUBSTR(DTTran,1,10) BETWEEN '$st_date' AND '$en_date'";
} else if(!empty($_POST['method']) and $_POST['method']=='exp_select'){
$values='';
$values2='';
$id='';
$InvNo='';
$check=count($_SESSION['id']);
foreach ($_SESSION['id'] as $key => $value) {
        if (($key > 0 and $key<($check))) {
                $values.=", ";
            }
            $values.="$value";
}
foreach ($_SESSION['InvNo'] as $key => $value) {
        if (($key > 0 and $key<($check))) {
                $values2.=", ";
            }
            $values2.="$value";
       
        }
  $code_where1="billtran_id in($values)";
    $code_where2="InvNo in($values2)";

}//echo $values.'<br>'.$values2.$values3.'<br>';
$sql="SELECT Station,AuthCode,DTTran,HCode,InvNo,BillNo,HN,MemberNo,Amount,Paid,VerCode,Tflag
FROM billtran
WHERE $code_where1 order by DTTran asc";
//echo $sql.'<br>';
$query1=$conn_DB->query($sql);
$sql2="SELECT InvNo,BillMuad,Amount,Paid
FROM billtran_item
WHERE $code_where2 ORDER BY DTTran ASC";
//echo $sql2;
$query2=$conn_DB->query($sql2);
$name="BILLTRAN".date("Ymd");
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
    unset($_SESSION['id']);
    unset($_SESSION['InvNo']);
    exit();
}
?>
</body>
<?php include '../footer2.php';?>