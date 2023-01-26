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
  
    $('#del_button').click(function(){
      update_bd('delete');
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
        tags_right_bot.push(selected_right_up[i]);
        var index = tags_right_up.indexOf(selected_right_up[i]);
        if(index>=0)
          tags_right_up.splice(index,1);
      }
      selected_right_up = [];
      update_tags();
    });

   $('#replace_button').click(function(){
    update_bd('replace');
    for(var i = 0; i < selected_left_up.length;i++)
    {
      tags_right_up.push(selected_left_up[i]);
      var index = tags_left_up.indexOf(selected_left_up[i]);
      if(index >= 0)
        tags_left_up.splice(index,1);
    }
    selected_left_up = [];

    for(var i = 0; i < selected_right_up.length;i++)
    {
      tags_left_up.push(selected_right_up[i]);
      var index = tags_right_up.indexOf(selected_right_up[i]);
      if(index >= 0)
        tags_right_up.splice(index,1);
    }
    selected_right_up = [];

    update_tags();
  });

  $('#undel_button').click(function(){
    update_bd('undelete');
    for(var i = 0; i < selected_left_bot.length;i++)
    {
      tags_left_up.push(selected_left_bot[i]);
      var index = tags_left_bot.indexOf(selected_left_bot[i]);
      if(index >= 0)
        tags_left_bot.splice(index,1);
    }
    selected_left_bot = [];

    for(var i = 0; i < selected_right_bot.length;i++)
    {
      tags_right_up.push(selected_right_bot[i]);
      var index = tags_right_bot.indexOf(selected_left_bot);
      if(index >= 0)
        tags_right_bot.splice(index,1);
    }
    selected_right_bot = [];

    update_tags();
  });
  
  $('.combo_tags').on("click","div .solo_tag",function(){
    var tag_name = $(this).text();
    var index_left_bot = selected_left_bot.indexOf(tag_name);
    var index_left_up = selected_left_up.indexOf(tag_name);
    var index_right_bot = selected_right_bot.indexOf(tag_name);
    var index_right_up = selected_right_up.indexOf(tag_name);
    if(index_left_up==-1 && index_right_up==-1 && index_left_bot==-1 && index_right_bot==-1)
    {
      var index = tags_left_up.indexOf(tag_name);
      if(index >= 0)
        selected_left_up.push(tags_left_up[index]);

      var index = tags_right_up.indexOf(tag_name);
      if(index >= 0)
        selected_right_up.push(tags_right_up[index]);

      var index = tags_left_bot.indexOf(tag_name);
      if(index >= 0)
        selected_left_bot.push(tags_left_bot[index]);

      var index = tags_right_bot.indexOf(tag_name);
      if(index >= 0)
        selected_right_bot.push(tags_right_bot[index]);

      $(this).css('color','red');
    }
    else
    {
      if(index_right_up!=-1)
        selected_right_up.splice(index_right_up,1);
      if(index_right_bot!=-1)
        selected_right_bot.splice(index_right_bot,1);
      if(index_left_bot!=-1)
        selected_left_bot.splice(index_left_bot,1);
      if(index_left_up!=-1)
        selected_left_up.splice(index_left_up,1);
      $(this).css('color','white');
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

  for(var i = 0; i < tags_right_bot.length;i++)
  $("#tags_right_bot").append('<span class = "solo_tag">'+tags_right_bot[i]+'</span>');

  check_selections();
 }

 function load_tags() {
  var ajaxurl = 'ajax_tags.php';
  data = {'action':'load_tags'};
  $.post(ajaxurl,data).done(function(responce){ 

      tags_with_status = responce.split(',');

      for(var i = 0; i < tags_with_status.length;i++)
      {
        if(tags_with_status[i].split('|')[1] == 1) 
          tags_left_up.push((tags_with_status[i]).split('|')[0]);
        else if(tags_with_status[i].split('|')[1] == 11) 
          tags_left_bot.push((tags_with_status[i]).split('|')[0]);
        if(tags_with_status[i].split('|')[1] == 0) 
          tags_right_up.push((tags_with_status[i]).split('|')[0]);
        else if(tags_with_status[i].split('|')[1] == 10) 
          tags_right_bot.push((tags_with_status[i]).split('|')[0]);
      }
     update_tags(); 
  });
 }

 function check_selections(){
    $('.solo_tag').each(function(){
      if(selected_right_up.indexOf($(this).text())!=-1)
        $(this).css('color','red');
      if(selected_right_bot.indexOf($(this).text())!=-1)
        $(this).css('color','red');
      if(selected_left_up.indexOf($(this).text())!=-1)
        $(this).css('color','red');
      if(selected_left_bot.indexOf($(this).text())!=-1)
        $(this).css('color','red');
    });
 }

  function update_bd(mod)
  {
    console.log(mod);
    var ajaxurl = "ajax_tags.php";
    var selected_right_bot_string = "";
    var selected_right_up_string = "";
    var selected_left_up_string = "";
    var selected_left_bot_string = "";
    for (var i = 0; i < selected_left_up.length; i++)
      selected_left_up_string += selected_left_up[i]+"|";
    for (var i = 0; i < selected_left_bot.length; i++)
      selected_left_bot_string += selected_left_bot[i]+"|";
    for (var i = 0; i < selected_right_up.length; i++)
      selected_right_up_string += selected_right_up[i]+"|";
    for (var i = 0; i < selected_right_bot.length; i++)
      selected_right_bot_string += selected_right_bot[i]+"|";
    data = {'action':'update_bd','selected_left_up':selected_left_up_string,'selected_left_bot':selected_left_bot_string,'selected_right_up':selected_right_up_string,'selected_right_bot':selected_right_bot_string,'mod':mod};  
    $.post(ajaxurl,data).done(function(responce){
      console.log(responce);
    });
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
