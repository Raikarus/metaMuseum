<?php

  if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'load_tags':
                load_tags();
        	break;
        }
    }
load_tags()
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
     echo $responce_str;

}

 ?>