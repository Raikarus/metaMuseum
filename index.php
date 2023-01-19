<?php
$cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
function upload_file($file, $nameFile='default', $upload_dir= 'img', $allowed_types= array('image/png','image/x-png','image/jpeg','image/webp','image/gif')){
      $blacklist = array(".php", ".phtml", ".php3", ".php4");
      $filename = $file['name']; // В переменную $filename заносим точное имя файла.
      $ext = strtolower(substr($filename, strrpos($filename,'.')+1, strlen($filename)-1)); // В переменную $ext заносим расширение загруженного файла.
      if(in_array($ext,$blacklist )){
        return array('error' => 'Запрещено загружать исполняемые файлы');}

      $upload_dir = dirname(__FILE__).DIRECTORY_SEPARATOR.$upload_dir.DIRECTORY_SEPARATOR; // Место, куда будут загружаться файлы.
      $max_filesize = 8388608; // Максимальный размер загружаемого файла в байтах (в данном случае он равен 8 Мб).
      $prefix = date('Ymd-is_');
      
      if(!is_writable($upload_dir))  // Проверяем, доступна ли на запись папка, определенная нами под загрузку файлов.
        return array('error' => 'Невозможно загрузить файл в папку "'.$upload_dir.'". Установите права доступа - 777.');
        //  echo $file['type']."TEST".$file['name']."<br>";
        //  if(!in_array($file['type'], $allowed_types))
        //    return array('error' => 'Данный тип файла не поддерживается.');

      if(filesize($file['tmp_name']) > $max_filesize)
        return array('error' => 'файл слишком большой. максимальный размер '.intval($max_filesize/(1024*1024)).'мб');

        if(!move_uploaded_file($file['tmp_name'],$upload_dir.$filename))//$upload_dir.$prefix.$nameFile.$ext)) // Загружаем файл в указанную папку.
            return array('error' => 'При загрузке возникли ошибки. Попробуйте ещё раз.');

        AddToBd($filename,$file['size'],$ext);
            
        return Array('filename' => $prefix.$nameFile.$ext);
    }

function Download() {
  if($_POST['passDownload']=="schef2002"){
      echo "П4р0ль пр0йд3н <br>";
      
      $files = array();
      
      foreach($_FILES['imgfile'] as $k => $l) {
        foreach($l as $i => $v) {
          $files[$i][$k] = $v;
        }
      }   
      $_FILES['imgfile'] = $files;
      echo "<pre>";
      print_r($_FILES['imgfile']);
      echo "</pre>";
      foreach ($_FILES['imgfile'] as $key => $value) {
        $res = upload_file($value,$_POST['etc']);
        foreach($res as $a => $b){
              echo $a." ".$b."<br>";
        }
      }
  }
  else
  {
      echo "П4р0ль не пр0йд3н <br>";
  }
}



