<?php
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'read':
                read();
                break;
            case 'list':
                list_l();
                break;
        }
    }

    function read() {
        $shl = 'exiftool '.$_POST['img_name'];
        echo $shl."<br>";
        $res = shell_exec($shl);
        echo "<pre>$res</pre>";
        exit;
    }

    function list_l() {
        $files1 = scandir('./img');
        foreach ($files1 as $n => $filename) {
            if ($filename != '.' && $filename!= '..') echo $filename."<br>";
        }
        exit;
    }
?>