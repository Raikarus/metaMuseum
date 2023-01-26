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
       let tags_with_status = [];
       let tags_normal = [];
       let tags_del = [];
       let tags_auto = [];
       let tags_auto_del = [];
       let selected = [];
        // фиксированный пизже
     
 $(document).ready(function(){
    load_tags();
    load_auto_tags();
  
 /* for(var i = 0; i < (document.getElementsByName("tags_button")).length;i++)    //заполнили массивы всем что сейчас есть можно, переписать когда инфа будет приходить с бека
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
*/
           // отображаем все теги что есть 

        $('.normal_tags').on("click",".transparent_check_box",function(){
          
            var clickBtnValue = $(this).is(":checked");
            
           
            if(clickBtnValue=='0')  //тег есть жмакнули для удаления
            {

                console.log(tags_normal);
                 console.log(tags_del);
                for(var i = 0; i < (document.getElementsByName("tags_button")).length;i++)
                  {
                    if(tags_normal[i] == $(this).data('str')) // ищем к какому объекту в массиве принадлежит жмакнутый черт по data str
                    {
                     //  $(tags_normal[i]).data('val',0); 
                        //tags_del.push(tags_normal[i]); //добавляем в удаленные 
                        selected.push(tags_normal[i]);
                       // tags_normal.splice(i,1); // удаляем из нормальных от позиции i один элемент

                        break;
                    }

                    if(tags_auto[i] == $(this).data('str')) // ищем к какому объекту в массиве принадлежит жмакнутый черт по data str
                    {
                     //  $(tags_normal[i]).data('val',0); 
                        selected.push(tags_auto[i]); //добавляем в удаленные 
                       // tags_auto.splice(i,1); // удаляем из нормальных от позиции i один элемент

                        break;
                    }
                  }
                  console.log(selected);
                // $(this).data('val',1); ну надо примени не надо удали 
                console.log("1");
           
            }
            else
            {
                 for(var i = 0; i < (document.getElementsByName("tags_button")).length;i++)
                  {
                    if(tags_del[i]== $(this).data('str'))
                    {
                      // $(tags_del[i]).data('val',1);
                        selected.push(tags_auto[i]);
                        //tags_del.splice(i,1);

                        break;
                    }
                      if(tags_auto_del[i] == $(this).data('str')) // ищем к какому объекту в массиве принадлежит жмакнутый черт по data str
                    {
                     //  $(tags_normal[i]).data('val',0); 
                         selected.push(tags_auto[i]); //добавляем в удаленные 
                        //tags_auto_del.splice(i,1); // удаляем из нормальных от позиции i один элемент

                        break;
                    }
                  }
                   console.log("1");
               //  $(this).data('val',0);
               //update_tags();

            }
            update_tags();
            save_tags();
          });
       });
          

       
       function update_tags() //добавить вывод в разные блоки вместо изменения существующих тегов
       {  
            try
              {
              //  console.log(tags_normal);
             //    console.log(tags_del);
              $(".normal_tags").html("");
               for(var i = 0; i < tags_normal.length;i++)
                {
                     
                        $("#norm_tags").append('<label name="tags_button" data-val = "1"><input type="checkbox" name = "transparent_check_box" class="transparent_check_box" data-str = '+tags_normal[i]+' checked><span class = "cloud_tag" style="font-size:40 ;">'+tags_normal[i]+'</span></label>');
                      
                }
                for(var i = 0; i < tags_del.length;i++)
                {
                
                         $("#del_tags").append('<label name="tags_button" data-val = "0"><input type="checkbox" name = "transparent_check_box" class="transparent_check_box" data-str = '+tags_del[i]+' ><span class = "cloud_tag" style="font-size:40 ;color: #CD5C5C;">'+tags_del[i]+'</span></label>');
                }

                 for(var i = 0; i < tags_auto.length;i++)
                {
                
                         $("#tags_auto").append('<label name="tags_button" data-val = "0"><input type="checkbox" name = "transparent_check_box" class="transparent_check_box" data-str = '+tags_auto[i]+' checked><span class = "cloud_tag" style="font-size:40 ;color: #2c75ff;">'+tags_auto[i]+'</span></label>');
                }
                 for(var i = 0; i < tags_auto_del.length;i++)
                {
                
                         $("#tags_auto_del").append('<label name="tags_button" data-val = "0"><input type="checkbox" name = "transparent_check_box" class="transparent_check_box" data-str = '+tags_auto_del[i]+' ><span class = "cloud_tag" style="font-size:40 ;color: #CD5C5C;">'+tags_auto_del[i]+'</span></label>');
                }
                for(var i = 0; i < document.getElementsByName("transparent_check_box").length;i++)
                {
                     for(var j = 0; j < selected.length;j++)
                    {
                        if($(document.getElementsByName("transparent_check_box")[i]).data('str') == selected[j])
                        {
                            document.getElementsByName("transparent_check_box")[i].html = '<label name="tags_button" data-val = "0"><input type="checkbox" name = "transparent_check_box" class="transparent_check_box" data-str = '+selected[j]+' checked><span class = "cloud_tag" style="font-size:40 ;color: #2c75ff;">'+selected[j]+'</span></label>';
                        }
                    }
                }
              }
              catch
              {
                console.log("oh no CRINGE");
              }
             
             

             
       }
       function load_tags()
       {
        var ajaxurl = 'ajax_tags.php';
        data = {'action':'load_tags'};
        $.post(ajaxurl,data).done(function(responce){ 

         
           console.log(responce);
            tags_with_status = responce.split(',');
            var str;
            for(var i = 0; i < tags_with_status.length;i++)
            {
              
                 if(tags_with_status[i].split('|')[1] == 1) 
                 {
                    tags_normal.push((tags_with_status[i]).split('|')[0]);
                 }
                 else
                 {
                    if(tags_with_status[i].split('|')[1] == 11) 
                    {
                         tags_del.push((tags_with_status[i]).split('|')[0]);
                    }
                 }
            }
           update_tags(); 

        });

       }

       function load_auto_tags()
       {
        var ajaxurl = 'ajax_tags.php';
        data = {'action':'load_auto_tags'};
        $.post(ajaxurl,data).done(function(responce){ 

         
           console.log(responce);
            tags_with_status = responce.split(',');
            var str;
            for(var i = 0; i < tags_with_status.length;i++)
            {
              
                  if(tags_with_status[i].split('|')[1] == 0) 
                 {
                    tags_auto.push((tags_with_status[i]).split('|')[0]);
                 }
                 else
                 {
                    if(tags_with_status[i].split('|')[1] == 10) 
                    {
                         tags_auto_del.push((tags_with_status[i]).split('|')[0]);
                    }
                 }
            }
           update_tags(); 

        });

       }

        function save_tags()
        {
            var responce_str;
            for(var i = 0; i < tags_normal.length;i++)
            {
                responce_str += tags_normal[i]+"|1,"; 
            }
             for(var i = 0; i < tags_del.length;i++)
            {
                responce_str += tags_del[i]+"|11,"; 
            }

            console.log(responce_str);

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
                <div style="width: 100%; height: 90%;"> </div>
                <div style="width: 100%; height: 10%;display: flex;justify-content: center;"> <button> save</button> <button> delete</button> <button>replace</button> <button>undelete</button></div>

               </div>
               <div class = "combo_tags">
                <div class="normal_tags" id = "norm_tags">

                  </div>
                  <div class="normal_tags" id = "tags_auto">

                  </div>
                  <div class="normal_tags"  id = "del_tags">
                  </div>
                  <div class="normal_tags"  id = "tags_auto_del">
               
                    
                  </div>
               </div>
               
         </div>      
      </div>
   </div>
</body>
</html>
