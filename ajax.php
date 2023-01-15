<?php
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'insert':
                insert();
                break;
            case 'read':
                read();
                break;
        }
    }

    function read() {
        $shl = 'exiftool 1.jpg';
        $res = shell_exec($shl);
        echo "<pre>"+$res+"</pre>";
        exit;
    }

    function insert() {
        echo "The insert function is called.";
        exit;
    }
?>