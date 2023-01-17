<?php
    
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'read':
                read();
                break;
            case 'list':
                list_l();
                break;
            case 'pics':
                pics();
                break;
            case 'kwords':
                kwords();
                break;
            case 'pictags':
                pictags();
                break;
            case 'REMOVE':
                remove();
                break;
        }
    }

    function read() {
        $shl = 'exiftool '.$_POST['img_name'];
        echo $shl."<br>";
        $res = shell_exec($shl);
        $arr = explode("\n", $res);
        foreach ($arr as $key => $value) {
            echo $key." ".$value." 1<br>";
        }
        exit;
    }

    function list_l() {
        $files1 = scandir('./img');
        foreach ($files1 as $n => $filename) {
            if ($filename != '.' && $filename!= '..') echo $filename."<br>";
        }
        exit;
    }

    function pics()  {
        $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
        $query = "SELECT * FROM pics";
        $res = pg_query($cn,$query);
        $row = pg_fetch_all($res);
        echo "<pre>";
        print_r($row);
        echo "</pre>";
        exit;
    }

    function kwords() {
        $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
        $query = "SELECT * FROM kwords";
        $res = pg_query($cn,$query);
        $row = pg_fetch_all($res);
        echo "<pre>";
        print_r($row);
        echo "</pre>";
        exit;
    }

    function pictags()  {
        $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
        $query = "SELECT * FROM pictags";
        $res = pg_query($cn,$query);
        $row = pg_fetch_all($res);
        echo "<pre>";
        print_r($row);
        echo "</pre>";
        exit;
    }

    function remove()   {
        $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
        $query = "DELETE FROM pics";
        pg_query($cn,$query);
        $query = "DELETE FROM pictags";
        pg_query($cn,$query);

        $query = "rm img/*";
        shell_exec($query);
        exit;
    }
?>