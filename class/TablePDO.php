<?php
require 'EnDeCode.php';
include 'plugins/funcDateThai.php';

class TablePDO extends EnDeCode {

    public $column;

    public function __construct($column) {
        $this->column = $column;
    }
//1. ตารางแบบธรรมดา
    public function createPDO_TB() {
        $query = $this->select('');
        $field = $this->listfield('');
        $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
        echo "<div class='table-responsive'>";
        echo "<table id='example1' class='table table-bordered table-hover'>";
        echo "<thead><tr align='center' bgcolor='#898888'>";
        echo "<th align='center' width='5%'>ลำดับ</th>";
        foreach ($this->column as $key => $value) {
            echo "<th align='center'>$value</th>";
        }
        echo "</tr></thead><tbody>";
        $c = 0;
        $C = 1;
        $ii=0;
        for ($I = 0; $I < count($query); $I++) {
            $num_field = $this->count_field();
            if($ii>=5){
                        $ii=0;
                    }
            echo "<tr class='" . $code_color[$ii] . "'>";
            echo "<td align='center'>" . $C . "</td>";
            for ($i = 0; $i < ($num_field); $i++) {
               if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                                            echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                                        } else {
                                            echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
                                        }
            }
            $c++;
            $C++;
            $ii++;
            echo "</tr>";
        }
        echo "</tbody>";
        echo "<tfoot><tr align='center' bgcolor='#898888'>";
        echo "<th align='center' width='5%'>ลำดับ</th>";
        foreach ($this->column as $key => $value) {
            echo "<th align='center'>$value</th>";
        }
        echo "</tr></tfoot></table></div>";
    }
//2. ตารางแบบจัดการกับข้อมูลได้
    public function createPDO_TB_mng($process) {
        $this->process = $process;
        $query = $this->select('');
        $field = $this->listfield('');
        $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
        echo "<div class='table-responsive'>";
        echo "<table id='example1' class='table table-bordered table-hover'>";
        echo "<thead><tr align='center' bgcolor='#898888'>";
        echo "<th align='center' width='5%'>ลำดับ</th>";
        foreach ($this->column as $key => $value) {
            echo "<th align='center'>$value</th>";
        }
        echo "</tr></thead><tbody>";
        $c = 0;
        $C = 1;
        $ii=0;
        for ($I = 0; $I < count($query); $I++) {
            $num_field = $this->count_field();
            if($ii>=5){
                        $ii=0;
                    }
            echo "<tr class='" . $code_color[$ii] . "'>";
            echo "<td align='center'>" . $C . "</td>";
            for ($i = 0; $i < ($num_field); $i++) {
                if ($i < ($num_field - 3)) {
                    if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                        echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                    } else { 
                        if($i==0){?>
<td align='center'><a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c]['id']);?>', '', 'width=650,height=400');
                                return false;" title="รายละเอียด">  <?= $query[$c][$field[$i]]?></td>
                        <?php }  else {
                            echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
 }}
                } else {
                    if ($i = ($num_field - 3)) {
                        echo "<td align='center'>";
                        ?>
<a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c][$field[$i]]);?>', '', 'width=650,height=400');
                                return false;" title="รายละเอียด">     
                                <?php
                                echo "<img src='images/icon_set1/document.ico' width='25'></a></td>";
                            }
                            if ($i = ($num_field - 2)) {
                                echo "<td align='center'>"
                                . "<a href='index.php?page=content/add_" . $this->process . "&method=edit&id=" . $this->sslEnc($query[$c][$field[$i]]) . "'>"
                                . "<img src='images/icon_set1/document_edit.ico' width='25'></a></td>";
                            }
                            if ($i = ($num_field - 1)) {

                                echo "<td align='center'>";
                                ?>
                            <a href="index.php?page=process/prc<?= $this->process ?>&method=delete_<?= $this->process ?>&del_id=<?php echo $this->sslEnc($query[$c][$field[$i]]); ?>" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')">
                                <?php
                                echo "<img src='images/icon_set1/document_delete.ico' width='25'></a></td>";
                            }
                        }
                    }
                    $c++;
                    $C++;
                    $ii++;
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "<tfoot><tr align='center' bgcolor='#898888'>";
                echo "<th align='center' width='5%'>ลำดับ</th>";
                foreach ($this->column as $key => $value) {
                    echo "<th align='center'>$value</th>";
                }
                echo "</tr></tfoot></table></div>";
            }
