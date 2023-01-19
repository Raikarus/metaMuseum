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
	echo $_POST['img_string'];
	
}
?>