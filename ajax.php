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
            case 'Download':
                Download();
                break;
            case 'LinkKeyword':
                LinkKeyword();
                break;
            case 'AddKeyword':
                AddKeyword();
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

     function LinkKeyword(){
        if($_POST['pass']=="schef2002"){
            echo "П4р0ль пр0йд3н <br>";

            $shl = 'exiftool -TagsFromFile img/'.$_POST['img_name'].' img/file.xmp';
            $res = shell_exec($shl);
            echo "<pre>$res</pre>";

            $shl = 'exiftool -XMP=img/'.$_POST['img_name'];
            $res = shell_exec($shl);
            echo "<br><pre>$res</pre>";

            $shl = 'exiftool -TagsFromFile img/file.xmp img/'.$_POST['img_name'];
            $res = shell_exec($shl);
            echo "<br><pre>$res</pre>";

            $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
            $query="SELECT pic_id FROM pics WHERE title='".$_POST['img_name']."'";
            $res = pg_query($cn,$query);
            while ($row=pg_fetch_object($res)) {
              $pic_id = $row->pic_id; 
              echo $pic_id."<br>";
            }      
            

            foreach($_POST['kwords'] as $selected_kword)
            {
                $shl = 'exiftool -XMP-dc:subject+="'.$selected_kword.'" img/'.$_POST['img_name'];
                $res = shell_exec($shl);
                echo "<br><pre>$res</pre>"; 
              $query="SELECT tag_id,tag_id_num FROM kwords WHERE kword_name='".$selected_kword."'";
              $res = pg_query($cn,$query);
              while ($row=pg_fetch_object($res)) {
                $tag_id = $row->tag_id;
                $tag_id_num = $row->tag_id_num;
              }
              
              $query="INSERT INTO pictags(pic_id,tag_id,tag_id_num) VALUES (".$pic_id.",".$tag_id.",".$tag_id_num.")";
              $res = pg_query($cn,$query);

              echo $query."<br>";
            }

            $shl = 'exiftool -XMP-dc:ALL img/'.$_POST['img_name']." -b";
            $res = shell_exec($shl);
            echo "<br><pre>$res</pre>";

            $shl = 'rm img/file.xmp';
            $res = shell_exec($shl);
            }
        else
        {
            echo "П4р0ль не пр0йд3н <br>";
        }
        exit;
    }
    function AddKeyword()
    {
        if($_POST['pass']=="schef2002"){
        echo "П4р0ль пр0йд3н <br>";
        $query = "INSERT INTO kwords(tag_id,kword_name,status) VALUES(10,'".$_POST['kword_name']."',1)";
        echo "<br>--- ".$query." ---<br>";
        $res = pg_query($cn,$query);
        }
        else
        {
            echo "П4р0ль не пр0йд3н <br>";
        }
        exit;
    }
?>