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
       let tags = [(document.getElementsByName("tags_button")).length];
       let check_tags = [(document.getElementsByName("transparent_check_box")).length];
 $(document).ready(function(){
        $('.normal_tags').on("click",".transparent_check_box",function(){
          
            var clickBtnValue = $(this).is(":checked");
            
           

            for(var i = 0; i < (document.getElementsByName("tags_button")).length;i++)
            {
            tags.push(document.getElementsByName("tags_button")[i]);
            check_tags.push(document.getElementsByName("transparent_check_box")[i]);
            }
           
            if(clickBtnValue=='0')
            {
             // $(this).data('val',1);
              
            
              
              console.log($(this).data('str'));

              $(this).data('val',0);
            //  console.log(tags[0]);
            //  console.log(check_tags[0]);
           //   console.log(document.getElementsByName("transparent_check_box").length); 
             // console.log(tags[tags.indexOf($(this))]);


             update_tags();


                
            }
            else
            {
              console.log($(this).data('str'));  //зайдет когда чекбокс был пуст
            }
          });
        });
          

       
       function update_tags()
       {

               for(var i = 0; i < (document.getElementsByName("tags_button")).length;i++)
                {
                  if($(tags[i]).data('val') == 1 )
                  {
                    try
                    {
                       tags[i].innerHTML = ' <label name="tags_button" data-val = "1" data-str = sss><input type="checkbox" name = "transparent_check_box" class="transparent_check_box" data-str = '+$(tags[i]).data('str')+' checked><span class = "cloud_tag" style="font-size:30 px;">'+$(tags[i]).data('str')+'</span></label>';
                    }
                    catch
                    {

                    }
                  
                  }
                  else
                  {
                    try
                    {
                       tags[i].innerHTML = ' <label name="tags_button" data-val = "0"><input type="checkbox" name = "transparent_check_box" class="transparent_check_box" data-str = '+$(tags[i]).data('str')+' ><span class = "cloud_tag" style="font-size:30 px;color: #CD5C5C;">'+$(tags[i]).data('str')+'</span></label>';
                    }
                    catch
                    {

                    }
                   
                  }

                }
                while(tags.length > 0) 
                {
                 tags.pop();
                 check_tags.pop();
                }
            for(var i = 0; i < (document.getElementsByName("tags_button")).length;i++)
            {
            tags.push(document.getElementsByName("tags_button")[i]);
             check_tags.push(document.getElementsByName("transparent_check_box")[i]);
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

<div class = "main">
   
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
                <div class="normal_tags" id = "norm_tags">
                  <ul class = "wrap">
                  </ul>
                  <?php 
                          $tags  = "step_mom massage anal ebony big_ ass teen threesome public anime creampie";
                          $tag = explode(" ", $tags);
                          
                        for($i = 0; $i < count($tag);$i++)
                        {
                           $size = rand(10, 40);
                            echo ' <label name="tags_button" data-val = "1" data-str ="'.$tag[$i].'">
                                   <input type="checkbox" name = "transparent_check_box" class="transparent_check_box" checked>
                                   <span class = "cloud_tag" style="font-size:'.$size.'px;">'.$tag[$i]."($size) ".'</span>
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
                           $size = rand(10, 40);
                            echo ' <label name="tags_button" data-val = "0" data-str ="'.$tag[$i].'">
                                   <input type="checkbox" name = "transparent_check_box" class="transparent_check_box">
                                   <span class = "cloud_tag" style="font-size:'.$size.'px;color: #CD5C5C;">'.$tag[$i]."($size) ".'</span>
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