function AddToBd($filename,$fsize,$ext) {
  $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
  $date = '2023-01-18 01:55:53';
  $width = 0;
  $height = 0;
  $title = $filename;
  $subscr = "";
  $rights = "";
  $shl = 'exiftool img/'.$filename;
  $res = shell_exec($shl);
  echo "<pre>$res</pre>";
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
      echo "<br>";

      $tag_id = $list2[array_search($strTag, $list)];

      $query = "SELECT pics_name FROM tags WHERE tag_id=$tag_id";
      $res = pg_query($cn,$query);
      $row = pg_fetch_object($res);
      $pics_name = $row->pics_name;
      echo "ЗАПРОСИК $query<br>";
      if($pics_name=='date')
      {
        $str1 = substr($strValue,0, strpos($strValue, ' '));
        $str1 = str_replace(':','-', $str1);
        $str1 =  $str1.substr($strValue,strpos($strValue, ' '));
        if(strpos($str1,'+'))$str1 = substr($str1,0,strpos($str1,'+'));
        $strValue = $str1;
        echo "$strValue<br>";
      }

      $query = "SELECT tag_id_num FROM kwords WHERE tag_id=$tag_id AND kword_name='".$strValue."'";
      $res = pg_query($cn,$query);
      echo "ЗАПРОСИК $query <br>";
      $row = pg_fetch_object($res);

      if(!$row->tag_id_num)
      {
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

          $last_query .= "INSERT INTO pictags(pic_id,tag_id,tag_id_num) VALUES('-pic_id-',$tag_id,$tag_id_num)";
        }
        else
        {
          $kword_names = explode(",", $strValue);
          echo "<b style='color:green'><pre>";
          print_r($kword_names)
          echo "</pre></b><br>";
          foreach ($kword_names as $a => $kword_name) {
            $kword_name = trim($kword_name);
            $query = "SELECT tag_id_num FROM kwords WHERE kword_name = '$kword_name'";
            $res = pg_query($cn,$query);
            if(!pg_fetch_object($res))
            {
              $query = "INSERT INTO kwords(tag_id,kword_name,status) VALUES($tag_id,'$kword_name',0)";
              $res = pg_query($cn,$query);

              $query = "SELECT tag_id_num FROM kwords WHERE tag_id=$tag_id AND kword_name='$kword_name'";
              $res = pg_query($cn,$query);
              $row = pg_fetch_object($res);
              $tag_id_num = $row->tag_id_num;

              $query = "INSERT INTO kwgkw(gkword_id,tag_id,tag_id_num) VALUES(0,$tag_id,$tag_id_num)";
              $res = pg_query($cn,$query);

              $last_query .= "INSERT INTO pictags(pic_id,tag_id,tag_id_num) VALUES('-pic_id-',$tag_id,$tag_id_num)";
            }
          }
        }
      }
      else
      {
        $last_query .= "INSERT INTO pictags(pic_id,tag_id,tag_id_num) VALUES('-pic_id-',$tag_id,$tag_id_num)";
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
        default:
          # code...
          break;
      }
    }
  }
  $md5 = md5_file("img/".$filename);
  $query = "INSERT INTO pics(fmt,subscr,title,width,height,date,fsize,md5,rights) VALUES('".$ext."','".$subscr."','".$title."',$width,$height,'".$date."',$fsize,'".$md5."','".$rights."')";
  $res = pg_query($cn,$query);
  echo "ЗАПРОСИК $query<br>";

  $query = "SELECT pic_id FROM pics WHERE title='$title'";
  $res = pg_query($cn,$query);
  echo "ЗАПРОСИК $query<br>";
  $row = pg_fetch_object($res);
  $pic_id = $row->pic_id;
  if($pic_id)
  {
    $last_query = str_replace("'-pic_id-'", $pic_id, $last_query);
    pg_query($cn,$last_query);
    echo "ЗАПРОСИК $last_query<br>";

    $shl = 'mv img/'.$filename." img/$pic_id.$ext";
    $res = shell_exec($shl);
    echo "$shl <br>$res<br>";  
  }
  else
  {
    echo "<b style='color:red'>Ошибка $title добавления в базу. Файл добавлен с ошибками, требуется вмешательство администратора</b>";
  }
  
}

function LinkKeyword(){
  if($_POST['passLink']=="schef2002"){
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

    $pic_id = substr($_POST['img_name'],0, '.');

    foreach($_POST['kwords'] as $selected_kword)
    {
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
        $shl = 'exiftool -XMP-dc:subject+="'.$selected_kword.'" img/'.$_POST['img_name'];
        $res = shell_exec($shl);
        echo "<br><pre>$res</pre>"; 

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
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>
		SCHEF
	</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

	<script>

	$(document).ready(function(){
    	$('.button').click(function(){
	        var clickBtnValue = $(this).val();
	        var img_name = "img/"+$('#img_name').val();
	        var ajaxurl = 'ajax.php';
	        data =  {'action': clickBtnValue, 'img_name': img_name};
	        $.post(ajaxurl, data, function (response) {
				  $('#output').html(response);
	        });
    	});
	});

	</script>
</head>
<body>
<a href="index.php">Дом</a>
<a href="tags.php">Тэги</a>
<br>
<br>
<form method="post" enctype="multipart/form-data">
  <input type="password" placeholder="пароль" name="passDownload">
	<input id="img" name="imgfile[]" type="file" multiple>
  <input name="Download" value="Download" type="submit">
</form>
<br>
<form method="post">
  <input type="text" name="img_name" placeholder="Название изображения">
  <input type="password" placeholder="пароль" name="passLink">
    <select multiple name="kwords[]">
  <?php
    $query = "SELECT kword_name FROM kwords WHERE tag_id=10";
    $res = pg_query($cn,$query);
    while($row=pg_fetch_object($res))
    {
      echo "<option>".$row->kword_name."</option>";
    }
  ?>
  <input name="LinkKeyword" value="LinkKeyword" type="submit">
</form>
<br>
<input type="text" id="img_name" placeholder="Название изображения" />
<input type="submit" class="button" name="read" value="read" />
<input type="submit" class="button" name="list" value="list" />
<input type="submit" class="button" name="pics" value="pics" />
<input type="submit" class="button" name="pictags" value="pictags" />
<input type="submit" class="button" name="REMOVE" value="REMOVE" />
<br>

<br>
<div id = "output">
  <?php
    Download();
    LinkKeyword();
  ?>
</div>
</body>
</html>