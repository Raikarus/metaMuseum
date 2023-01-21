<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<link rel="stylesheet" href="css/style2.css"  type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript" src = "js/script.js"></script>
<title>Главная</title>

</head>
<body>
<!-- ТУТ ПОМЕНЯТЬ СТИЛИ -->
         <div id = "name_podborka_form_back">
            <div id = "name_podborka_form">
               <h3>Введите название:</h3>
               <input id = "podborka_name" type="text" name="name_for_podborka">
               <input id = "create_podborka" type="submit" value = "Создать">
               <div id = "response"></div>
            </div>
         </div>
<!-- ТУТ ПОМЕНЯТЬ СТИЛИ -->
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
