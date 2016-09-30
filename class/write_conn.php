<?php
class write_conn {
    public $fconn;
    public $vconn=array();
    public function write_conn($conn_file,$conn_value){
        $this->fconn = $conn_file;
        $this->vconn=$conn_value;
        $objFopen = fopen($this->fconn, 'w');
        for($i=0;$i<count($this->vconn);$i++){
            
        $data[$i]=$this->vconn[$i];
        $write[$i] = "$data[$i]\r\n";
        fwrite($objFopen, $write[$i]);
        }

        if ($objFopen) {
            echo "บันทึกเรียบร้อย";
        } else {
            echo "ไม่สามารถบันทึกได้";
        }

        fclose($objFopen);
}
}
