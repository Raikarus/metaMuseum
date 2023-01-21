<?php 
if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'load_podborka':
                load_podborka();
                break;
            case 'load_download':
                load_download();
                break;
        }
    }



function load_podborka()
{
    $img_string = explode('|', $_POST['img_string']);
    //print_r($str);
    for($i = 0; $i < count($str)-1;$i++)
    {
        echo '<div class = "comp_li_photo" name ="img" style="  width:90%;height:90%; background-image:url('."'".'img/'.$img_string[$i]."')".'></div>' ;
    }
}

function load_download()
{
    echo '<img src="document.png" alt="s" width="150%" height="150%"><span class = "cloud_tag" style="font-size: 40 me;">Загрузка</span>';
}
?>