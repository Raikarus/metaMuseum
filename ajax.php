<?php 

if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'set_img':
                check();
                break;
            case 'update_tags':
                update_tags();
                break;

        }
    }


$status = 0;
function update_tags()
{
                        $tag = explode("|", $_POST['tags_string']);

                        for($i = 0; $i < count($tag);$i++)
                        {
                           $size = rand(10, 40);
                            echo ' <label name="tags_button" data-val = "1" data-str ="'.$tag[$i].'">
                                   <input type="checkbox" class="transparent_check_box" checked>
                                   <span class = "cloud_tag" style="font-size:'.$size.'px;">'.$tag[$i]."($size) ".'</span>
                                   </label>';
                        }
}

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
         echo '<img src="document.png" alt="s" width="150%" height="150%"><span class = "cloud_tag" style="font-size: 40 me;">Загрузите ваше говно сюда</span>'; ;
    }
	
}

?>