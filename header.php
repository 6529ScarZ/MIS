<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ระบบจัดการสารสนเทศโรงพยาบาล</title>
    <LINK REL="SHORTCUT ICON" HREF="<?= $fol.$pic?>">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="bootstrap/css/lightbox.css" type="text/css" media="screen" /> zoom เท่ๆ
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/font-awesome-4.6.3/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- Date Picker -->
    <!--<link rel="stylesheet" href="plugins/jquery-ui-1.12.1/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="plugins/jquery-ui-1.12.1/external/jquery/jquery.js"></script>
    <script src="plugins/jquery-ui-1.12.1/jquery-ui.js"></script>
    <!-- Daterange picker -->
    <!--<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="plugins/excellentexport.js"></script>
    <link rel="stylesheet" href="bootstrap/site.css">
    <!--date picker-->
    <script src="plugins/jquery-ui-1.11.4.custom/jquery-1.12.3.js"></script>
    <script src="plugins/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom.js"></script>
    <link rel="stylesheet" href="plugins/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom.css" />
    <link rel="stylesheet" href="plugins/jquery-ui-1.11.4.custom/SpecialDateSheet.css" />
    
        <!--<script src="bootstrap/js/prototype.js" type="text/javascript"></script>
	<script src="bootstrap/js/scriptaculous.js?load=effects" type="text/javascript"></script>
	<script src="bootstrap/js/lightbox.js" type="text/javascript"></script> zoom เท่ๆ-->

<?php  include 'plugins/jquery-ui-1.11.4.custom/DatepickerThai4.php';?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
		function popup(url,name,windowWidth,windowHeight){    
				myleft=(screen.width)?(screen.width-windowWidth)/2:100;	
				mytop=(screen.height)?(screen.height-windowHeight)/2:100;	
				properties = "width="+windowWidth+",height="+windowHeight;
				properties +=",scrollbars=yes, top="+mytop+",left="+myleft;   
				window.open(url,name,properties);
	}
</script>
<script type="text/javascript">
                    function inputDigits(sensor) {
                        var regExp = /[0-9.-/]$/;
                        if (!regExp.test(sensor.value)) {
                            alert("กรอกตัวเลขเท่านั้นครับ");
                            sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                        }
                    }
                </script>
                <!--scrip check ตัวอักษร-->
                <script type="text/javascript">
                    function inputString(sensor) {
                        var regExp = /[A-Za-zก-ฮะ-็่-๋์/]$/;
                        if (!regExp.test(sensor.value)) {
                            alert("กรอกตัวอักษรเท่านั้นครับ");
                            sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                        }
                    }

                </script>
                <script type="text/javascript">
function nextbox(e, id) {
    var keycode = e.which || e.keyCode;
    if (keycode == 13) {
        document.getElementById(id).focus();
        return false;
    }
}
</script>
<script>
var nW,nH,oH,oW;
function zoomToggle(iWideSmall,iHighSmall,iWideLarge,iHighLarge,whichImage){
oW=whichImage.style.width;oH=whichImage.style.height;
if((oW==iWideLarge)||(oH==iHighLarge)){
nW=iWideSmall;nH=iHighSmall;}else{
nW=iWideLarge;nH=iHighLarge;}
whichImage.style.width=nW;whichImage.style.height=nH;
}
</script>
  </head>
  <?php
                     if (null !==(filter_input(INPUT_GET, 'popup'))){
                      $popup=  filter_input(INPUT_GET, 'popup');
                      $popup_name=  filter_input(INPUT_GET, 'popname');
                      $id= filter_input(INPUT_GET, 'id',FILTER_SANITIZE_ENCODED);  
                      $date=  filter_input(INPUT_GET, 'date');
                      $cod_popup="window.open('content/pop_$popup_name.php?date=$date&id=$id','','width=470,height=450'); return false;";
                     }

                     function insert_date($take_date_conv,$take_date)
                    {
                        $take_date=explode("-",$take_date_conv);
			 $take_date_year=$take_date[2]-543;
			 $take_date="$take_date_year-$take_date[1]-$take_date[0]";
                         return $take_date;
                    }
?>