//3. ตารางแบบแสดงรายละเอียดและสั่งปริ้น  PDF
            public function createPDO_TB_PDF($process) {
                $this->process = $process;
                $query = $this->select('');
                $field = $this->listfield('');
                $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
                echo "<div class='table-responsive'>";
                echo "<table id='example1' class='table table-bordered table-hover'>";
                echo "<thead><tr align='center' bgcolor='#898888'>";
                echo "<th align='center' width='5%'>ลำดับ</th>";
                foreach ($this->column as $key => $value) {
                    echo "<th align='center'>$value</th>";
                }
                echo "</tr></thead><tbody>";
                $c = 0;
                $C = 1;
                $ii=0;
                for ($I = 0; $I < count($query); $I++) {
                    $num_field = $this->count_field();
                    if($ii>=5){
                        $ii=0;
                    }
                    echo "<tr class='" . $code_color[$ii] . "'>";
                    echo "<td align='center'>" . $C . "</td>";
                    for ($i = 0; $i < ($num_field); $i++) {
                        if ($i < ($num_field - 2)) {
                            if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                                echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                            } else {
                                echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
                            }
                        } else {
                            if ($i = ($num_field - 2)) {
                                echo "<td align='center'>";
                                ?>
                                <a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c][$field[$i]]); ?>', '', 'width=650,height=400');
                                        return false;" title="รายละเอียด">     
                                        <?php
                                        echo "<img src='images/icon_set1/document.ico' width='25'></a></td>";
                                    }
                                    if ($i = ($num_field - 1)) {
                                        echo "<td align='center'>";
                                        ?>
                                    <a href="#" onClick="window.open('content/<?= $this->process ?>_PDF.php?id=<?php echo $this->sslEnc($query[$c][$field[$i]]); ?>', '', 'width=550,height=700');
                                            return false;" title="รายละเอียด">     
                                        <?php
                                        echo "<img src='images/printer.ico' width='25'></a></td>";
                                    }
                                }
                            }
                            $c++;
                            $C++;
                            $ii++;
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "<tfoot><tr align='center' bgcolor='#898888'>";
                        echo "<th align='center' width='5%'>ลำดับ</th>";
                        foreach ($this->column as $key => $value) {
                            echo "<th align='center'>$value</th>";
                        }
                        echo "</tr></tfoot></table></div>";
                    }
//4. ตารางที่แสดงเฉพาะรายละเอียดเท่านั้น
                    public function createPDO_TB_Detial($process) {
                        $this->process = $process;
                        $query = $this->select('');
                        $field = $this->listfield('');
                        $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
                        echo "<div class='table-responsive'>";
                        echo "<table id='example1' class='table table-bordered table-hover'>";
                        echo "<thead><tr align='center' bgcolor='#898888'>";
                        echo "<th align='center' width='5%'>ลำดับ</th>";
                        foreach ($this->column as $key => $value) {
                            echo "<th align='center'>$value</th>";
                        }
                        echo "</tr></thead><tbody>";
                        $c = 0;
                        $C = 1;
                        $ii=0;
                        for ($I = 0; $I < count($query); $I++) {
                            $num_field = $this->count_field();
                            if($ii>=5){
                        $ii=0;
                    }
                            echo "<tr class='" . $code_color[$ii] . "'>";
                            echo "<td align='center'>" . $C . "</td>";
                            for ($i = 0; $i < ($num_field); $i++) {
                                if ($i < ($num_field - 1)) {
                                    if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                                        echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                                    } else {
                                        echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
                                    }
                                } else {
                                    if ($i = ($num_field - 1)) {
                                        echo "<td align='center'>";
                                        ?>
                                        <a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c][$field[$i]]); ?>', '', 'width=650,height=400');
                                                return false;" title="รายละเอียด">     
                                            <?php
                                            echo "<img src='images/icon_set1/document.ico' width='25'></a></td>";
                                        }
                                    }
                                }
                                $c++;
                                $C++;
                                $ii++;
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "<tfoot><tr align='center' bgcolor='#898888'>";
                            echo "<th align='center' width='5%'>ลำดับ</th>";
                            foreach ($this->column as $key => $value) {
                                echo "<th align='center'>$value</th>";
                            }
                            echo "</tr></tfoot></table></div>";
                        }
