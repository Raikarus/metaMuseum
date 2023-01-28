<?php 
session_start();
if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'load_podborka':
                load_podborka();
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
            case 'link_kword':
                link_Kword();
                break;
            case 'download':
                download();
                break;
        }
    }



function load_podborka()
{
    // Убрать в js
    $img_string = explode('|', $_POST['img_string']);
    for($i = 0; $i < count($img_string)-1;$i++)
    {
        echo '<li class = "main_li_photo" name ="img" style="background-image:url('."'".'img/'.$img_string[$i]."')".'"></li>' ;
    }
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
            $query = "SELECT tag_id_num FROM pictags WHERE pic_id=$pic_id_from_local_podborka[0]";//tag_id=10";
            $res = pg_query($cn,$query);
            if($row = pg_fetch_object($res))
            {
                $tag_id_num = $row->tag_id_num;
                $query = "SELECT kword_name,status FROM kwords WHERE status=1  AND (tag_id_num=$tag_id_num";
                while($row = pg_fetch_object($res))
                {
                    $tag_id_num = $row->tag_id_num;
                    $query .= " OR tag_id_num=$tag_id_num";
                }
                $query .= ")";
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
            $query = "SELECT tag_id_num FROM pictags WHERE status=1 AND (pic_id=$pic_id_from_local_podborka[0]";
            for ($i=1; $i < count($pic_id_from_local_podborka)-1; $i++) { 
                $query .= " OR pic_id=$pic_id_from_local_podborka[$i]";
            }
            $count_of_pic_id = count($pic_id_from_local_podborka)-1;
            $query .= ") GROUP BY tag_id_num HAVING COUNT(tag_id_num)=$count_of_pic_id";
            $res = pg_query($cn,$query);
            if($row = pg_fetch_object($res))
            {
                $tag_id_num = $row->tag_id_num;
                $query = "SELECT kword_name FROM kwords WHERE status=1 AND (tag_id_num=$tag_id_num";
                while($row = pg_fetch_object($res))
                {
                    $tag_id_num = $row->tag_id_num;
                    $query .= " OR tag_id_num=$tag_id_num";
                }
                $query .= ")";
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
}

function link_kword(){
    $img_names = explode("|",$_POST['img_names']);
    $new_kwords = explode("|",$_POST['new_kwords']);
    array_pop($new_kwords);
    $delete_kwords = explode("|",$_POST['delete_kwords']);
    array_pop($delete_kwords);
    $auto_kwords = explode("|",$_POST['auto_kwords']);
    array_pop($auto_kwords);
    print_r($auto_kwords);
    $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
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

        

        $pic_id = substr($img_name,0,strpos($img_name,'.'));

        for($j=0; $j < count($auto_kwords);$j++)
        {
            if($delete_kwords[$j]==1)
            {
                $shl = 'exiftool -XMP-dc:subject-="'.$auto_kwords[$j].'" img/'.$img_name;
                $res = shell_exec($shl);
                echo "$shl";
                $query = "SELECT tag_id_num FROM kwords WHERE kword_name='$auto_kwords[$j]'";
                $res = pg_query($cn,$query);
                echo "$query";
                $tag_id_num = pg_fetch_object($res)->tag_id_num;
                $query = "DELETE FROM pictags WHERE tag_id_num=$tag_id_num AND pic_id=$pic_id";
                $res = pg_query($cn,$query);
            }
        }

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
            
            $shl = 'exiftool -XMP-dc:subject+="'.$selected_kword.'" img/'.$img_name;
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

function download() {
  //ДОБАВИТЬ ПРОВЕРКУ НА СЛУЧАЙ, ЕСЛИ title УЖЕ СУЩЕСТВУЕТ 
  
  $dir = 'img_to_download/';
  $files = scandir($dir);
  foreach ($files as $key => $filename) {
      if($filename != '.' && $filename != '..')
      {
        $filesize = filesize($dir.$filename);
        $ext = end(explode(".",$filename));
        add_to_bd($filename,$filesize,$ext);
      }
  }
}

function add_to_bd($filename,$fsize,$ext) {
  $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
  $date = '2023-01-18 01:55:53';
  $width = 0;
  $height = 0;
  $title = $filename;
  $subscr = "";
  $rights = "";
  // echo "ФОРМИРОВАНИЕ КОМАНД НА ЧТЕНИЕ МЕТАИНФОРМАЦИИ <br>";
  $shl = 'exiftool img_to_download/'.addcslashes($filename, " ");
  $res = shell_exec($shl);
  $arr = explode("\n", $res);
  $list = array("DateTime",
                "ModifyDate",
                "FileModifyDate",
                "ImageWidth",
                "ImageHeight",
                "Label",
                "Title",
                "AuthorPosition",
                "ObjectName",
                "By-lineTitle",
                "UserComment",
                "Description",
                "ImageDescription",
                "Headline",
                "Caption-Abstract",
                "Country",
                "Country-PrimaryLocationName",
                "State",
                "Province-State",
                "City",
                "Subject",
                "Keywords",
                "Creator",
                "Artist",
                "Author",
                "Identifier",
                "Rights",
                "Copyright",
                "CopyrightNotice");
  $list2 = array(1,1,1,2,3,4,5,5,5,5,6,6,6,6,6,7,7,8,8,9,10,10,11,11,11,12,13,13,13);
  $last_query = "";
  foreach ($arr as $key => $value) {
    $strTag = str_replace(' ', '', substr($value, 0,strpos($value, ":")));
    $strValue = trim(substr($value, strpos($value, ":")+1,strlen($value)));
    if(in_array($strTag, $list)){

      $tag_id = $list2[array_search($strTag, $list)];

      $query = "SELECT pics_name FROM tags WHERE tag_id=$tag_id";
      $res = pg_query($cn,$query);
      $row = pg_fetch_object($res);
      $pics_name = $row->pics_name;
      if($pics_name=='date')
      {
        $str1 = substr($strValue,0, strpos($strValue, ' '));
        $str1 = str_replace(':','-', $str1);
        $str1 =  $str1.substr($strValue,strpos($strValue, ' '));
        if(strpos($str1,'+'))$str1 = substr($str1,0,strpos($str1,'+'));
        $strValue = $str1;
        // echo "$strValue<br>";
      }

      $query = "SELECT tag_id_num FROM kwords WHERE tag_id=$tag_id AND kword_name='".$strValue."'";
      $res = pg_query($cn,$query);
      // echo "ЗАПРОСИК $query <br>";
      $row = pg_fetch_object($res);
      $tag_id_num = $row->tag_id_num;
      if(!$tag_id_num)
      {
        // echo "СОЗДАНИЕ ТЭГА $strValue<br>";
        //Тут автоматически создаются тэги
        if($tag_id != 10)
        {
          $query = "INSERT INTO kwords(tag_id,kword_name,status) VALUES($tag_id,'$strValue',0)";
          $res = pg_query($cn,$query);
          
          $query = "SELECT tag_id_num FROM kwords WHERE tag_id=$tag_id AND kword_name='$strValue'";
          $res = pg_query($cn,$query);
          $row = pg_fetch_object($res);
          $tag_id_num = $row->tag_id_num;

          $query = "INSERT INTO kwgkw(gkword_id,tag_id,tag_id_num) VALUES(0,$tag_id,$tag_id_num)";
          $res = pg_query($cn,$query);

          $last_query .= "INSERT INTO pictags(pic_id,tag_id,tag_id_num) VALUES('-pic_id-',$tag_id,$tag_id_num);";
        }
        else
        {
          $kword_names = explode(",", $strValue);
          // echo "<b style='color:green'><pre> МАССИВ ТЭГОВ";
          // print_r($kword_names);
          // echo "</pre></b><br>";
          foreach ($kword_names as $a => $kword_name) {
            $kword_name = trim($kword_name);
            $query = "SELECT tag_id_num FROM kwords WHERE kword_name = '$kword_name'";
            $res = pg_query($cn,$query);
            if(!pg_fetch_object($res))
            {
              //если такого еще нет
              $query = "INSERT INTO kwords(tag_id,kword_name,status) VALUES($tag_id,'$kword_name',0)";
              $res = pg_query($cn,$query);

              $query = "SELECT tag_id_num FROM kwords WHERE tag_id=$tag_id AND kword_name='$kword_name'";
              $res = pg_query($cn,$query);
              $row = pg_fetch_object($res);
              $tag_id_num = $row->tag_id_num;

              $query = "INSERT INTO kwgkw(gkword_id,tag_id,tag_id_num) VALUES(0,$tag_id,$tag_id_num)";
              $res = pg_query($cn,$query);
            }
            else
            {
              //если такой уже есть
              $query = "SELECT tag_id_num FROM kwords WHERE tag_id=$tag_id AND kword_name='$kword_name'";
              $res = pg_query($cn,$query);
              $row = pg_fetch_object($res);
              $tag_id_num = $row->tag_id_num;
            }
            $last_query .= "INSERT INTO pictags(pic_id,tag_id,tag_id_num) VALUES('-pic_id-',$tag_id,$tag_id_num);";
          }
        }
      }
      else
      {
        // echo "ТЭГ $strValue уже есть tag_id_num = $tag_id_num <br>";
        $last_query .= "INSERT INTO pictags(pic_id,tag_id,tag_id_num) VALUES('-pic_id-',$tag_id,$tag_id_num);";
      }
          
      switch ($pics_name) {
        case 'date':
          $date = $strValue;
          break;
        case 'width':
          $width = $strValue;
          break;
        case 'height':
          $height = $strValue;
          break;
        case 'title':
          $title = $strValue;
          break;
        case 'subscr':
          $subscr = $strValue;
          break;
        case 'rights':
          $rights = $strValue;
          break;
      }
    }
  }
  $md5 = md5_file("img_to_download/".$filename);
  $query = "INSERT INTO pics(fmt,subscr,title,width,height,date,fsize,md5,rights) VALUES('".$ext."','".$subscr."','".$title."',$width,$height,'".$date."',$fsize,'".$md5."','".$rights."')";
  $res = pg_query($cn,$query);
  // echo "ЗАПРОСИК $query<br>";

  $query = "SELECT pic_id FROM pics WHERE title='$title'";
  $res = pg_query($cn,$query);
  // echo "ЗАПРОСИК $query<br>";
  $row = pg_fetch_object($res);
  $pic_id = $row->pic_id;
  if($pic_id)
  {
    $last_query = str_replace("'-pic_id-'", $pic_id, $last_query);
    pg_query($cn,$last_query);
    // echo "ЗАПРОСИК $last_query<br>";

    $shl = 'mv img_to_download/'.addcslashes($filename," ")." img_to_download/$pic_id.$ext";
    //echo "Попытка переименовать $shl <br>";
    $res = shell_exec($shl);
    //echo "$shl <br>$res<br>";
    $shl = 'mv img_to_download/$pic_id.$ext img';
    echo "Попытка перенести <br>";
    $res = shell_exec($shl);
    echo "$shl <br>$res<br>";
    //echo "$pic_id|";
  }
  else
  {
    // echo "<b style='color:rgb(228, 79, 79)'>Ошибка $title добавления в базу. Файл добавлен с ошибками, требуется вмешательство администратора</b>";
  }
  
}

?>
