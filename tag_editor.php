<?php

?>
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
      var index = tags_right_bot.indexOf(selected_right_bot[i]);
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

      $(this).css('color','rgb(228, 79, 79)');
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

  $('.submit').click(function(){
    var ajaxurl = 'ajax_tags.php';
    var kword_name = $('#search_str').val();
    data = {'action':'add_kword','kword_name':kword_name}
    $.post(ajaxurl,data).done(function(responce){
      if(responce!="ok") alert(responce)
    });
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
        $(this).css('color','rgb(228, 79, 79)');
      if(selected_right_bot.indexOf($(this).text())!=-1)
        $(this).css('color','rgb(228, 79, 79)');
      if(selected_left_up.indexOf($(this).text())!=-1)
        $(this).css('color','rgb(228, 79, 79)');
      if(selected_left_bot.indexOf($(this).text())!=-1)
        $(this).css('color','rgb(228, 79, 79)');
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

<div class = "main_tag">
  <div class = "main_right_version">
     <div class = "high_main">
           <div class = "searching">
              <form class = "searching_form">
                 <input type = "text"   id="search_str" class = "search" placeholder="Add kwords!">
                 <input type = "submit" id="add" class = "submit" value="Add">
              </form>
           </div>
           <div class = "tags_group" >
            <div class = "edit_big"> </div>
            <div class = "edit_div">
              <button id ="del_button" class = "edit_but"> delete</button>
              <button id ="replace_button" class = "edit_but">replace</button>
              <button id ="undel_button" class = "edit_but">undelete</button></div>
           </div>
           <div class = "combo_tags">
              <div id = "tags_left_up" class = "tags_wrap">                  </div>
              <div id = "tags_right_up" class = "tags_wrap">                 </div>
              <div id = "tags_left_bot" class = "tags_wrap">                 </div>
              <div id = "tags_right_bot" class = "tags_wrap">                </div>
           </div>
           
     </div>      
  </div>
 </div>
