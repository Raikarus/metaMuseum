<?php 
if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'set_img':
                check();
                break;
         
        }
    }


$status = 0;
function check()
{
    if($_POST['img_string'] != "download_mode")
    {
        $str = explode('|', $_POST['img_string']);
        //print_r($str);
        for($i = 0; $i < count($str)-1;$i++)
        {
            echo '<div class = "comp_li_photo" name ="img" style="  width:90%;height:90%; background-image:url('."'".'img/'.$str[$i]."'".'" data-val = "'.$img.'""></div>' ;
        }
	}
    else
    {
         echo '<img src="document.png" alt="s" width="150%" height="150%"> Загрузите ваше говно сюда' ;
    }
	
}
?>