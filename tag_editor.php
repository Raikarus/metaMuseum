<?php

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<link rel="stylesheet" href="css/style_header.css"  type="text/css">
<link rel="stylesheet" href="css/style1.css"  type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

<script>
  let tags_with_status = [];
  let tags_normal = [];
  let tags_del = [];
  let tags_auto = [];
  let tags_auto_del = [];
  let selected = [];
  let selected_auto = [];
     
  $(document).ready(function(){
    load_tags();
    load_auto_tags();
  
    $('#del_button').click(function(){
        for(var i = 0; i < selected.length;i++)
          tags_del.push(selected[i]);
        selected = [];

        for(var i = 0; i < selected_auto.length;i++)
          tags_auto_del.push(selected_auto[i]);

        selected_auto = [];
        update_tags();
    });

   $('#replace_button').click(function(){
    for(var i = 0; i < selected.length;i++)
      tags_auto.push(selected[i]);
    selected = [];

    for(var i = 0; i < selected_auto.length;i++)
      tags_normal.push(selected_auto[i]);
    selected_auto = [];

    update_tags();
  });

  $('#undelete_button').click(function(){
    for(var i = 0; i < selected.length;i++)
      tags_normal.push(selected[i]);       
    selected = [];

    for(var i = 0; i < selected_auto.length;i++)
      tags_auto.push(selected_auto[i]);       
    selected_auto = [];

    update_tags();
  });
  
  $('.normal_tags').on("click",".tags_button .solo_tag",function(){
      console.log('1');

      var tag_name = $(this).text();

      var index = tags_normal.indexOf(tag_name);
      if(index >= 0)
      {
        selected.push(tags_normal[index]);
        tags_normal.splice(index,1);
      }
      var index = tags_auto.indexOf(tag_name);
      if(index >= 0)
      {
        selected_auto.push(tags_auto[index]);
        tags_auto.splice(index,1);
      }
      var index = tags_del.indexOf(tag_name);
      if(index >= 0)
      {
        selected.push(tags_del[index]);
        tags_del.splice(index,1);
      }
      var index = tags_auto_del.indexOf(tag_name);
      if(index >= 0)
      {
        selected_auto.push(tags_auto_del[index]);
        tags_auto_del.splice(index,1);
      }

      update_tags();
      save_tags();
    });
 });
    

 
 function update_tags() //добавить вывод в разные блоки вместо изменения существующих тегов
 {  
  try
  {
    $(".normal_tags").html("");
    for(var i = 0; i < tags_normal.length;i++)
    {
      $("#norm_tags").append('<label class="tags_button"><span class = "solo_tag" style="font-size:40px;">'+tags_normal[i]+'</span></label>');
    }
    for(var i = 0; i < tags_del.length;i++)
    {
     $("#del_tags").append('<label class="tags_button"><span class = "solo_tag" style="font-size:40px;color: #CD5C5C;">'+tags_del[i]+'</span></label>');
    }
    for(var i = 0; i < tags_auto.length;i++)
    {
     $("#tags_auto").append('<label class="tags_button"><span class = "solo_tag" style="font-size:40px;color: #2c75ff;">'+tags_auto[i]+'</span></label>');
    }
     for(var i = 0; i < tags_auto_del.length;i++)
    {
     $("#tags_auto_del").append('<label class="tags_button"><span class = "solo_tag" style="font-size:40px;color: #CD5C5C;">'+tags_auto_del[i]+'</span></label>');
    }
  }
  catch
  {
    console.log("oh no CRINGE");
  }
 }
 function load_tags() {
  var ajaxurl = 'ajax_tags.php';
  data = {'action':'load_tags'};
  $.post(ajaxurl,data).done(function(responce){ 

      console.log(responce);
      tags_with_status = responce.split(',');

      for(var i = 0; i < tags_with_status.length;i++)
      {
        if(tags_with_status[i].split('|')[1] == 1) 
          tags_normal.push((tags_with_status[i]).split('|')[0]);
        else if(tags_with_status[i].split('|')[1] == 11) 
            tags_del.push((tags_with_status[i]).split('|')[0]);
      }
     update_tags(); 
  });
 }

 function load_auto_tags() {
  var ajaxurl = 'ajax_tags.php';
  data = {'action':'load_auto_tags'};
  $.post(ajaxurl,data).done(function(responce){ 

      console.log(responce);
      tags_with_status = responce.split(',');

      for(var i = 0; i < tags_with_status.length;i++)
      {
        if(tags_with_status[i].split('|')[1] == 0) 
          tags_auto.push((tags_with_status[i]).split('|')[0]);

        else if(tags_with_status[i].split('|')[1] == 10) 
          tags_auto_del.push((tags_with_status[i]).split('|')[0]);
      }
     update_tags(); 
  });

 }

  function save_tags()
  {
      var responce_str;
      for(var i = 0; i < tags_normal.length;i++)
        responce_str += tags_normal[i]+"|1,"; 

       for(var i = 0; i < tags_del.length;i++)
        responce_str += tags_del[i]+"|11,"; 
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
                <div style="width: 100%; height: 10%;display: flex;justify-content: center;">
                  <button id ="save_button"> save</button>
                  <button id ="del_button"> delete</button>
                  <button id ="replace_button">replace</button>
                  <button id ="undelete_button">undelete</button></div>
               </div>
               <div class = "combo_tags">
                <div class="normal_tags" id = "norm_tags">                </div>
                <div class="normal_tags" id = "tags_auto">                </div>
                <div class="normal_tags"  id = "del_tags">                </div>
                <div class="normal_tags"  id = "tags_auto_del">           </div>
               </div>
               
         </div>      
      </div>
   </div>
</body>
</html>
