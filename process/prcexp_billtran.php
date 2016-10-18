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
if(!empty($_POST['method']) and $_POST['method']=='exp_total'){
    $take_date_conv = $_POST['st_date'];
    $st_date=insert_date($take_date_conv);
    $take_date_conv = $_POST['en_date']; 
    $en_date=insert_date($take_date_conv);
    $code_where1="SUBSTR(DTTran,1,10) BETWEEN '$st_date' AND '$en_date'";
    $code_where2="SUBSTR(DTTran,1,10) BETWEEN '$st_date' AND '$en_date'";
}
if(!empty($_POST['check_ps'])){
$check_ps=$_POST['check_ps'];
if(!empty($_POST['check_ps2'])){
$check_ps2=$_POST['check_ps2']; 
$values1='';
$values5='';
$values6='';
$values7='';
$id2='';
$InvNo2='';
}
$values='';
$values2='';
$values3='';
$values4='';
$id='';
$InvNo='';
$i=0;
$check=count($check_ps);
foreach ($check_ps as $key => $value) {
        $id[$value] = $conn_DB->sslDec($_POST['id'][$value]);
        $InvNo[$value]=$_POST['1InvNo'][$value];
        if ($i > 0 and $value<=($check)) {
                $values.=", ";
            }
            $values.="$id[$value]";
        if(strlen($values2)<980){
        if ($i != 0) {
                $values2.=", ";
            }
            $values2.="'$InvNo[$value]'";
        }elseif(strlen($values2)>=980 and strlen($values3)<980){
        if ($i != 0) {
                $values3.=", ";
            }
            $values3.="'$InvNo[$value]'";    
        }elseif (strlen($values3)>=980 and strlen($values4)<980) {
        if ($i != 0) {
                $values4.=", ";
            }
            $values4.="'$InvNo[$value]'";  
    }
            $i++;
        }
if(!empty($_POST['check_ps2'])){  
        foreach ($check_ps2 as $key => $value) {
        $id2[$value] = $conn_DB->sslDec($_POST['id2'][$value]);
        $InvNo2[$value]=$_POST['2InvNo'][$value];
        if ($i > 0) {
                $values1.=", ";
            }
            $values1.="$id2[$value]";
        if(strlen($values5)<980){
        if ($i != 0) {
                $values5.=", ";
            }
            $values5.="'$InvNo2[$value]'";
        }elseif(strlen($values5)>=980 and strlen($values6)<980){
        if ($i != 0) {
                $values6.=", ";
            }
            $values6.="'$InvNo2[$value]'";    
        }elseif (strlen($values6)>=980 and strlen($values7)<980) {
        if ($i != 0) {
                $values7.=", ";
            }
            $values7.="'$InvNo2[$value]'";  
    }
            $i++;
        }
    $code_where1="billtran_id in($values$values1)";
    $code_where2="InvNo in($values2$values3$values4$values5$values6$values7)";   
} else{  $code_where1="billtran_id in($values)";
    $code_where2="InvNo in($values2$values3$values4)";
}
}
$sql="SELECT Station,AuthCode,DTTran,HCode,InvNo,BillNo,HN,MemberNo,Amount,Paid,VerCode,Tflag
FROM billtran
WHERE $code_where1 order by DTTran asc";
$query1=$conn_DB->query($sql);
$sql2="SELECT InvNo,BillMuad,Amount,Paid
FROM billtran_item
WHERE $code_where2 ORDER BY DTTran ASC";

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