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
            case 'kwgkw':
                kwgkw();
                break;
            case 'update_grid':
                update_grid();
                break;
        }
    }

    function read() {
        $shl = 'exiftool '.$_POST['img_name'];
        echo $shl."<br>";
        $res = shell_exec($shl);
        $arr = explode("\n", $res);
        echo "<pre>$res</pre><br><br>";
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

    function kwgkw()    {
        $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
        $query = "SELECT * FROM kwgkw";
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
        $query = "DELETE FROM kwords";
        pg_query($cn,$query);
        $query = "DELETE FROM kwgkw";
        pg_query($cn,$query);

        $query = "rm img/*";
        shell_exec($query);
        exit;
    }

    function update_grid()
    {   
        if($_POST['mod'] == "gallery")
        {
            $result_tags = $_POST['result_tags'];
            $result_tags_invers = $_POST['result_tags_invers'];
            $add_where = "yes";
            $pre_podborka = explode("|",$_POST['pre_podborka']);

            $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
            if($result_tags == "") $query = "SELECT pic_id,fmt,title FROM pics";
            else
            {
                $result_tags_arr = explode("|", $result_tags);
                $result_tags_invers_arr = explode("|",$result_tags_invers);
                $query = "SELECT tag_id_num FROM kwords WHERE kword_name='$result_tags_arr[0]'";
                for ($i=1; $i < count($result_tags_arr)-1; $i++) {
                    $query .= " UNION ALL SELECT tag_id_num FROM kwords WHERE kword_name='$result_tags_arr[$i]'"; 
                }
                $res = pg_query($cn,$query);
                $tag_id_num_array = pg_fetch_all($res);
                $query = "SELECT pic_id FROM pics";
                $res = pg_query($cn,$query);
                $query = "SELECT pic_id,fmt,title FROM pics";
                $add_where = "yes";
                while($row = pg_fetch_object($res))
                {
                    $pic_id = $row->pic_id;
                    $query2 = "SELECT tag_id_num FROM pictags WHERE pic_id=$pic_id";
                    $res2 = pg_query($cn,$query2);
                    $tag_id_num_array_from_pic_id = pg_fetch_all($res2);
                    $ok = "ok";
                    for ($i=0; $i < count($tag_id_num_array); $i++) { 
                        if($result_tags_invers_arr[$i] == "0")
                        {
                            if(!in_array($tag_id_num_array[$i],$tag_id_num_array_from_pic_id))
                            {
                                $ok = "not ok";
                                break;
                            }
                        }
                        else
                        {
                            if(in_array($tag_id_num_array[$i], $tag_id_num_array_from_pic_id))
                            {
                                $ok = "not ok";
                                break;
                            }
                        }
                    }

                    if($ok == "ok") 
                    {
                        if($add_where == "yes")
                        {
                            $add_where = "no";
                            $query .= " WHERE ";
                            $query .= "pic_id = $pic_id";
                        }
                        else
                        {
                            $query .= " OR pic_id = $pic_id";
                        }
                    }
                }
                if($add_where == "yes") 
                {
                    echo "<script> alert('Не найдено изображений по заданным ключевым словам')</script>";
                }
            }
            $res = pg_query($cn,$query);
            $start = 0;
            $end = 6;
            switch ($_POST['size']) {
                case '3x2':
                    $start = ($_POST['current_page']-1)*6;
                    $end = $start + 6;
                    break;
                case '4x3':
                    $start = ($_POST['current_page']-1)*12;
                    $end = $start + 12;
                    break;
                case '5x4':
                    $start = ($_POST['current_page']-1)*20;
                    $end = $start + 20;
                    break;
            }
            if(pg_fetch_result($res, $start, 0))
            {
    	        for ($i=$start; $i < $end; $i++) { 
    	         $pic_id = pg_fetch_result($res, $i, 0);
    	         $fmt = pg_fetch_result($res, $i, 1);
    	         $title = pg_fetch_result($res, $i, 2);
                 if($pic_id)
                 {
                     if(!in_array($pic_id, $pre_podborka))echo "<li class='photo_li' data-id=$pic_id><div class='photo' style='background-image:url(".'"img/'.$pic_id.".".$fmt.'"'.")'></div><div class='name'>$title</div></li>";   
                     else echo "<li class='photo_li' style='outline:3px solid red;outline-offset:-3px' data-id=$pic_id><div class='photo' style='background-image:url(".'"img/'.$pic_id.".".$fmt.'"'.")'></div><div class='name'>$title</div></li>";   
                 }
    	        }
        	}
        	else
        	{
        		echo "error";
        	}
        }
        else
        {
            
        }
    }

?>