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

	echo '<div class = "comp_li_photo" name ="img" style="background-image:url('."'".'img/'.$str[0]."'".'" data-val = "'.$img.'""></div>' ;
	
}
?>