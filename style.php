<?php
	$cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
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
         <div id = "#name_podborka_form" style="position: absolute;display: none; width: 400px;height: 250px;background-color: rgba(255,255,255,0.8);">
         </div>
         <ul class = "photos" id = "wrapping">
		</ul>
         <div class = "left_right_but">
            <button class = "button left" data-val="left">
               ←
            </button>
            <div id = "current_page" data-val="1">1</div>
            <button class = "button right" data-val="right">
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
                        //
                        // Добавить работу со status в таблице kwords
                        //
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
                              $row2 = pg_fetch_object($res2);
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
                                    $font_size = (round(($row3/$total)*100)+15)."px";
                                    echo "<li class='list_item'><a href='#' data-en = 0 data-tag = $kword_name style='font-size:$font_size'>$kword_name ($row3)</a></li>";
                                 }
                              }
                              echo '</ul></li>';
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
            <li><input id = "add_to_podborka" type = "submit" name = "funtional" value="Добавить в подборку"></li>
            <li><input class = "select_all" type = "submit" name = "funtional" value="Выделить всё"></li>
            <li><input class = "unselect_all" type = "submit" name = "funtional" value="Снять выделение"></li>
            <!-- <li><input type = "submit" name = "funtional" value="Отменить"></li> -->
         </ul> 
      </div>
      <div class = "instruments" id = "fin_ins">
         <ul class = "panel">
            <li><input type = "submit" name = "funtional" value="Скачать"></li>
            <li><input id = "save_podborka" type = "submit" name = "funtional" value="Сохранить в подборку"></li>
            <li><input id="delete_from_podborka" type = "submit" name = "funtional" value="Удалить из подборки"></li>
            <li><input class = "select_all" type = "submit" name = "funtional" value="Выделить всё"></li>
            <li><input class = "unselect_all" type = "submit" name = "funtional" value="Снять выделение"></li>
         </ul>        
      </div>
      <div class = "switch_size">
         <input type = "submit" name = "sizes" id = "size_small" value = "5x4">
         <input type = "submit" name = "sizes" id = "size_normal" value = "4x3">
         <input type = "submit" name = "sizes" id = "size_big" value = "3x2">
      </div>
   </footer>
</body>
</html>
