<?php
  $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
  $res = pg_query($cn,"SELECT * FROM gallery");
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
<link rel="stylesheet" href="css/style_header.css"  type="text/css">
<link rel="stylesheet" href="css/style1.css"  type="text/css">
<script type="text/javascript" src = "js/jq.js"></script>
<script type="text/javascript" src = "js/script.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <script>
       let tags_normal = [];
       let tags_del = [];


        // фиксированный пизже
     
 $(document).ready(function(){


  for(var i = 0; i < (document.getElementsByName("tags_button")).length;i++)    //заполнили массивы всем что сейчас есть можно, переписать когда инфа будет приходить с бека
        {
          if($(document.getElementsByName("tags_button")[i]).data('val') == 1)
          {
             tags_normal.push(document.getElementsByName("tags_button")[i]);
          }
          else
          {
            tags_del.push(document.getElementsByName("tags_button")[i]);
          }
          
        }

        update_tags();    // отображаем все теги что есть 

        $('.normal_tags').on("click",".transparent_check_box",function(){
          
            var clickBtnValue = $(this).is(":checked");
            
           
            if(clickBtnValue=='0')  //тег есть жмакнули для удаления
            {
                for(var i = 0; i < (document.getElementsByName("tags_button")).length;i++)
                  {
                    if($(tags_normal[i]).data('str') == $(this).data('str')) // ищем к какому объекту в массиве принадлежит жмакнутый черт по data str
                    {
                       $(tags_normal[i]).data('val',0); 
                        tags_del.push(tags_normal[i]); //добавляем в удаленные 
                        tags_normal.splice(i,1); // удаляем из нормальных от позиции i один элемент

                        break;
                    }
                  }
                // $(this).data('val',1); ну надо примени не надо удали 

             update_tags();
            }
            else
            {
                 for(var i = 0; i < (document.getElementsByName("tags_button")).length;i++)
                  {
                    if($(tags_del[i]).data('str') == $(this).data('str'))
                    {
                       $(tags_del[i]).data('val',1);
                        tags_normal.push(tags_del[i]);
                        tags_del.splice(i,1);

                        break;
                    }
                  }
               //  $(this).data('val',0);
               update_tags();

            }
          });
       });
          

       
       function update_tags() //добавить вывод в разные блоки вместо изменения существующих тегов
       {  
            try
              {
               for(var i = 0; i < tags_normal.length;i++)
                {
                 
                       tags_normal[i].innerHTML = ' <label name="tags_button" data-val = "1"><input type="checkbox" name = "transparent_check_box" class="transparent_check_box" data-str = '+$(tags_normal[i]).data('str')+' checked><span class = "cloud_tag" style="font-size:30 ;">'+$(tags_normal[i]).data('str')+'</span></label>';
                }
                for(var i = 0; i < tags_del.length;i++)
                {
                        tags_del[i].innerHTML = ' <label name="tags_button" data-val = "0"><input type="checkbox" name = "transparent_check_box" class="transparent_check_box" data-str = '+$(tags_del[i]).data('str')+' ><span class = "cloud_tag" style="font-size:30 ;color: #CD5C5C;">'+$(tags_del[i]).data('str')+'</span></label>';
                }
              }
              catch
              {
                console.log("oh no CRINGE");
              }

                tags_normal = []; 
                tags_del = [];
                
                for(var i = 0; i < (document.getElementsByName("tags_button")).length;i++)
                      {
                        if($(document.getElementsByName("tags_button")[i]).data('val') == 1)
                        {
                           tags_normal.push(document.getElementsByName("tags_button")[i]);
                        }
                        else
                        {
                          tags_del.push(document.getElementsByName("tags_button")[i]);
                        }
                        
                      }
             
       }

       
    </script>
<title>Главная</title>
</head>
<body>

<header>
      <div class = "container">
         <div class = "logo_container">
            <a class = "logo" href = "/?form=home">
               DATABASE
            </a>
              <label class="switch">
              <input type="checkbox">
              
            </label>
         </div>
         <ul class = username_exit>
            <li class = "usit_elem username">Username</li>
            <li class = "usit_elem exit"><a class = "exit" href = "#">Exit</a></li>
         </ul>
      </div>
   </header>

<div class = "main_tag">
   
      <div class = "main_right_version">
         <div class = "high_main">
               <div class = "searching">
                  <form class = "searching_form">
                     <input type = "text" name = "search" class = "search" placeholder="Search tags!">
                     <input type = "submit" name = "submit" class = "submit" value="ADD">
                  </form>
               </div>
               <div class = "tags_group" >
               
                
               </div>
               <div class = "combo_tags">
                <div class="normal_tags" id = "norm_tags">
                  <ul class = "wrap">
                  </ul>
                  <?php 
                          $tags  = "step_mom massage anal ebony big_ ass teen threesome public anime creampie";
                          $tag = explode(" ", $tags);
                          
                        for($i = 0; $i < count($tag);$i++)
                        {
                           $size = 30;
                            echo ' <label name="tags_button" data-val = "1" data-str ="'.$tag[$i].'">
                                   <input type="checkbox" name = "transparent_check_box" data-str ="'.$tag[$i].'" class="transparent_check_box" checked>
                                   <span class = "cloud_tag" style="font-size:'.$size.';">'.$tag[$i]."($size) ".'</span>
                                   </label>';
                        }
                        ?> 
                  </div>
                  <div class="normal_tags" style="border-left: 1px solid white; " id = "del_tags">
                  <ul class = "wrap">
                  </ul>
                  <?php 
                          $tags  = "japanese hentai lesbian milf korean asian";
                          $tag = explode(" ", $tags);
                          
                        for($i = 0; $i < count($tag);$i++)
                        {
                           $size = 30;
                            echo ' <label name="tags_button" data-val = "0" data-str ="'.$tag[$i].'">
                                   <input type="checkbox" name = "transparent_check_box" data-str ="'.$tag[$i].'" class="transparent_check_box">
                                   <span class = "cloud_tag" style="font-size:'.$size.';color: #CD5C5C;">'.$tag[$i]."($size) ".'</span>
                                   </label>';
                            echo "\n";
                        }
                        ?> 
                  </div>
               </div>
               
         </div>      
      </div>
   </div>
</body>
</html>
