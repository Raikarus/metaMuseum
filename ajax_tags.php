<?php

if (isset($_POST['action'])) {
  switch ($_POST['action']) {
    case 'load_tags':
      load_tags();
      break;
   case 'load_auto_tags':
      load_auto_tags();
      break;
    case 'update_bd':
      update_bd();
      break;
  }
}

function load_tags()
{
 $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
 $query = "SELECT kword_name,status FROM kwords";
 $res = pg_query($cn,$query);
 $responce_str ="";
 while ($row = pg_fetch_object($res)) 
 {
  $kword_name = $row -> kword_name;
  $status = $row -> status;
  $responce_str .=$kword_name.'|'.$status.',';
 }
 $responce_str = substr($responce_str,0,-1);
 echo $responce_str;
}


function update_bd()
{
  $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
  $selected_left_up = explode("|",$_POST['selected_left_up']);
  $selected_left_bot = explode("|",$_POST['selected_left_up']);
  $selected_right_up = explode("|",$_POST['selected_right_up']});
  $selected_right_bot = explode("|",$_POST['selected_right_bot']);
  $mod = $_POST['mod'];
  switch ($mod) {
    case 'delete':
      for ($i=0; $i < $selected_left_up; $i++) { 
        $query = "UPDATE kwords SET status=11 WHERE kword_name='$selected_left_up[$i]'";
        $res = pg_query($cn,$query);
      }
      for ($i=0; $i < $selected_right_up; $i++) { 
        $query = "UPDATE kwords SET status=11 WHERE kword_name='$selected_right_up[$i]'";
        $res = pg_query($cn,$query);
      }
      break;
    
    default:
      echo "err";
      break;
  }
}

?>