<?php
$check=  md5(trim('check'));
if($_REQUEST['method']!=$check){
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
include 'header.php';
?>

<body>
    <form role="form" action='process/prcconn_db.php' enctype="multipart/form-data" method='post'>
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><img src='images/phonebook.ico' width='25'> ตั้งค่าเพื่อ Connect Database</h3>
                    </div>
                  <div class="panel-body">
                      <div class="form-group"> 
                <label>HOST Name &nbsp;</label>
                <input type="text" class="form-control" name="host_name" id="host_name" placeholder="host name" required>
             	</div>
                      <div class="form-group"> 
                <label>Username &nbsp;</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="username" required>
             	</div>
                      <div class="form-group"> 
                <label>Password &nbsp;</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="password">
             	</div>
                      <div class="form-group"> 
                <label>Database name &nbsp;</label>
                <input type="text" class="form-control" name="db_name" id="db_name" placeholder="database name" required>
                      </div>
                      <div class="form-group"> 
                <label>Port &nbsp;</label>
                <input type="text" class="form-control" name="port" id="port" placeholder="MySql Port" required>
                      </div>
                    <div class="form-group"> 
                        <center>
                        <input type="submit" class="btn btn-success" name="submit" value="ตกลง">
                        </center>
                    </div>
                  </div>
              </div>
          </div>
    </form>
</body>
</html>
