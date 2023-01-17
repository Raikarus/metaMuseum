<?php
$cn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=schef2002");

else if($_POST['pass']=="schef2003"){
        echo "П4р0ль пр0йд3н <br>";

        $shl = 'exiftool -TagsFromFile img/'.$_POST['img_name'].' img/file.xmp';
        $res = shell_exec($shl);
        echo "<pre>$res</pre>";

        $shl = 'exiftool -XMP=img/'.$_POST['img_name'];
        $res = shell_exec($shl);
        echo "<br><pre>$res</pre>";

        $shl = 'exiftool -TagsFromFile img/file.xmp img/'.$_POST['img_name'];
        $res = shell_exec($shl);
        echo "<br><pre>$res</pre>";


        $query="SELECT pic_id FROM pics WHERE title='".$_POST['img_name']."'";
        $res = pg_query($cn,$query);
        while ($row=pg_fetch_object($res)) {
          $pic_id = $row->pic_id; 
          echo $pic_id."<br>";
        }      
        

        foreach($_POST['kwords'] as $selected_kword)
        {
	       	$shl = 'exiftool -XMP-dc:subject+="'.$selected_kword.'" img/'.$_POST['img_name'];
    	    $res = shell_exec($shl);
        	echo "<br><pre>$res</pre>";	
          $query="SELECT tag_id,tag_id_num FROM kwords WHERE kword_name='".$selected_kword."'";
          $res = pg_query($cn,$query);
          while ($row=pg_fetch_object($res)) {
            $tag_id = $row->tag_id;
            $tag_id_num = $row->tag_id_num;
          }
          
          $query="INSERT INTO pictags(pic_id,tag_id,tag_id_num) VALUES (".$pic_id.",".$tag_id.",".$tag_id_num.")";
          $res = pg_query($cn,$query);

          echo $query."<br>";
        }

        $shl = 'exiftool -XMP-dc:ALL img/'.$_POST['img_name']." -b";
        $res = shell_exec($shl);
        echo "<br><pre>$res</pre>";

        $shl = 'rm img/file.xmp';
        $res = shell_exec($shl);
        
}
else
{
	echo "П4р0ль не пр0йд3н <br>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>
		SCHEF
	</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

	<script>

	$(document).ready(function(){
    	$('.button').click(function(){
	        var clickBtnValue = $(this).val();
	        var img_name = "img/"+$('#img_name').val();
	        var ajaxurl = 'ajax.php',
	        data =  {'action': clickBtnValue, 'img_name': img_name};
	        $.post(ajaxurl, data, function (response) {
				  $('#output').html(response);
	        });
    	});
	});

	</script>
</head>
<body>
<a href="index.php">Дом</a>
<a href="tags.php">Тэги</a>
<form method="post" enctype="multipart/form-data">
	<input type="password" placeholder="пароль" name="pass">
	<input id="img" name="imgfile" type="file">
	<input class="button" name="Download" value="Download" type="submit">
</form>
<br>
<input type="text" id="img_name" placeholder="Название изображения" />
<input type="submit" class="button" name="read" value="read" />
<input type="submit" class="button" name="list" value="list" />
<input type="submit" class="button" name="pics" value="pics" />
<input type="submit" class="button" name="pictags" value="pictags" />
<input type="submit" class="button" name="REMOVE" value="REMOVE" />
<div id = "output">
</div>
<br>
<form method="post">
	<input type="text" name="img_name" placeholder="Название изображения">
	<select multiple name="kwords[]">
	<?php
		$query = "SELECT kword_name FROM kwords";
		$res = pg_query($cn,$query);
		while($row=pg_fetch_object($res))
		{
			echo "<option>".$row->kword_name."</option>";
		}
	?>
	<input type="password" placeholder="пароль" name="pass">
	<input class="button" name="AddKeyword" value="AddKeyword" type="submit">
</form>
</body>
</html>
