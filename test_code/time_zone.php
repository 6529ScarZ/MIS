<?php
include 'funcDateThai.php';
date_default_timezone_set('Asia/Bangkok');
$time = date("Y-m-d H:m:s");
echo DateTimeThai($time).'<br>';
$eng_date=time(); // แสดงวันที่ปัจจุบัน
echo thai_date($eng_date).'<br>';
//$time = date_default_timezone_set('Asia/Bangkok');
echo date("H:m:s").'<br>';
echo $time;
