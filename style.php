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
<?php

switch ($load_page) {
   case 'home.php':
      echo '<link rel="stylesheet" href="css/style.css"  type="text/css">';
      break;
   
   default:
      echo '<link rel="stylesheet" href="css/style1.css"  type="text/css">';
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
         <a id = "set_tag" href="?form=pictags">
            ПРИСВОИТЬ ТЭГ
         </a>
      </div>
      <!-- ТУТ ПОМЕНЯТЬ СТИЛИ -->
      <ul class = username_exit>
         <li class = "usit_elem username">Username</li>
         <li class = "usit_elem exit"><a class = "exit" href = "/?form=exit">Exit</a></li>
      </ul>
   </div>
</header>

   <?php 
    include $load_page;
   ?>
</body>
</html>