//5. ตารางที่จัดการข้อมูลได้ แต่ไม่แสดงรายละเอียด
                        public function createPDO_TB_edit($process) {
                            $this->process = $process;
                            $query = $this->select('');
                            $field = $this->listfield('');
                            $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
                            echo "<div class='table-responsive'>";
                            echo "<table id='example1' class='table table-bordered table-hover'>";
                            echo "<thead><tr align='center' bgcolor='#898888'>";
                            echo "<th align='center' width='5%'>ลำดับ</th>";
                            foreach ($this->column as $key => $value) {
                                echo "<th align='center'>$value</th>";
                            }
                            echo "</tr></thead><tbody>";
                            $c = 0;
                            $C = 1;
                            $ii=0;
                            for ($I = 0; $I < count($query); $I++) {
                                $num_field = $this->count_field();
                                if($ii>=5){
                        $ii=0;
                    }
                                echo "<tr class='" . $code_color[$ii] . "'>";
                                echo "<td align='center'>" . $C . "</td>";
                                for ($i = 0; $i < ($num_field); $i++) {

                                    if ($i < ($num_field - 2)) {
                                        if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                                            echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                                        } else {
                                            echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
                                        }
                                    } else {
                                        if ($i = ($num_field - 2)) {
                                            echo "<td align='center'>"
                                            . "<a href='index.php?page=content/add_" . $this->process . "&method=edit&id=" . $this->sslEnc($query[$c][$field[$i]]) . "'>"
                                            . "<img src='images/icon_set1/document_edit.ico' width='25'></a></td>";
                                        }
                                        if ($i = ($num_field - 1)) {

                                            echo "<td align='center'>";
                                            ?>
                                            <a href="index.php?page=process/prc<?= $this->process ?>&method=delete_<?= $this->process ?>&del_id=<?php echo $this->sslEnc($query[$c][$field[$i]]); ?>" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')">
                                                <?php
                                                echo "<img src='images/icon_set1/document_delete.ico' width='25'></a></td>";
                                            }
                                        }
                                    }
                                    $c++;
                                    $C++;
                                    $ii++;
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "<tfoot><tr align='center' bgcolor='#898888'>";
                                echo "<th align='center' width='5%'>ลำดับที่</th>";
                                foreach ($this->column as $key => $value) {
                                    echo "<th align='center'>$value</th>";
                                }
                                echo "</tr></tfoot></table></div>";
                            }
//6. ตารางที่แสดงหัวตารางแบบหลากหลาย (มีแต่ข้อมูลแสดง)
                            public function createPDO_TB_Head() {
                                $query = $this->select('');
                                $field = $this->listfield('');
                                $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
                                echo "<div class='table-responsive'>";
                                echo "<table id='example1' class='table table-bordered table-hover'>";
                                echo "<thead bgcolor='#898888'><tr align='center'>";
                                echo "<th align='center' width='5%' rowspan='2'>ลำดับ</th>";

                                foreach ($this->column as $key => $value) {
                                    $colspan = count($value);
                                    if ($colspan == 0) {
                                        echo "<th align='center' rowspan='2'>$key</th>";
                                    } else {
                                        echo "<th align='center' colspan='$colspan'>$key</th>";
                                    }
                                }
                                echo "</tr><tr>";
                                foreach ($this->column as $key => $value) {
                                    foreach ($value as $keys => $values) {
                                        echo "<th align='center'>$values</th>";
                                    }
                                }
                                echo "</tr></thead><tbody>";
                                $c = 0;
                                $C = 1;
                                $ii=0;
                                for ($I = 0; $I < count($query); $I++) {
                                    $num_field = $this->count_field();
                                    if($ii>=5){
                        $ii=0;
                    }
                                    echo "<tr class='" . $code_color[$ii] . "'>";
                                    echo "<td align='center'>" . $C . "</td>";
                                    for ($i = 0; $i < ($num_field); $i++) {
                                        if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                                            echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                                        } else {
                                            echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
                                        }
                                    }
                                    $c++;
                                    $C++;
                                    $ii++;
                                    echo "</tr>";
                                }
                                echo "</tbody></table></div>";
                            }
