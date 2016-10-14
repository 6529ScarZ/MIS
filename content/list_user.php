<?php
     $sql="SELECT CONCAT(u.user_fname,' ',u.user_lname) AS fullname,
IF(u.user_status=0,'ผู้ดูแลระบบ','ผู้ใช้งานทั่วไป')as status_name,
u.user_name,date_login,user_id,user_id as UserID2
FROM `user` u
order by fullname "; 
                $column=array("ชื่อ-นามสกุล","ระดับการใช้งาน","ชื่อที่ใช้งาน","เข้าใช้งานล่าสุด","แก้ไข","ลบ");//หากเป็น TB_mng ต้องเพิ่ม แก้ไข,ลบเข้าไปด้วย 
                $mydata2=new TablePDO();
                $mydata2->imp_columm($column);
                $read="connection/conn_DB.txt";
                $mydata2->para_read($read);
                $mydata2->imp_sql($sql);
        $result=$mydata2->select();//เรียกใช้ค่าจาก function ต้องใช้ตัวแปรรับ
        $mydata2->createPDO_TB_edit('user');//ใส่ process ที่ต้องการสร้าง
        $mydata2->close_PDO();
     ?>

