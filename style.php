<?php
	$cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
	//$res = pg_query($cn,"SELECT * FROM gallery");
	//gallery(id,name,party,meta [0/1])
	$form = $_GET['form'];
	$msg = "";
	if($form=='auth'){
		if($_POST['pswd'] == "schef2002"){
			$query = "SELECT * FROM gallery WHERE name='".$_POST['name']."'";
			$res = pg_query($cn,$query);
			$access = "ok";
			while($row=pg_fetch_object($res)){
				$access = "not ok";
				break;
			}
			if($access=="ok"){
				$query="INSERT INTO gallery(name,party,meta) VALUES('".$_POST['name']."','".$_POST['party']."','".$_POST['meta']."')";
				$res = pg_query($cn,$query);
				header("location:/?form=show");
			}
			else{
				$msg = "Такой тэг уже существует";
			}
		}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<link rel="stylesheet" href="css/style.css"  type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript" src = "js/script.js"></script>
<title>Главная</title>
</head>
<body>

<header>
      <div class = "container">
         <div class = "logo_container">
            <a class = "logo" href = "/?form=home">
               DATABASE
            </a>
         </div>
         <ul class = username_exit>
            <li class = "usit_elem username">Username</li>
            <li class = "usit_elem exit"><a class = "exit" href = "#">Exit</a></li>
         </ul>
      </div>
   </header>

<div class = "main">
      <div class = "main_left">
         <ul class = "photos" id = "wrapping">
         	<?php
            //сюда проверку на тэги
               if(true)
               {
                  //$query = SELECT pic_id FROM pictags WHERE tag_id_num =
                  //$query = SELECT title FROM pics WHERE pic_id = 
                  $query = "SELECT title FROM pics";
                  $res = pg_query($cn,$query);
                  while($row=pg_fetch_object($res))
                  {
                     $title = $row->title;
                     echo "
                     <li class='photo_li'>
                           <div class='photo' style='background-image:url(".'"img/'.$title.'"'.")'></div>
                           <div class='name'>$title</div>           
                      </li>
                      ";
                  }
               }
         	?>
		</ul>
         <div class = "left_right_but">
            <button class = "left">
               ←
            </button>
            <div id = "current_page">1</div>
            <button class="right">
               →
            </button>    
         </div>
      </div>
      <div class = "main_right">
         <div class = "all_tags">
               <div class = "searching">
                  <form class = "searching_form">
                     <input type = "text" name = "search" class = "search" placeholder="Search tags!">
                     <input type = "submit" name = "submit" class = "submit" value="ADD">
                  </form>
               </div>
               <div class = "tags">
               		<ul class = "list_of_groups">
               		<?php
                        $query = "SELECT gkword_id,gkword_name FROM gkwords";
                        $res = pg_query($cn,$query);
                        while($row=pg_fetch_object($res))
                        {
                           $gkword_id = $row->gkword_id;
                           if($gkword_id == 0)
                           {
                              $query = "SELECT tag_id,tag_id_num FROM kwgkw WHERE gkword_id=$gkword_id";
                              $res2 = pg_query($cn,$query);
                              $row2 = pg_fetch_object($res2);
                              while($row2=pg_fetch_object($res2))
                              {
                                 $tag_id = $row2->tag_id;
                                 $tag_id_num = $row2->tag_id_num;

                                 if($tag_id == 10)
                                 {
                                    $query = "SELECT kword_name FROM kwords WHERE tag_id_num=$tag_id_num";
                                    $res3 = pg_query($cn,$query);
                                    echo "ЗАПРОСИК $query<br>";
                                    $row3 = pg_fetch_object($res3);
                                    echo '<li class = "tag_group">
                                             <p class = "group_name">
                                                
                                             </p>
                                       <ul class = "tag_list" id = '.$gkword_name.' style="display: none;">';
                                 }
                              }
                           }
                           else
                           {
                              $query = "SELECT "

                              $query = "SELECT kword_name FROM kwords WHERE tag_id_num=$tag_id_num";
                              $res2 = pg_query($cn,$query);
                              $row2=pg_fetch_object($res2);
                              $kword_name=$row2->kword_name;
                              echo '<li class = "tag_group">
                                       <p class = "group_name">
                                          <input type="checkbox" name = "tags_on" class = tags_checkbox>
                                             <a href = "javascript:flipflop('."'".$gkword_name."'".');">'.$gkword_name.'</a>
                                       </p>
                                       <ul class = "tag_list" id = '.$gkword_name.' style="display: none;">';
                           }
                        }


         					$query = "SELECT gkword_id,tag_id_num FROM kwgkw WHERE tag_id=10";
         					$res = pg_query($cn,$query);
         					while($row=pg_fetch_object($res))
         					{
                           $tag_id_num = $row->tag_id_num;
                           $gkword_id = $row->gkword_id;
                           if($gkword_id != 0)
                           {
                              $query = "SELECT gkword_name FROM gkwords WHERE gkword_id=$gkword";
                              $res2 = pg_query($cn,$query);
                              $row2 = pg_fetch_object($res2);
                              $gkword_name = $row2->gkword_name;
                              
                              $query = "SELECT tag_id_num FROM kwgkw WHERE gkword_id=$gkword_id";
                              $res2 = pg_query($cn,$query);
                              while($row2=pg_fetch_object($res2))
                              {
                                 $query = "SELECT kword_name FROM kwords WHERE tag_id_num=$tag_id_num";
                                 $res3 = pg_query($cn,$query);
                                 $row3 = pg_fetch_object($res3);
                                 $kword_name = $row3->kword_name;
                                 echo '<li class = "list_item"><a href = "#" data-en = 0 data-tag = '.$kword_name.'>'.$kword_name.'</a></li>';
                              }
                              echo "</ul></li>";
                           }
                           else
                           {
                              
                           }
         					}
					?>
					</ul>
               </div>
         </div>
         <div class = "choosen_tags">
            <ul class = "wrap">
               
            </ul>
         </div>
      </div>
   </div>

   <footer>
      <div class = "switch_mod">
         <input type = "submit" name = "mods" id = "mod_gallery"value="Галерея">
         <input type = "submit" name = "mods" id = "mod_finder" value="Подборка">
      </div>
      <div class = "instruments" id = "gal_ins">
         <ul class = "panel">
            <li><input type = "submit" name = "funtional" value="Добавить в подборку"></li>
            <li><input type = "submit" name = "funtional" value="Выделить всё"></li>
            <li><input type = "submit" name = "funtional" value="Снять выделение"></li>
            <li><input type = "submit" name = "funtional" value="Отменить"></li>
         </ul> 
      </div>
      <div class = "instruments" id = "fin_ins">
         <ul class = "panel">
            <li><input type = "submit" name = "funtional" value="Скачать"></li>
            <li><input type = "submit" name = "funtional" value="Сохранить в подборку"></li>
            <li><input type = "submit" name = "funtional" value="Удалить из подборки"></li>
            <li><input type = "submit" name = "funtional" value="Выделить всё"></li>
            <li><input type = "submit" name = "funtional" value="Снять выделение"></li>
         </ul>        
      </div>
      <div class = "switch_size">
         <input type = "submit" name = "sizes" id = "size_small" value = "5x4">
         <input type = "submit" name = "sizes" id = "size_normal" value = "4x3">
         <input type = "submit" name = "sizes" id = "size_big" value = "3x2">
      </div>
   </footer>

<main class = "main">
<a href="/?form=auth">Добавить тэг</a><br>
<a href="/?form=obr">Обработка картинок</a><br>
<a href="/?form=add">Добавить картинку</a><br>
<a href="/?form=write">Прикрутить тэг</a><br>
<?php
echo $msg;
switch($form){
case 'auth': include('auth.php');break;
case 'obr': include('obrabotka.php');break;
case 'add': include('add.php');break;
case 'write': include('write.php');break;
default:include('home.php');break;
}
?>
</main>
</body>
</html>