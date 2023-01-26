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
  let tags_left_up = [];
  let tags_left_bot = [];
  let tags_right_up = [];
  let tags_right_bot = [];
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
          tags_left_bot.push(selected_left_up[i]);
          var index = tags_left_up.indexOf(selected_left_up[i]);
          if(index >= 0)
            tags_left_up.splice(index,1);
        }
        selected_left_up = [];

        for(var i = 0; i < selected_right_up.length;i++)
        {
          tags_right_up.push(selected_right_up[i]);
          var index = tags_right_up.indexOf(selected_right_up[i]);
          if(index>=0)
            tags_right_up.splice(index,1);
        }
        selected_right_up = [];
        update_tags();
    });

  //  $('#replace_button').click(function(){
  //   for(var i = 0; i < selected.length;i++)
  //     tags_right_up.push(selected[i]);
  //   selected = [];

  //   for(var i = 0; i < selected_auto.length;i++)
  //     tags_left_up.push(selected_auto[i]);
  //   selected_auto = [];

  //   update_tags();
  // });

  // $('#undel_button').click(function(){
  //   for(var i = 0; i < selected.length;i++)
  //     tags_left_up.push(selected[i]);       
  //   selected = [];

  //   for(var i = 0; i < selected_auto.length;i++)
  //     tags_right_up.push(selected_auto[i]);       
  //   selected_auto = [];

  //   update_tags();
  // });
  
  $('.combo_tags').on("click","div .solo_tag",function(){
    var tag_name = $(this).text();

    var index = tags_left_up.indexOf(tag_name);
    if(index >= 0)
    {
      selected_left_up.push(tags_left_up[index]);
      $(this).css('color','red');
    }
    var index = tags_right_bot.indexOf(tag_name);
    if(index >= 0)
    {
      selected_right_bot.push(tags_right_up[index]);
      $(this).css('color','red');
    }
    var index = tags_left_up.indexOf(tag_name);
    if(index >= 0)
    {
      selected_left_up.push(tags_left_bot[index]);
      $(this).css('color','red');
    }
    var index = tags_right_bot.indexOf(tag_name);
    if(index >= 0)
    {
      selected_right_bot.push(tags_right_up[index]);
      $(this).css('color','red');
    }
  });
 });
    

 
 function update_tags() {  
  $(".combo_tags div").html("");
  for(var i = 0; i < tags_left_up.length;i++)
    $("#tags_left_up").append('<span class = "solo_tag">'+tags_left_up[i]+'</span>');

  for(var i = 0; i < tags_left_bot.length;i++)
   $("#tags_left_bot").append('<span class = "solo_tag">'+tags_left_bot[i]+'</span>');

  for(var i = 0; i < tags_right_up.length;i++)
   $("#tags_right_up").append('<span class = "solo_tag">'+tags_right_up[i]+'</span>');

  for(var i = 0; i < tags_right_up.length;i++)
  $("#tags_right_bot").append('<span class = "solo_tag">'+tags_right_bot[i]+'</span>');
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
          tags_left_up.push((tags_with_status[i]).split('|')[0]);
        else if(tags_with_status[i].split('|')[1] == 11) 
          tags_left_bot.push((tags_with_status[i]).split('|')[0]);
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
          tags_right_up.push((tags_with_status[i]).split('|')[0]);

        else if(tags_with_status[i].split('|')[1] == 10) 
          tags_right_up.push((tags_with_status[i]).split('|')[0]);
      }
     update_tags(); 
  });

 }

  // function save_tags()
  // {
  //     var responce_str;
  //     for(var i = 0; i < tags_left_up.length;i++)
  //       responce_str += tags_left_up[i]+"|1,"; 

  //      for(var i = 0; i < tags_left_bot.length;i++)
  //       responce_str += tags_left_bot[i]+"|11,"; 
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
                  <div id = "tags_left_up">                </div>
                  <div id = "tags_right_up">                </div>
                  <div id = "tags_left_bot">           </div>
                  <div id = "tags_right_bot">                </div>
               </div>
               
         </div>      
      </div>
   </div>
</body>
</html>
