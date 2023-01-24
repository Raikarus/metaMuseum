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
<link rel="stylesheet" href="css/style2.css"  type="text/css">
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
                           <!--  <ul class = "list_of_groups">
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
         </div>
         <div class = "choosen_tags">
            <ul class = "wrap">
               
            </ul>
         </div>
      </div>
   </div>
</body>
</html>
