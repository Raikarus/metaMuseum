<?php
    session_start();
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
            case 'save_podborka':
                save_podborka();
                break;
            case 'show_podborki':
                show_podborki();
                break;
            case 'show_kwords':
                show_kwords();
                break;
            case 'switch_podborka':
                switch_podborka();
                break;
            case 'return_massiv':
                return_massiv();
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
        $query = "DELETE FROM selections";
        pg_query($cn,$query);
        $query = "DELETE FROM selpics";
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
            $podborka = explode("|",$_POST['podborka']);

            $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
            if($result_tags == "") $query = "SELECT pic_id,fmt,title FROM pics";
            else
            {
                //Если есть kwords
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
                    if(in_array($pic_id, $pre_podborka)) echo "<li class='photo_li' style='outline:3px solid red;outline-offset:-3px' data-id=$pic_id><div class='photo' style='background-image:url(".'"img/'.$pic_id.".".$fmt.'"'.")'></div><div class='name'>$title</div></li>";   
                    else if(in_array($pic_id, $podborka)) echo "<li class='photo_li' style='outline:3px solid green;outline-offset:-3px' data-id=$pic_id><div class='photo' style='background-image:url(".'"img/'.$pic_id.".".$fmt.'"'.")'></div><div class='name'>$title</div></li>";
                    else echo "<li class='photo_li' data-id=$pic_id><div class='photo' style='background-image:url(".'"img/'.$pic_id.".".$fmt.'"'.")'></div><div class='name'>$title</div></li>";
                 }
    	        }
        	}
        	else
        	{
        		echo "error";
                exit();
        	}
        }
        else if ($_POST['mod'] == "podborka")
        {
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
            $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
            if($_POST['active_podborka']=='-1')
            {
                $podborka = explode("|", $_POST['podborka']);
                $selected_in_podborka = explode("|",$_POST['selected_in_podborka']);
                if($_POST['podborka'])
                {
                    $query = "SELECT pic_id,fmt,title FROM pics WHERE pic_id=$podborka[0]";
                    for ($i=1; $i < count($podborka)-1; $i++) { 
                        $query .= "UNION ALL SELECT pic_id,fmt,title FROM pics WHERE pic_id=$podborka[$i]";
                    }
                    $res = pg_query($cn,$query);
                    if(pg_fetch_result($res, $start, 0)){
                        for ($i=$start; $i < $end; $i++) { 
                         $pic_id = pg_fetch_result($res, $i, 0);
                         $fmt = pg_fetch_result($res, $i, 1);
                         $title = pg_fetch_result($res, $i, 2);
                         if($pic_id){
                            if(in_array($pic_id, $selected_in_podborka)) echo "<li class='photo_li' style='outline:3px solid red;outline-offset:-3px' data-id=$pic_id><div class='photo' style='background-image:url(".'"img/'.$pic_id.".".$fmt.'"'.")'></div><div class='name'>$title</div></li>";
                            else echo "<li class='photo_li' data-id=$pic_id><div class='photo' style='background-image:url(".'"img/'.$pic_id.".".$fmt.'"'.")'></div><div class='name'>$title</div></li>";
                         } 
                        }
                    }
                    else
                    {
                        echo "error";
                        exit();
                    }
                }
                else
                {
                    if($_POST['current_page']>1)
                        {
                            echo"error";
                            exit();
                        }
                }
            }
            else
            {
                switch_podborka();
            }
        }
    }

    function save_podborka(){
        $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
        $sel_name = $_POST['name_podborka'];
        $query = "SELECT sel_id FROM selections WHERE sel_name='$sel_name'";
        $res = pg_query($cn,$query);

        if(!pg_fetch_object($res))
        {
            $podborka = explode("|", $_POST['podborka']);
            if(count($podborka)>2)
            {
                $query = "INSERT INTO selections(sel_name) VALUES('$sel_name')";
                $res = pg_query($cn,$query);

                $query = "SELECT sel_id FROM selections WHERE sel_name='$sel_name'";
                $res = pg_query($cn,$query);
                $sel_id = pg_fetch_object($res)->sel_id;

                for ($i=0; $i < count($podborka)-1; $i++) { 
                    $pic_id  = $podborka[$i];
                    $query = "INSERT INTO selpics(sel_id,pic_id) VALUES($sel_id,$pic_id)";
                    $res = pg_query($cn,$query);
                }
                echo "<b style='color:green'>Подборка $sel_name успешно создана</b>";
            }
            else 
            {
                echo "<b style='color:red'>Для создания подборки необходимо минимум два изображения</b>";
            }
        }
        else
        {
            echo "<b style='color:red'>Подборка $sel_name уже существует</b>";
        }
    }

    function show_podborki()
    {
        $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
        $query = "SELECT sel_id,sel_name FROM selections";
        $res = pg_query($cn,$query);
        echo "<li class = 'tag_group'><p class='group_name'><a class='podborka' href = '#' data-id='-1' data-sel_name='Локальная'>Локальная</a></p></li>";
        while($row = pg_fetch_object($res))
        {
            $sel_id = $row->sel_id;
            $sel_name = $row->sel_name;
            echo "<li class = 'tag_group'><p class='group_name'><a class='podborka' href = '#' data-id='$sel_id' data-sel_name='$sel_name'>$sel_name</a></p></li>";
        }
    }

    function show_kwords()
    {
       $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
       $query = "SELECT gkword_id,gkword_name FROM gkwords";
       $res = pg_query($cn,$query);
       while($row=pg_fetch_object($res))
       {
          $gkword_id = $row->gkword_id;
          $gkword_name = $row->gkword_name;
          if($gkword_id == 0)
          {
             //Если нет никакой группы
             $query = "SELECT tag_id,tag_id_num FROM kwgkw WHERE gkword_id=$gkword_id";
             $res2 = pg_query($cn,$query);
             while($row2=pg_fetch_object($res2))
             {
                $tag_id = $row2->tag_id;
                $tag_id_num = $row2->tag_id_num;

                if($tag_id == 10)
                {
                   $query = "SELECT kword_name FROM kwords WHERE tag_id_num=$tag_id_num";
                   $res3 = pg_query($cn,$query);
                   $row3 = pg_fetch_object($res3);
                   $kword_name = $row3->kword_name;
                   $query = "SELECT pic_id FROM pictags WHERE tag_id_num=$tag_id_num";
                   $res3 = pg_query($cn,$query);
                   $row3 = pg_num_rows($res3);
                   $query = "SELECT pic_id FROM pictags WHERE tag_id = $tag_id";
                   $res3 = pg_query($cn,$query);
                   $total = pg_num_rows($res3);
                   $font_size = (round(($row3/$total)*100)+15)."px";
                   echo "<li class = 'tag_group'>
                            <p class = 'group_name'>
                               <a class = 'kword_solo' href='#' data-en = 0 data-tag='$kword_name' style='font-size:$font_size'>$kword_name ($row3)</a>
                            </p>
                         </li>";
                }
             }
          }
          else
          {
             //Если группа есть
             echo '<li class = "tag_group">
                      <p class = "group_name">
                         <input type="checkbox" name = "tags_on" class = tags_checkbox>
                            <a href = "javascript:flipflop('."'".$gkword_name."'".');">'.$gkword_name.'</a>
                      </p>
                      <ul class = "tag_list" id = '.$gkword_name.' style="display: none;">';

             $query = "SELECT tag_id,tag_id_num FROM kwgkw WHERE gkword_id=$gkword_id";
             $res2 = pg_query($cn,$query);

             while($row2=pg_fetch_object($res2))
             {
                $tag_id=$row2->tag_id;
                $tag_id_num=$row2->tag_id_num;
                
                if($tag_id == 10)
                {
                   $query = "SELECT kword_name FROM kwords WHERE tag_id_num = $tag_id_num";
                   $res3 = pg_query($cn,$query);
                   $row3 = pg_fetch_object($res3);
                   $kword_name = $row3->kword_name;
                   $query = "SELECT pic_id FROM pictags WHERE tag_id_num=$tag_id_num";
                   $res3 = pg_query($cn,$query);
                   $row3 = pg_num_rows($res3);
                   $query = "SELECT pic_id FROM pictags WHERE tag_id = $tag_id";
                   $res3 = pg_query($cn,$query);
                   $total = pg_num_rows($res3);
                   $font_size = (round(($row3/$total)*100)+10)."px";
                   echo "<li class='list_item'><a href='#' data-en = 0 data-tag = $kword_name style='font-size:$font_size'>$kword_name ($row3)</a></li>";
                }
             }
             echo '</ul></li>';
          }
       }
    }

    function switch_podborka()
    {
        $sel_id = $_POST['sel_id'];
        if($sel_id == "-1")
        {
            echo "error";
            exit();
        }
        else
        {
            $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
            $query = "SELECT pic_id FROM selpics WHERE sel_id=$sel_id";
            $res = pg_query($cn,$query);
            if($row = pg_fetch_object($res))
            {
                $pic_id = $row->pic_id;
                $query = "SELECT pic_id,fmt,title FROM pics WHERE pic_id = $pic_id";
            }
            while($row = pg_fetch_object($res))
            {
                $pic_id = $row->pic_id;
                $query .= "UNION ALL SELECT pic_id,fmt,title FROM pics WHERE pic_id = $pic_id";
            }

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
            $res = pg_query($cn,$query);
            if(pg_fetch_result($res, $start, 0)){
                for ($i=$start; $i < $end; $i++) { 
                 $pic_id = pg_fetch_result($res, $i, 0);
                 $fmt = pg_fetch_result($res, $i, 1);
                 $title = pg_fetch_result($res, $i, 2);
                 if($pic_id){
                    // if(in_array($pic_id, $selected_in_podborka)) echo "<li class='photo_li' style='outline:3px solid red;outline-offset:-3px' data-id=$pic_id><div class='photo' style='background-image:url(".'"img/'.$pic_id.".".$fmt.'"'.")'></div><div class='name'>$title</div></li>";
                    // else
                    echo "<li class='photo_li' data-id=$pic_id><div class='photo' style='background-image:url(".'"img/'.$pic_id.".".$fmt.'"'.")'></div><div class='name'>$title</div></li>";
                 } 
                }
            }
            else
            {
                echo "error";
                exit();
            }
        }
    }

    function set_podborka_value()
    {
        $_SESSION['podborka']=$_POST['podborka'];   
    }

?>