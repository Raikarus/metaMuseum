<?php


$dir = '/img/';

$f = scandir($_SERVER['DOCUMENT_ROOT'].$dir);


echo '<div id = "picgrid">';

foreach ($f as $file) {
	if(preg_match('/\.(jpg)/', $file) | preg_match('/\.(png)/', $file))
	{
		echo '<div class = "pic"><div><button atrib = "'.$dir.$file.'">У</button><img src = "'.$dir.$file.'" /></div>'.$file.'</div>';
	}
}
?>
</div>
<script type="text/javascript">
	$(".pic div button").click(function(){
	var variableToSend = $(this).attr("atrib").replace('/',"\\").replace('/',"\\");
	$.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: {
            variable: variableToSend
        },
        dataType: 'html',
        success: function(data) {
            $('body').html(data); 
        }
    });

});

</script>
<?php
?>
