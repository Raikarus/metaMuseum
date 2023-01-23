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
            case 'load_cross_kwords':
                load_cross_kwords();
                break;
            case 'link_keyword':
                Link_Keyword();
                break;
        }
    }



function load_podborka()
{
    $img_string = explode('|', $_POST['img_string']);
    //print_r($str);
    for($i = 0; $i < count($img_string)-1;$i++)
    {
        echo '<li class = "main_li_photo" name ="img" style="background-image:url('."'".'img/'.$img_string[$i]."')".'"></li>' ;
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
                     <button class = "comp_li_button" data-val= "0" name ="img" data-id='.$pic_id.' data-img = "'.$pic_id.'.'.$fmt.'">
                           <div class = "comp_li_photo" style="background-image:url('."'img/"."$pic_id".".$fmt"."'".')"></div>
                           <div class = "comp_li_name">'.$title.'</div>   
                     </button>        
                     </li>';
        }
    }
    else
    {
        // Добавить стили или удалить строку
        echo "<b id = 'emptycompilation'>Локальная подборка пуста</b>";
    }
}

function load_cross_kwords()
{
    $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
    $pic_id_from_local_podborka = explode("|", $_POST['img_string']);
    if(count($pic_id_from_local_podborka)-1>=1)
    {   
        //Возможно это можно свернуть, но я пока не придумал как
        if(count($pic_id_from_local_podborka)-1==1)
        {
            //ЕСЛИ ВСЕГО ОДНА КАРТИНКА ВЫБРАНА
            $query = "SELECT tag_id_num FROM pictags WHERE pic_id=$pic_id_from_local_podborka[0] AND tag_id=10";
            $res = pg_query($cn,$query);
            if($row = pg_fetch_object($res))
            {
                $tag_id_num = $row->tag_id_num;
                $query = "SELECT kword_name FROM kwords WHERE tag_id_num=$tag_id_num";
                while($row = pg_fetch_object($res))
                {
                    $tag_id_num = $row->tag_id_num;
                    $query .= " OR tag_id_num=$tag_id_num";
                }
                $res = pg_query($cn,$query);
                while($row = pg_fetch_object($res))
                {
                    $kword_name = $row->kword_name;
                    //СКОПИРОВАТЬ СТИЛИ ИЛИ ДОБАВИТЬ ДУБЛИКАТ СВОИХ
                    echo "<li class = 'key_words' data-tag='$kword_name' data-status='automatic'>$kword_name</li>";    
                }
            }
            else
            {
                //Добавить стили или удалить строчку
                echo "<b class='warning'>Не найдено ключевых слов</b>";
            }
        }
        else
        {
            //ЕСЛИ ВЫБРАНО НЕСКОЛЬКО КАРТИНОК
            $query = "SELECT tag_id_num FROM pictags WHERE tag_id=10 AND (pic_id=$pic_id_from_local_podborka[0]";
            for ($i=1; $i < count($pic_id_from_local_podborka)-1; $i++) { 
                $query .= " OR pic_id=$pic_id_from_local_podborka[$i]";
            }
            $count_of_pic_id = count($pic_id_from_local_podborka)-1;
            $query .= ") GROUP BY tag_id_num HAVING COUNT(tag_id_num)=$count_of_pic_id";
            $res = pg_query($cn,$query);
            if($row = pg_fetch_object($res))
            {
                $tag_id_num = $row->tag_id_num;
                $query = "SELECT kword_name FROM kwords WHERE tag_id_num=$tag_id_num";
                while($row = pg_fetch_object($res))
                {
                    $tag_id_num = $row->tag_id_num;
                    $query .= " OR tag_id_num=$tag_id_num";
                }
                $res = pg_query($cn,$query);
                
                while($row = pg_fetch_object($res))
                {
                    $kword_name = $row->kword_name;
                    //СКОПИРОВАТЬ СТИЛИ ИЛИ ДОБАВИТЬ ДУБЛИКАТ СВОИХ
                    echo "<li class = 'key_words' data-tag='$kword_name' data-status='automatic'>$kword_name</li>";
                }
            }
            else
            {
                echo "<b class='warning'>Нет общих ключевых слов</b>";
            }
            
        }
    }
    else
    {
        //Добавить стили или удалить строчку
        echo "<b class='warning'>Ничего не выбрано</b>";
    }
    //$query = "SELECT tag_id_num FROM pictags WHERE (tag_id=10)"
}

function Link_Keyword(){
    //Добавить удаление через -=
    $img_names = explode("|",$_POST['img_names']);
    $new_kwords = explode("|",$_POST['new_kwords']);
    array_pop($new_kwords);
    $delete_kwords = explode("|",$_POST['delete_kwords']);
    array_pop($delete_kwords);
    $auto_kwords = explod("|",$_POST['auto_kwords']);
    array_pop($auto_kwords);
    for ($i=0; $i < count($img_names)-1; $i++) { 
        $img_name = addcslashes($img_names[$i]," ");
        $shl = 'exiftool -TagsFromFile img/'.$img_name.' img/file.xmp';
        $res = shell_exec($shl);
        echo "<pre>$res</pre>";

        $shl = 'exiftool -XMP=img/'.$img_name;
        $res = shell_exec($shl);
        echo "<br><pre>$res</pre>";

        $shl = 'exiftool -TagsFromFile img/file.xmp img/'.$img_name;
        $res = shell_exec($shl);
        echo "<br><pre>$res</pre>";

        $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");

        $pic_id = substr($img_name,0,strpos($img_name,'.'));

        for ($j=0; $j < count($new_kwords); $j++)
        {
          $selected_kword = $new_kwords[$j];
          $query="SELECT tag_id,tag_id_num FROM kwords WHERE kword_name='$selected_kword'";
          $res = pg_query($cn,$query);
          echo "ЗАПРОСИК $query<br>";
          $row=pg_fetch_object($res);
          $tag_id = $row->tag_id;
          $tag_id_num = $row->tag_id_num;

          $query = "SELECT pic_id FROM pictags WHERE pic_id=$pic_id AND tag_id_num=$tag_id_num";
          $res = pg_query($cn,$query);
          echo "ЗАПРОСИК $query<br>";
          if(!pg_fetch_object($res))
          {
            if($delete_kwords[$j]==1)
                $shl = 'exiftool -XMP-dc:subject+="'.$selected_kword.'" img/'.$img_name;
            else
                $shl = 'exiftool -XMP-dc:subject-="'.$auto_kwords[$j].'" img/'.$img_name;
            $res = shell_exec($shl);
            echo "<br>$shl<pre>$res</pre>";

            $query="INSERT INTO pictags(pic_id,tag_id,tag_id_num) VALUES (".$pic_id.",".$tag_id.",".$tag_id_num.")";
            $res = pg_query($cn,$query);
            echo "ЗАПРОСИК $query<br>";
            echo $query."<br>";
            }
          else
          {
            echo "Ключевое слово $selected_kword уже существует<br>";
          }
        }

        $shl = 'exiftool -XMP-dc:ALL img/'.$img_name." -b";
        $res = shell_exec($shl);
        echo "<br><pre>$res</pre>";

        $shl = 'rm img/file.xmp';
        $res = shell_exec($shl); 
    }
    
}

?>