//7. ตารางที่แสดงรายละเอียดและแก้ไขได้
    public function createPDO_TB_ED($process) {
        $this->process = $process;
        $query = $this->select('');
        $field = $this->listfield('');
        $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
        echo "<div class='table-responsive'>";
        echo "<table id='example1' class='table table-bordered table-hover'>";
        echo "<thead><tr align='center' bgcolor='#898888'>";
        echo "<th align='center' width='5%'>ลำดับ</th>";
        foreach ($this->column as $key => $value) {
            echo "<th align='center'>$value</th>";
        }
        echo "</tr></thead><tbody>";
        $c = 0;
        $C = 1;
        $ii=0;
        for ($I = 0; $I < count($query); $I++) {
            $num_field = $this->count_field();
            if($ii>=5){
                        $ii=0;
                    }
            echo "<tr class='" . $code_color[$ii] . "'>";
            echo "<td align='center'>" . $C . "</td>";
            for ($i = 0; $i < ($num_field); $i++) {
                if ($i < ($num_field - 2)) {
                    if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                        echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                    } else { 
                        if($i==0){?>
                        <td align='center'><a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c]['id']); ?>', '', 'width=650,height=400');
                                return false;" title="รายละเอียด">  <?= $query[$c][$field[$i]]?></td>
                        <?php }  else {
                            echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
 }}
                } else {
                    if ($i = ($num_field - 2)) {
                        echo "<td align='center'>";
                        ?>
                        <a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c][$field[$i]]); ?>', '', 'width=650,height=400');
                                return false;" title="รายละเอียด">     
                                <?php
                                echo "<img src='images/icon_set1/document.ico' width='25'></a></td>";
                            }
                            if ($i = ($num_field - 1)) {
                                echo "<td align='center'>"
                                . "<a href='index.php?page=content/add_" . $this->process . "&method=edit&id=" . $this->sslEnc($query[$c][$field[$i]]) . "'>"
                                . "<img src='images/icon_set1/document_edit.ico' width='25'></a></td>";
                            }
                        }
                    }
                    $c++;
                    $C++;
                    $ii++;
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "<tfoot><tr align='center' bgcolor='#898888'>";
                echo "<th align='center' width='5%'>ลำดับ</th>";
                foreach ($this->column as $key => $value) {
                    echo "<th align='center'>$value</th>";
                }
                echo "</tr></tfoot></table></div>";
            }
