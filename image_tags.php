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
<title>Главная</title>
</head>
<body>

<header>
      <div class = "container">
         <div class = "logo_container">
            <a class = "logo" href = "/?form=home">
               DATABASE
            </a>
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
         <li class = "compilation_li">
            <div class="comp_li_photo" style = "background-image:url('https://klike.net/uploads/posts/2019-05/1556708032_1.jpg')">

            </div>
            <div class="comp_li_name">
               Название блаблаблаблаблабалабла
            </div>
         </li>         
      </ul>
   </div>
      <div class = "main_center">
         <ul class = "photos" id = "wrapping">
         	<?php
			    $dir='./img';
				$files = scandir($dir);
				foreach($files as $n => $img){
					if ($img != '.' && $img != '..') echo '<li class = "photo_li" >
               				<div class = "photo" style="background-image:url('."'".'img/'.$img."'".'"></div>
               				<div class = "name">'.$img.'</div>           
            			 </li>';
				}
         	?>
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
               <div class = "tags">
               </div>
               <div class = "choosen_tags">
                  <ul class = "wrap">
                  </ul>
               </div>
         </div>      
      </div>
   </div>


                        <?php 
                        /*
                          $tags  = "japanese hentai lesbian milf korean asian step_mom massage anal ebony big_ass teen threesome public anime creampie ";
                          $tag = explode(" ", $tags);
                          
                        for($i = 0; $i < 16;$i++)
                        {
                           $size = rand(14, 40);
                            echo '<span style="color:#24B47E;text-align:center;font-size:'.$size.'pt;word-break:normal;">'.$tag[$i]."($size)".'</span>';
                            echo "\n";
                        }
                        */
                        ?> 


</body>
</html>
