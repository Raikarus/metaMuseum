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

	echo "$str[0]";
	
}
?>