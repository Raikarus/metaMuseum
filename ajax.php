<?php
    
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'read':
                read();
                break;
            case 'list':
                $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
                list_l();
                break;
            case 'pics':
                $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
                pics();
                break;
            case 'kwords':
                $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
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
        $query = "SELECT * FROM pics";
        $res = pg_query($cn,$query);
        $row = pg_fetch_all($res);
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }

    function kwords() {
        $query = "SELECT * FROM kwords";
        $res = pg_query($cn,$query);
        $row = pg_fetch_all($res);
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }

    function pictags()  {
        $query = "SELECT * FROM pictags";
        $res = pg_query($cn,$query);
        $row = pg_fetch_all($res);
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }

    function remove()   {
        $query = "DELETE FROM pics";
        pg_query($cn,$query);
        $query = "DELETE FROM pictags";
        pg_query($cn,$query);

        $query = "rm img/*";
        shell_exec($query);
    }

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
            $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
            $query = "INSERT INTO pics(title,fmt,fsize) VALUES('".$file['name']."','$ext',".$file['size'].")";
            echo "<br>".$cn."--=--".$query."<br>";
            $res = pg_query($cn,$query);
        return Array('filename' => $prefix.$nameFile.$ext);
    }
    function Download() {
        if($_POST['pass']=="schef2002"){
            echo "П4р0ль пр0йд3н <br>";
            $res=upload_file($_FILES['imgfile'],$_POST['etc']);
            foreach($res as $a => $b){
                    echo $a." ".$b."<br>";
            }
        }
        else
        {
            echo "П4р0ль не пр0йд3н <br>";
        }
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
    }
?>