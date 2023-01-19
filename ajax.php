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
        echo '<li class = "compilation_li">
                           <button class = "comp_li_button" data-val= "0" name ="img">
                               <div class = "comp_li_photo" style="background-image:url('."'".'img/'.$str[$i]."'".'"></div>
                               <div class = "comp_li_name">'.$str[$i].'</div>   
                           </button>        
                         </li>';' ;
    }
	
	
}
?>