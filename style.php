<?php
   session_start();
	$form = $_GET['form'];
   $load_page = "";
   switch ($form) {
      case 'home':
         $load_page = "home.php";
         break;
      case 'pictags':
         $load_page = "image_tags.php";
         break;
      case 'exit':
         session_destroy();
         header('location:/');
         break;
      default:
         $load_page = "home.php";
         break;
   }
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html">
<link rel="stylesheet" type="text/css" href="css/style_header.css">
<?php

switch ($load_page) {
   case 'home.php':
      echo '<link rel="stylesheet" href="css/style_home_image_tags.css"  type="text/css">';
      echo '<link rel="stylesheet" href="css/style_home.css"  type="text/css">';
      break;
   
   case 'image_tags.php':
      echo '<link rel="stylesheet" href="css/style_home_image_tags.css"  type="text/css">';
      echo '<link rel="stylesheet" href="css/style_image_tags.css"  type="text/css">';
      break;
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script type="text/javascript" src = "js/script.js"></script>
<title>Главная</title>

</head>
<body>
   <header>
   <div class = "container">
      <div class = "logo_container">
         <a class = "logo" href = "?form=home">
            DATABASE
         </a>
      </div>
      <!-- ТУТ ПОМЕНЯТЬ СТИЛИ -->
      <div>
         <a id = "set_tag" href="?form=pictags" class = "maketag">
            ПРИСВОИТЬ ТЭГ
         </a>
      </div>
      <!-- ТУТ ПОМЕНЯТЬ СТИЛИ -->
      <ul class = username_exit>
         <li class = "usit_elem exit"><a class = "exit" href = "/?form=exit">Exit</a></li>
      </ul>
   </div>
</header>

   <?php 
    $_SESSION['form'] = $load_page;
    include $load_page;
   ?>
</body>
</html>
