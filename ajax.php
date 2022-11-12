<?php
	echo "<img src=".$_POST['variable'].">";
	unlink($_POST['variable']);
	exit();
?>
