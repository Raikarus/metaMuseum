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
  let selected_left_up = [];
  let selected_left_bot = [];
  let selected_right_up = [];
  let selected_right_bot = [];
     
  $(document).ready(function(){
    load_tags();
    load_auto_tags();
  
    $('#del_button').click(function(){
        for(var i = 0; i < selected_left_up.length;i++)
        {
          tags_del.push(selected_left_up[i]);
          var index = tags_normal.indexOf(selected_left_up[i]);
          if(index >= 0)
            tags_normal.splice(index,1);
        }
        selected_left_up = [];

        for(var i = 0; i < selected_righ_up.length;i++)
        {
          tags_auto_del.push(selected_right_up[i]);
          var index = tags_auto.indexOf(selected_right_up[i]);
          if(index>=0)
            tags_auto.splice(index,1);
        }
        selected_right_up = [];
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

  $('#undel_button').click(function(){
    for(var i = 0; i < selected.length;i++)
      tags_normal.push(selected[i]);       
    selected = [];

    for(var i = 0; i < selected_auto.length;i++)
      tags_auto.push(selected_auto[i]);       
    selected_auto = [];

    update_tags();
  });
  
  $('.combo_tags').on("click","div .solo_tag",function(){
    var tag_name = $(this).text();

    var index = tags_normal.indexOf(tag_name);
    if(index >= 0)
    {
      selected_left_up.push(tags_normal[index]);
      $(this).css('color','red');
    }
    var index = tags_auto.indexOf(tag_name);
    if(index >= 0)
    {
      selected_right_up.push(tags_auto[index]);
      $(this).css('color','red');
    }
    var index = tags_del.indexOf(tag_name);
    if(index >= 0)
    {
      selected_left_bot.push(tags_del[index]);
      $(this).css('color','red');
    }
    var index = tags_auto_del.indexOf(tag_name);
    if(index >= 0)
    {
      selected_right_bot.push(tags_auto_del[index]);
      $(this).css('color','red');
    }
  });
 });
    

 
 function update_tags() {  
  $(".combo_tags div").html("");
  for(var i = 0; i < tags_normal.length;i++)
    $("#norm_tags").append('<span class = "solo_tag">'+tags_normal[i]+'</span>');

  for(var i = 0; i < tags_del.length;i++)
   $("#del_tags").append('<span class = "solo_tag">'+tags_del[i]+'</span>');

  for(var i = 0; i < tags_auto.length;i++)
   $("#tags_auto").append('<span class = "solo_tag">'+tags_auto[i]+'</span>');

  for(var i = 0; i < tags_auto_del.length;i++)
  $("#tags_auto_del").append('<span class = "solo_tag">'+tags_auto_del[i]+'</span>');
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

  // function save_tags()
  // {
  //     var responce_str;
  //     for(var i = 0; i < tags_normal.length;i++)
  //       responce_str += tags_normal[i]+"|1,"; 

  //      for(var i = 0; i < tags_del.length;i++)
  //       responce_str += tags_del[i]+"|11,"; 
  //     console.log(responce_str);
  // }
       
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
                  <button id ="undel_button">undelete</button></div>
               </div>
               <div class = "combo_tags">
                  <div id = "norm_tags">                </div>
                  <div id = "tags_auto">                </div>
                  <div id = "del_tags">                </div>
                  <div id = "tags_auto_del">           </div>
               </div>
               
         </div>      
      </div>
   </div>
</body>
</html>
