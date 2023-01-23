<?php
  function Download() {
  //ДОБАВИТЬ ПРОВЕРКУ НА СЛУЧАЙ, ЕСЛИ title УЖЕ СУЩЕСТВУЕТ 
  if($_POST['passDownload']=="schef2002"){
      // echo "П4р0ль пр0йд3н <br>";
      
      $files = array();
      
      foreach($_FILES['imgfile'] as $k => $l) {
        foreach($l as $i => $v) {
          $files[$i][$k] = $v;
        }
      }   
      $_FILES['imgfile'] = $files;
      // echo "<pre>";
      //print_r($_FILES['imgfile']);
      // echo "</pre>";
      foreach ($_FILES['imgfile'] as $key => $value) {
        $res = upload_file($value,$_POST['etc']);
        foreach($res as $a => $b){
              echo $a." ".$b."<br>";
        }
      }
  }
  else
  {
      // echo "П4р0ль не пр0йд3н <br>";
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
  // echo "ФОРМИРОВАНИЕ КОМАНД НА ЧТЕНИЕ МЕТАИНФОРМАЦИИ <br>";
  $shl = 'exiftool img/'.addcslashes($filename, " ");
  // echo "$shl <br>";
  $res = shell_exec($shl);
  // echo "<pre>$res</pre>";
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
      // echo "<br>";

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
          // echo "<b style='color:green'><pre> МАССИВ ТЭГОВ 10";
          //print_r($kword_names);
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
        default:
          # code...
          break;
      }
    }
  }
  $md5 = md5_file("img/".$filename);
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

    $shl = 'mv img/'.addcslashes($filename," ")." img/$pic_id.$ext";
    // echo "Попытка переименовать $shl <br>";
    $res = shell_exec($shl);
    // echo "$shl <br>$res<br>";  
  }
  else
  {
    // echo "<b style='color:rgb(228, 79, 79)'>Ошибка $title добавления в базу. Файл добавлен с ошибками, требуется вмешательство администратора</b>";
  }
  
}
?>

<script>
var mod_2 = "podborka";
var switcher = $('#mod_switch');
switcher.checked = true;
let selected_images = [];
let selected_images_id = [];

