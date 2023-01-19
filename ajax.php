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
    $str = explode('|', $_POST['img_string']);
    //print_r($str);
    for($i = 0; $i < count($str)-1;$i++)
    {
        echo '<div class = "comp_li_photo" name ="img" style="background-image:url('."'".'img/'.$str[$i]."'".'" data-val = "'.$img.'""></div>' ;
    }
	
	
}
?>