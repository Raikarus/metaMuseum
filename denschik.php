<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<link rel="stylesheet" href="style.css"  type="text/css">
<script  src = "jq.js"></script>
<script  src = "script.js"></script>
<title>Главная</title>
</head>
<body>
   <header>
      <div class = "container">
         <div class = "logo_container">
            <a class = "logo" href = "#">
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
            <li class = "photo_li" id = "img_001">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li>
            <li class = "photo_li" id = "img_002">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li>
            <li class = "photo_li" id = "img_003">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li>
            <li class = "photo_li" id = "img_004">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li>
            <li class = "photo_li" id = "img_005">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li>
             <li class = "photo_li" id = "img_006">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li>
             <li class = "photo_li" id = "img_007">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li>
             <li class = "photo_li" id = "img_008">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li>  4
            <li class = "photo_li" id = "img_009">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li> 
            <li class = "photo_li" id = "img_010">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li> 
            <li class = "photo_li" id = "img_011">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li> 
            <li class = "photo_li" id = "img_012">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li> 
            <li class = "photo_li" id = "img_013">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li> 
            <li class = "photo_li" id = "img_014">
               <div class = "photo"></div>
               <div class = "name">Название</div>           
            </li>         
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
                     <li class = "tag_group">                     
                        <p class = "group_name">
                           <input type="checkbox" name = "tags_on" class = tags_checkbox>
                           <a href = "javascript:flipflop('animals');">
                              Животные
                           </a>
                        </p>
                        <ul class = "tag_list" id = "animals" style="display: none;">
                           <li class = "list_item"><a href = "#" id = "">Крокодил</a></li>
                           <li class = "list_item"><a href = "#" id = "">Бегемот</a></li>
                        </ul>
                     </li>   
                     <li class = "tag_group">
                        <p class = "group_name">
                           <input type="checkbox" name = "tags_on" class = tags_checkbox>
                           <a href = "javascript:flipflop('plants');">
                              Растения
                           </a>
                        </p>
                        <ul class = "tag_list" id = "plants" style="display: none;">
                           <li class = "list_item"><a href = "#" id = "">Фикус</a></li>
                           <li class = "list_item"><a href = "#" id = "">Роза</a></li>
                        </ul>
                     </li>    
                     <li class = "tag_group">
                        <p class = "group_name">
                           <input type="checkbox" name = "tags_on" class = tags_checkbox>
                           <a href = "javascript:flipflop('cars');">
                              Машины
                           </a>
                        </p>
                        <ul class = "tag_list" id = "cars" style="display: none;">
                           <li class = "list_item"><a href = "#" id = "">Мерседес</a></li>
                           <li class = "list_item"><a href = "#" id = "">Лада</a></li>
                           <li class = "list_item"><a href = "#" id = "">БМВ</a></li>
                           <li class = "list_item"><a href = "#" id = "">Рино</a></li>
                        </ul>
                     </li>   
                     <li class = "tag_group">
                        <p class = "group_name">
                           <input type="checkbox" name = "tags_on" class = tags_checkbox>
                           <a href = "javascript:flipflop('planes');">
                              Самолёты
                           </a>
                        </p>
                        <ul class = "tag_list" id = "planes" style="display: none;">
                           <li class = "list_item"><a href = "#" id = "">Грузовой</a></li>
                           <li class = "list_item"><a href = "#" id = "">Истребитель</a></li>
                        </ul>
                     </li>      
                  </ul>
               </div>
         </div>
         <div class = "choosen_tags">
            <ul class = "wrap">
               <li class = "choose_item" data-selected = "0">Выбр. Тег 1</li>
               <li class = "choose_item" data-selected = "0">Выбр. Тег 2</li>
               <li class = "choose_item" data-selected = "0">Выбр. Тег 3</li>
               <li class = "choose_item" data-selected = "0">Выбр. Тег 4</li>
               <li class = "choose_item" data-selected = "0">Выбр. Тег 5</li>                  
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
</body>
</html>