$(document).ready(function(){
    
    function get_podborka_value()
    {
      var ajaxurl = 'ajax_pictags.php';
      data = {'action': 'get_podborka_value'};

      $.post(ajaxurl,data).done(function(response){
        // alert(response);
        podborka = response;
        pre_load();
      });
    }

    function pre_load()
    {
      var ajaxurl = 'ajax_pictags.php';
      data = {'action': 'pre_load', 'podborka':podborka};
      $.post(ajaxurl,data).done(function(response){
        $('.photos_compilation').html(response);
      });
    }
    get_podborka_value();

    function load_page()
    {
      var selected_images_string = "";
      var selected_images_id_string = "";
      for(var i = 0; i < selected_images.length;i++)
      {
         selected_images_string += selected_images[i] + '|';
         selected_images_id_string += selected_images_id[i]+"|";
      }

      var ajaxurl = 'ajax_pictags.php';
      if(switcher.checked)
      {
        data =  {'action': 'load_podborka','img_string':selected_images_string};
        $.post(ajaxurl, data).done(function(response) {
          $('#wrapping').html(response);
          data =  {'action': 'load_cross_kwords','img_string':selected_images_id_string};
          $.post(ajaxurl,data).done(function(response){
            $('.wrap').html(response);
            check_selection();
            check_auto_tag();
            update_user_kwords();
          });
        });
      } 
      else
      {
        data =  {'action': 'load_download'};
        $.post(ajaxurl, data).done(function(response) {
          $('#wrapping').html(response);
        });
      }
    }

    $('#compilation').on("click",".compilation_li .comp_li_button",function(){
      var clickBtnValue = $(this).data('val');

      if(clickBtnValue=='0')
      {
        $(this).css('background-color', '#24B47E');
        $(this).data('val','1');
        $(this).attr('data-val',"1");
        selected_images.push(String($(this).data('img')));
        selected_images_id.push(String($(this).data('id')));
      }
      else
      {
        $(this).css('background-color', 'rgba(255, 255, 255, 0)');
        $(this).data('val','0');
        $(this).attr('data-val',"1");
        var index = selected_images.indexOf($(this).data('img'));
        selected_images.splice(index,1);
        selected_images_id.splice(index,1);
      }
      load_page();
    });
    
    $('#mod_swapper').change(function(){
      if (switcher.checked)
      {
         switcher.checked = false;
         $('.current_mod').text('Загрузка');
         $('.photos_compilation').html("");
         load_page();
       }
      else
      {
         switcher.checked = true;
         $('.current_mod').text('Галерея');
         pre_load();
         load_page();
      }
    });

    //Проверка выделений при переключении режимов загрузка/подборка
    function check_selection()  {
      for (var i = 0; i < selected_images.length; i++) {
        $('.comp_li_button[data-img="'+selected_images[i]+'"]').css('background-color', '#24B47E');
        $('.comp_li_button[data-img="'+selected_images[i]+'"]').data("val",1);
      }
    }

    //Заполнение массива общих тэгов
    function check_auto_tag() {
      //Добавить проверку на выпадающий список
      var auto_tags = document.querySelectorAll('.key_words[data-status="automatic"]');
      result_tags_auto_pg2 = [];
      result_tags_delete_pg2 = [];
      for(var i = 0; i < auto_tags.length;i++)
      {
        result_tags_auto_pg2.push($(auto_tags[i]).data("tag"));
        result_tags_delete_pg2.push(0);
      }
    }

    function show_kwords()  {
      var ajaxurl = 'ajax.php';
      data =  {'action': 'show_kwords'}; 
      $.post(ajaxurl, data).done(function (response) {
        $(".list_of_groups").html(response);
        build_poisk();
      });
    }
    show_kwords();


    $(".wrap").on("click",".key_words[data-status='automatic']",function(){
      if($(this).data("delete")==0)
      {
        $(this).css('background-color','rgb(228,79,79)');
        $(this).data("delete",1);
        result_tags_delete_pg2[$(this).index()]=1;
      }
      else
      {
        $(this).css('background-color','#181818');
        $(this).data("delete",0);
        result_tags_delete_pg2[$(this).index()]=0;
      }
    });

    $('#link_tags').click(function(){
      var ajaxurl = 'ajax_pictags.php';
      var new_kwords = "";
      var delete_kwords = "";
      var img_names = "";
      var auto_kwords = "";
      for (var i = 0; i < result_tags_pg2.length; i++) {
        new_kwords += result_tags_pg2[i] + "|";
      }
      for (var i = 0; i < result_tags_delete_pg2.length; i++) {
        delete_kwords += result_tags_delete_pg2[i] + "|";
      }
      for (var i = 0; i < selected_images.length; i++) {
        img_names += selected_images[i] + "|";
      }
      for (var i = 0; i < result_tags_auto_pg2.length; i++) {
        auto_kwords += result_tags_auto_pg2[i] + "|";
      }
      data = {'action':'link_keyword','img_names':img_names,'new_kwords':new_kwords,'delete_kwords':delete_kwords,'auto_kwords':auto_kwords};
      $.post(ajaxurl,data).done(function(response)  {
        console.log(response);
        alert("Готово! Обновите страницу");
      });
    });
});

</script>
<div class = "main">
  <div class = "main_left">
    <div class="switcher_block">
      <span class = "current_mod">Галерея</span>
      <label id = "mod_swapper">
         <input type = "checkbox" id = "mod_switch" checked>
         <span class = "slider"></span>
      </label>
    </div>
    <ul class = "photos_compilation" id = "compilation">
              
    </ul>
  </div>
  <div class = "main_center">
    <ul class = "photos" id = "wrapping">
       	
    </ul>
  </div>

  <div class = "main_right">
    <div class = "all_tags">
          <form autocomplete = "off" class = "searching">
             <div class = "autocomplete">
                <input id = "myInput" class = "searchbar" type = "text" placeholder = "Search tags!">
               
             </div>
             <input type = "button" id = "addtag" class = "addtag" value = "ADD">

          </form>
          <div class = "tags">
            <ul class = "list_of_groups">
                <!-- Два режима: kwords И подборки (SELECTIONS) -->
         </ul>
          </div>
    </div>
    <div class = "choosen_tags">
       <ul class = "wrap">
          
       </ul>
       <!-- ПОМЕНЯТЬ СТИЛИ -->
       <button id = "link_tags" style="width:80px;height:35px;position: absolute;bottom: 15px;right: 15px;display: flex;justify-content: center;align-items: center">
         Сохранить
       </button>
       <!-- ПОМЕНЯТЬ СТИЛИ -->
    </div>
  </div>

</div>