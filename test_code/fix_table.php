
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Fix Table Head</title>
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
</head>
<body>
        <style type="text/css">
.containBody{
    height:500px;
    display:block;
    overflow:auto;  
    border-bottom:0px solid #CCC;
}
.tbl_headerFix{
    border-bottom:0px;  
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="25%" align="center" bgcolor="#FFFF99">Column 1</td>
    <td width="25%" align="center" bgcolor="#FFFF99">Column 2</td>
    <td width="25%" align="center" bgcolor="#FFFF99">Column 3</td>
    <td width="25%" align="center" bgcolor="#FFFF99">Column 4</td>
    <td width="1%" align="center" bgcolor="#FFFF99">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="top" >
  <div class="containBody">
    <table class="tbl_headerFix divider" rules="rows" frame="below" width="100%" border="0" cellspacing="0" cellpadding="0">
 <?php for($i=1;$i<=99;$i++){ ?>
      <tr>
        <td width="25%" align="center"><?=$i?></td>
        <td width="25%" align="center"><?=$i?></td>
        <td width="25%" align="center"><?=$i?></td>
        <td width="25%" align="center"><?=$i?></td>
      </tr>
<?php } ?>      
    </table>
</div>    
    </td>
  </tr>
</table>
123456
<br />
</body>
</html>
