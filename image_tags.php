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
<link rel="stylesheet" href="css/style1.css"  type="text/css">
<script type="text/javascript" src = "js/jq.js"></script>
<script type="text/javascript" src = "js/script.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <script>
      var count = 0;
      var status = 0;
      let arr = [(document.getElementsByName("img")).length];
function moveZeros(arr) {
    let upperBound = arr.length;
    for (let i = 0; i < upperBound; i++) {
        if (arr[i] === 0) {
            arr.push(0);
            arr.splice(i, 1);
            upperBound--;
            i--;
        }
    }
    return arr;
}
 
    $(document).ready(function(){
        $('.comp_li_button').click(function(){
            var clickBtnValue = $(this).data('val');
            
           
            if(clickBtnValue=='0')
            {
             // $(this).css('outline','5px solid #24B47E');
               $(this).css('background-color', '#24B47E');
              $(this).data('val','1');
          
               arr[count] =  String($(this).data('img'));
              
              if(count < document.getElementsByName("img").length)
              {
               count++;
              }

            }
            else
            {
              //$(this).css('outline','none');
               $(this).css('background-color', 'rgba(255, 255, 255, 0)');
              $(this).data('val','0');

              for(var i =0;i <count;i++ )
              {
               if(arr[i] == $(this).data('img'))
               {
                   arr[i] = 0;
                   moveZeros(arr);
                   break;
               }
              }
             
              count--;
            }
            
          
            var ss = "";

            for(var i = 0; i < count;i++)
            {
               ss += arr[i] + '|';
                 
            }
             console.log(ss);

            var ajaxurl = 'ajax.php';

            if(status == 0)
            {
               
                data =  {'action': 'set_img','img_string':ss};
               $.post(ajaxurl, data).done(function (response) {
                  $('#wrapping').html(response);
            });
            } 
            else
            {
                 data =  {'action': 'set_img','img_string':"download_mode"};
               $.post(ajaxurl, data).done(function (response) {
                  $('#wrapping').html(response); });
            }
            
         
        });

         $('.switch').click(function(){

            console.log(status); 
              status++;
              if(status == 1) //download mode
              {
               for(var i =0; i < document.getElementsByName("img").length;i++)
               {
                     $(document.getElementsByName("img")[i]).css('display','none');  // надо сделать норм удаление 
               }
                  var ajaxurl = 'ajax.php';
                  data =  {'action': 'set_img','img_string':"download_mode"};
                  $.post(ajaxurl, data).done(function (response) {
                  $('#wrapping').html(response); });
              }
              else //default mode
              {
                 for(var i =0; i < document.getElementsByName("img").length;i++)
               {
                     $(document.getElementsByName("img")[i]).css('display','flex');  // надо сделать норм удаление 
               }
                var ss = "";

               for(var i = 0; i < count;i++)
               {
                  ss += arr[i] + '|';
                    
               }
               var ajaxurl = 'ajax.php';
                  data =  {'action': 'set_img','img_string':ss};
                  $.post(ajaxurl, data).done(function (response) {
                  $('#wrapping').html(response); });
               status = 0;
              }
              
         });
    });

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

<div class = "main">
   <div class = "main_left">
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
               <?php 
                          
                          $query = "SELECT DISTINCT party FROM gallery";
                          $res = pg_query($cn,$query);
                       
                          while($row=pg_fetch_row($res))
                          {
                              $x = rand(5, 15);
                             echo '<li class = "tag_group">                     
                                         <p class = "group_name">
                                   
                                               <a href = "javascript:flipflop('."'".$row[0]."'".');" style="font-size:'.$x.'px">'.$row[0].'+</a>
                          
                                         </p>
                                         <ul class = "tag_list" id = '.$row[0].' style="display: none;">';
                             $query = "SELECT name FROM gallery WHERE party='".$row[0]."'";
                             $res2 = pg_query($cn,$query);
                             while($row2=pg_fetch_row($res2))
                             {
                                echo '<li class = "list_item"><a href = "#" data-en = 0 data-tag = '.$row2[0].'>'.$row2[0].'</a></li>';
                             }
                             echo "</ul></li>";
                          }
                       ?>
                       </ul>

                          ?>
                          <!--	<ul class = "list_of_groups">
                             <?php
                          $query = "SELECT DISTINCT party FROM gallery";
                          $res = pg_query($cn,$query);
                          while($row=pg_fetch_row($res))
                          {
                             echo '<li class = "tag_group">                     
                                         <p class = "group_name">
                                     
                                               <a href = "javascript:flipflop('."'".$row[0]."'".');">'.$row[0].'+</a>
                          

                                         </p>
                                         <ul class = "tag_list" id = '.$row[0].' style="display: none;">';
                             $query = "SELECT name FROM gallery WHERE party='".$row[0]."'";
                             $res2 = pg_query($cn,$query);
                             while($row2=pg_fetch_row($res2))
                             {
                                echo '<li class = "list_item"><a href = "#" data-en = 0 data-tag = '.$row2[0].'>'.$row2[0].'</a></li>';
                             }
                             echo "</ul></li>";
                          }
                       ?>
                       </ul> --> 
                        
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
</body>
</html>
