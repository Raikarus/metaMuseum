<?php

  if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'load_tags':
                load_tags();
        	break;
           case 'load_auto_tags':
                load_auto_tags();
          break;
        }
    }
function load_tags()
{
	 $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
	 $query = "SELECT kword_name,status FROM kwords WHERE status = 1";
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

function load_auto_tags()
{
   $cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");
   $query = "SELECT kword_name,status FROM kwords WHERE status = 0";
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
 ?>