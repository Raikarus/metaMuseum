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
   
      <div class = "main_right">
         <div class = "all_tags">
               <div class = "searching">
                  <form class = "searching_form">
                     <input type = "text" name = "search" class = "search" placeholder="Search tags!">
                     <input type = "submit" name = "submit" class = "submit" value="ADD">
                  </form>
               </div>
               <div class = "tags" >
                <form action="select1.php" method="post">
                 <p><select size="3" multiple name="hero[]">
                  <option disabled>Выберите героя</option>
                  <option value="Чебурашка">Чебурашка</option>
                  <option selected value="Крокодил Гена">Крокодил Гена</option>
                  <option value="Шапокляк">Шапокляк</option>
                  <option value="Крыса Лариса">Крыса Лариса</option>
                 </select></p>
                 <p><input type="submit" value="Отправить"></p>
                </form>
                        
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