//8. ตารางแบบจัดการกับข้อมูลและพิมพ์ PDF ได้             
            public function createPDO_TB_mngPDF($process) {
        $this->process = $process;
        $query = $this->select('');
        $field = $this->listfield('');
        $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
        echo "<div class='table-responsive'>";
        echo "<table id='example1' class='table table-bordered table-hover'>";
        echo "<thead><tr align='center' bgcolor='#898888'>";
        echo "<th align='center' width='5%'>ลำดับ</th>";
        foreach ($this->column as $key => $value) {
            echo "<th align='center'>$value</th>";
        }
        echo "</tr></thead><tbody>";
        $c = 0;
        $C = 1;
        $ii=0;
        for ($I = 0; $I < count($query); $I++) {
            $num_field = $this->count_field();
            if($ii>=5){
                        $ii=0;
                    }
            echo "<tr class='" . $code_color[$ii] . "'>";
            echo "<td align='center'>" . $C . "</td>";
            for ($i = 0; $i < ($num_field); $i++) {
                if ($i < ($num_field - 4)) {
                    if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                        echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                    } else { 
                        if($i==0){?>
<td align='center'><a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c]['id']);?>', '', 'width=650,height=400');
                                return false;" title="รายละเอียด">  <?= $query[$c][$field[$i]]?></td>
                        <?php }  else {
                            echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
 }}
                } else {
                    if ($i = ($num_field - 4)) {
                        echo "<td align='center'>";
                        ?>
<a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c][$field[$i]]);?>', '', 'width=650,height=400');
                                return false;" title="รายละเอียด">     
                                <?php
                                echo "<img src='images/icon_set1/document.ico' width='25'></a></td>";
                            }
                            if ($i = ($num_field - 3)) {
                                        echo "<td align='center'>";
                                        ?>
                                    <a href="#" onClick="window.open('content/<?= $this->process ?>_PDF.php?id=<?php echo $this->sslEnc($query[$c][$field[$i]]); ?>', '', 'width=550,height=700');
                                            return false;" title="รายละเอียด">     
                                        <?php
                                        echo "<img src='images/printer.ico' width='25'></a></td>";
                                    }
                            if ($i = ($num_field - 2)) {
                                echo "<td align='center'>"
                                . "<a href='index.php?page=content/add_" . $this->process . "&method=edit&id=" . $this->sslEnc($query[$c][$field[$i]]) . "'>"
                                . "<img src='images/icon_set1/document_edit.ico' width='25'></a></td>";
                            }
                            if ($i = ($num_field - 1)) {

                                echo "<td align='center'>";
                                ?>
                            <a href="index.php?page=process/prc<?= $this->process ?>&method=delete_<?= $this->process ?>&del_id=<?php echo $this->sslEnc($query[$c][$field[$i]]); ?>" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')">
                                <?php
                                echo "<img src='images/icon_set1/document_delete.ico' width='25'></a></td>";
                            }
                        }
                    }
                    $c++;
                    $C++;
                    $ii++;
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "<tfoot><tr align='center' bgcolor='#898888'>";
                echo "<th align='center' width='5%'>ลำดับ</th>";
                foreach ($this->column as $key => $value) {
                    echo "<th align='center'>$value</th>";
                }
                echo "</tr></tfoot></table></div>";
            }
            //9. ตารางแบบจัดการกับข้อมูลและแสดงสถานะได้             
            public function createPDO_TB_mngSTATUS($process, $par1, $par2, $par3) {
        $this->process = $process;
        $this->par1=$par1;
        $this->par2=$par2;
        $this->par3=$par3;
        $query = $this->select('');
        $field = $this->listfield('');
        $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
        echo "<div class='table-responsive'>";
        echo "<table id='example1' class='table table-bordered table-hover'>";
        echo "<thead><tr align='center' bgcolor='#898888'>";
        echo "<th align='center' width='5%'>ลำดับ</th>";
        foreach ($this->column as $key => $value) {
            echo "<th align='center'>$value</th>";
        }
        echo "</tr></thead><tbody>";
        $c = 0;
        $C = 1;
        $ii=0;
        for ($I = 0; $I < count($query); $I++) {
            $num_field = $this->count_field();
            if($ii>=5){
                        $ii=0;
                    }
            echo "<tr class='" . $code_color[$ii] . "'>";
            echo "<td align='center'>" . $C . "</td>";
            for ($i = 0; $i < ($num_field); $i++) {
                if ($i < ($num_field - 4)) {
                    if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                        echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                    } else { 
                        if($i==0){?>
<td align='center'><a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c]['id']);?>', '', 'width=650,height=400');
                                return false;" title="รายละเอียด">  <?= $query[$c][$field[$i]]?></td>
                        <?php }  else {
                            echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
 }}
                } else {
                    if ($i = ($num_field - 4)) {
                        echo "<td align='center'>";
                        ?>
<a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c][$field[$i]]);?>', '', 'width=650,height=400');
                                return false;" title="รายละเอียด">     
                                <?php
                                echo "<img src='images/icon_set1/document.ico' width='25'></a></td>";
                            }
                            if ($i = ($num_field - 3)) {
                                        echo "<td align='center'>";
                                        if($query[$c][$field[$i]]=="$this->par1"){ 
                            echo "<i class='fa fa-spinner fa-spin' title='รอการอนุมัติ'></i>";
                             } elseif ($query[$c][$field[$i]]=="$this->par2") {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="อนุมัติ">
                                     <?php } elseif ($query[$c][$field[$i]]=="$this->par3") {?>
                                    <img src="images/button_cancel.ico" width="20" title="ไม่อนุมัติ">
                                     <?php } echo "</td>";
                                    }
                            if ($i = ($num_field - 2)) {
                                echo "<td align='center'>"
                                . "<a href='index.php?page=content/add_" . $this->process . "&method=edit&id=" . $this->sslEnc($query[$c][$field[$i]]) . "'>"
                                . "<img src='images/icon_set1/document_edit.ico' width='25'></a></td>";
                            }
                            if ($i = ($num_field - 1)) {

                                echo "<td align='center'>";
                                ?>
                            <a href="index.php?page=process/prc<?= $this->process ?>&method=delete_<?= $this->process ?>&del_id=<?php echo $this->sslEnc($query[$c][$field[$i]]); ?>" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')">
                                <?php
                                echo "<img src='images/icon_set1/document_delete.ico' width='25'></a></td>";
                            }
                        }
                    }
                    $c++;
                    $C++;
                    $ii++;
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "<tfoot><tr align='center' bgcolor='#898888'>";
                echo "<th align='center' width='5%'>ลำดับ</th>";
                foreach ($this->column as $key => $value) {
                    echo "<th align='center'>$value</th>";
                }
                echo "</tr></tfoot></table></div>";
            }
                        }
                        