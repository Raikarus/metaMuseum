<?php 
session_start();
if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'load_podborka':
                load_podborka();
                break;
            case 'load_download':
                load_download();
                break;
            case 'pre_load':
                pre_load();
                break;
            case 'get_podborka_value':
                get_podborka_value();
                break;
        }
    }



function load_podborka()
{
    $img_string = explode('|', $_POST['img_string']);
    //print_r($str);
    for($i = 0; $i < count($img_string)-1;$i++)
    {
        echo '<div class = "comp_li_photo" name ="img" style="  width:90%;height:90%; background-image:url('."'".'img/'.$img_string[$i]."')".'></div>' ;
    }
}

function load_download()
{
    echo '<img src="Шефердия.png" alt="s" width="150%" height="150%"><span class = "cloud_tag" style="font-size: 40 me;">Загрузка</span>';
}

function get_podborka_value()
{
    echo $_SESSION['podborka'];
}

function pre_load()
{
    $pic_id_from_local_podborka = explode("|", $_POST['podborka']);
    if($_POST['podborka'])
    {
        $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
        $query = "SELECT pic_id,fmt,title FROM pics WHERE pic_id=$pic_id_from_local_podborka[0]";
        for ($i=1; $i < count($pic_id_from_local_podborka)-1; $i++) { 
            
            $query .= "UNION ALL SELECT pic_id,fmt,title FROM pics WHERE pic_id=$pic_id_from_local_podborka[$i]";
        }
        $res = pg_query($cn,$query);
        while($row = pg_fetch_object($res))
        {
            $pic_id = $row->pic_id;
            $fmt = $row->fmt;
            $title = $row->title;
            echo '<li class = "compilation_li">
                     <button class = "comp_li_button" data-val= "0" name ="img" data-img = "'.$pic_id.'">
                           <div class = "comp_li_photo" style="background-image:url('."'img/"."$pic_id".".$fmt"."'".')"></div>
                           <div class = "comp_li_name">'.$title.'</div>   
                     </button>        
                     </li>';
        }
    }
    else
    {
        // Добавить стили или удалить строку
        echo "<b style='color:white'>Локальная подборка пуста</b>";
    }
}



?>