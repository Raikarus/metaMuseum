<?php 
if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'choosen_tags':
                check();
                break;
         
        }
    }


$status = 0;
function check()
{
	$status = !$status;
	
}
?>