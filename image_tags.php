<?php
  //$_SESSION['podborka'] = "AAAAA";

  //СДЕЛАТЬ $_SESSION['form'], чтобы знать на какой странице сейчас
?>

<script>
var mod_2 = "podborka";
var switcher = $('#mod_switch');
let selected_images = [];
let selected_images_id = [];

$(document).ready(function(){
    
    function get_podborka_value()
    {
      var ajaxurl = 'ajax_pictags.php';
      data = {'action': 'get_podborka_value'};

      $.post(ajaxurl,data).done(function(response){
        // alert(response);
        podborka = response;
        pre_load();
      });
    }

    function pre_load()
    {
      var ajaxurl = 'ajax_pictags.php';
      data = {'action': 'pre_load', 'podborka':podborka};
      $.post(ajaxurl,data).done(function(response){
        $('.photos_compilation').html(response);
      });
    }
    get_podborka_value();

    function load_page()
    {
      var selected_images_string = "";
      var selected_images_id_string = "";
      for(var i = 0; i < selected_images.length;i++)
      {
         selected_images_string += selected_images[i] + '|';
         selected_images_id_string += selected_images_id[i]+"|";
      }

      var ajaxurl = 'ajax_pictags.php';
      if(switcher.checked)
      {
        data =  {'action': 'load_podborka','img_string':selected_images_string};
        $.post(ajaxurl, data).done(function(response) {
          $('#wrapping').html(response);
          data =  {'action': 'load_cross_kwords','img_string':selected_images_id_string};
          $.post(ajaxurl,data).done(function(response){
            $('.wrap').html(response);
          });
        });
      } 
      else
      {
        data =  {'action': 'load_download'};
        $.post(ajaxurl, data).done(function(response) {
          $('#wrapping').html(response);
        });
      }
    }

    $('#compilation').on("click",".compilation_li .comp_li_button",function(){
      var clickBtnValue = $(this).data('val');
      if(clickBtnValue=='0')
      {
        $(this).css('background-color', '#24B47E');
        $(this).data('val','1');

        selected_images.push(String($(this).data('img')));
        selected_images_id.push(String($(this).data('id')));
      }
      else
      {
        $(this).css('background-color', 'rgba(255, 255, 255, 0)');
        $(this).data('val','0');

        selected_images.splice(selected_images.indexOf($(this).data('img')),1);
        selected_images_id.splice(selected_images.indexOf($(this).data('img')),1);
      }
      load_page();
    });
    
    $('#mod_swapper').change(function(){
      if (switcher.checked)
      {
         switcher.checked = true;
         check_selection();
         pre_load();
         load_page();
      }
      else
      {     
         switcher.checked = false;
         $('.photos_compilation').html("");
         load_page();
      }    
    });


    function check_selection()
    {
      for (var i = 0; i < selected_images.length; i++) {
        $('.comp_li_button[data-img="'+selected_images[i]+'"]').css('background-color', '#24B47E');
        $('.comp_li_button[data-img="'+selected_images[i]+'"]').data("val") = 1;
      }
    }

    function show_kwords()
    {
      var ajaxurl = 'ajax.php';
      data =  {'action': 'show_kwords'}; 
      $.post(ajaxurl, data).done(function (response) {
        $(".list_of_groups").html(response);
        build_poisk();
      });
    }
    show_kwords();
});

</script>
<div class = "main">
  <div class = "main_left">
    <!-- ТУТ ПОМЕНЯТЬ СТИЛИ (style1.css) -->
    <div class="switcher_block">
      <span class = "current_mod">Режим</span>
      <label id = "mod_swapper">
         <input type = "checkbox" id = "mod_switch" checked>
         <span class = "slider"></span>
      </label>
    </div>
    <!-- ТУТ ПОМЕНЯТЬ СТИЛИ -->  
    <ul class = "photos_compilation" id = "compilation">
              
    </ul>
  </div>
  <div class = "main_center">
    <ul class = "photos" id = "wrapping">
       	
    </ul>
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