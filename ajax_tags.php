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
    case 'add_kword':
      add_kword();
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
  $selected_left_bot = explode("|",$_POST['selected_left_bot']);
  $selected_right_up = explode("|",$_POST['selected_right_up']);
  $selected_right_bot = explode("|",$_POST['selected_right_bot']);
  $mod = $_POST['mod'];
  echo $mod;
  switch ($mod) {
    case 'delete':
      for ($i=0; $i < count($selected_left_up)-1; $i++) { 
        $query = "UPDATE kwords SET status=11 WHERE kword_name='$selected_left_up[$i]'";
        echo "ЗАПРОСИК $query";
        $res = pg_query($cn,$query);
      }
      for ($i=0; $i < count($selected_right_up)-1; $i++) { 
        $query = "UPDATE kwords SET status=10 WHERE kword_name='$selected_right_up[$i]'";
        echo "ЗАПРОСИК $query";
        $res = pg_query($cn,$query);
      }
      break;
    case 'undelete':
      for ($i=0; $i < count($selected_left_bot)-1; $i++) { 
        $query = "UPDATE kwords SET status=1 WHERE kword_name='$selected_left_bot[$i]'";
        echo "ЗАПРОСИК $query";
        $res = pg_query($cn,$query);
      }
      for ($i=0; $i < count($selected_right_bot)-1; $i++) { 
        $query = "UPDATE kwords SET status=0 WHERE kword_name='$selected_right_bot[$i]'";
        echo "ЗАПРОСИК $query";
        $res = pg_query($cn,$query);
      }
      break;
    case 'replace':
      for ($i=0; $i < count($selected_left_up)-1; $i++) { 
        $query = "UPDATE kwords SET status=0 WHERE kword_name='$selected_left_up[$i]'";
        echo "ЗАПРОСИК $query";
        $res = pg_query($cn,$query);
      }
      for ($i=0; $i < count($selected_right_up)-1; $i++) { 
        $query = "UPDATE kwords SET status=1 WHERE kword_name='$selected_right_up[$i]'";
        echo "ЗАПРОСИК $query";
        $res = pg_query($cn,$query);
      }
      break;
    default:
      echo "err";
      break;
  }
}

function add_kword()
{
  $kword_name = $_POST['kword_name'];
  $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
  $query = "SELECT tag_id_num FROM kwords WHERE tag_id=10 AND kword_name='$kword_name'";
  $res = pg_query($cn,$query);
  $row = pg_fetch_object($res);
  if(!$row->tag_id_num)
  {
    $query = "INSERT INTO kwords(tag_id,kword_name,status) VALUES(10,'$kword_name',1)";
    $res = pg_query($cn,$query);

    $query = "SELECT tag_id_num FROM kwords WHERE tag_id=10 AND kword_name='$kword_name'";
    $res = pg_query($cn,$query);
    $row = pg_fetch_object($res);
    $tag_id_num = $row->tag_id_num;
    $query = "INSERT INTO kwgkw(gkword_id,tag_id,tag_id_num) VALUES(0,10,$tag_id_num)";
    $res = pg_query($cn,$query);
    echo "ok";
  }
  else
  {
    echo "Тэг $kword_name уже существует <br>";
  }
}

?>