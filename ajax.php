<?php
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'read':
                read();
                break;
            case 'insert':
                insert();
                break;
        }
    }

    function read() {
        $shl = 'exiftool '.$_POST['img_name'];
        $res = shell_exec($shl);
        echo "<pre>$res</pre>";
        exit;
    }

    function insert() {
        $files1 = scandir('./img');
        foreach ($files1 as $n => $filename) {
            echo $filename."<br>";
        }
        exit;
    }
?>