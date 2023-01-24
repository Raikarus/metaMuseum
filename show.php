<?php
	$query = "SELECT * FROM gallery";
	$res = pg_query($cn,$query);
	while($row=pg_fetch_object($res))
	{
		echo "<br>".$row->id." ".$row->name." ".$row->party." ".$row->meta;
	}
?>
