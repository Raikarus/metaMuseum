<script>
var mod_2 = "podborka";
let selected_images = [];

 
$(document).ready(function(){

    function load_page()
    {
        var selected_images_string = "";
        for(var i = 0; i < selected_images.length;i++)
        {
           selected_images_string += selected_images[i] + '|';
        }

        var ajaxurl = 'ajax_pictags.php';
        if(mod_2 == "podborka")
        {
          data =  {'action': 'load_podborka','img_string':selected_images_string};
          $.post(ajaxurl, data).done(function (response) {
            $('#wrapping').html(response);
          });
        } 
        else
        {
          data =  {'action': 'load_download'};
          $.post(ajaxurl, data).done(function (response) {
            $('#wrapping').html(response);
          });
        }
    }

    $('.comp_li_button').click(function(){
        var clickBtnValue = $(this).data('val');
        if(clickBtnValue=='0')
        {
          $(this).css('background-color', '#24B47E');
          $(this).data('val','1');

          selected_images.push(String($(this).data('img')));
          count++;
        }
        else
        {
          $(this).css('background-color', 'rgba(255, 255, 255, 0)');
          $(this).data('val','0');

          selected_images.splice(selected_images.indexOf($(this).data('img')),1);
          count--;
        }
        load_page();
    });
    
    $('#mod_podborka').click(function(){
      mod_2 = "podborka";
      load_page();
    });
    $('#mod_download').click(function(){
      mod2_ = "download";
      load_page();
    });
});

</script>
<div class = "main">
<div class = "main_left">
  <!-- ТУТ ПОМЕНЯТЬ СТИЛИ (style1.css) -->
  <div id = "mod_swapper"style="display:flex;justify-content: center;align-items: center;width: 100%;height: 10%;">
    <button id = "mod_podborka" style = "width:50%;height: 100%">Подборка</button>
    <button id = "mod_download" style = "width:50%;height: 100%">Загруженное</button>
  </div>
  <!-- ТУТ ПОМЕНЯТЬ СТИЛИ -->  
  <ul class = "photos_compilation" id = "compilation">
     <?php
      $dir='./img';
  	$files = scandir($dir);
  	foreach($files as $n => $img){
  		if ($img != '.' && $img != '..') echo '  
           <li class = "compilation_li">
                     <button class = "comp_li_button" data-val= "0" name ="img" data-img = "'.$img.'">
           				   <div class = "comp_li_photo" style="background-image:url('."'".'img/'.$img."'".'"></div>
           				   <div class = "comp_li_name">'.$img.'</div>   
                     </button>        
        			 </li>';
  	}
     	?>               
  </ul>
</div>
<div class = "main_center">
  <ul class = "photos" id = "wrapping">
     	
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
         <div class = "tags" >


         </div>
         <div class = "choosen_tags">
            <ul class = "wrap">
            </ul>
            <?php 
                    $tags  = "japanese hentai lesbian milf korean asian step_mom massage anal ebony big_ass teen threesome public anime creampie ";
                    $tag = explode(" ", $tags);
                    
                  for($i = 0; $i < 16;$i++)
                  {
                     $size = rand(10, 40);
                      echo '<span class = "cloud_tag" style="font-size:'.$size.'px;">'.$tag[$i]."($size)".'</span>';
                      echo "\n";
                  }
              ?> 
         </div>
   </div>      
</div>
</div>