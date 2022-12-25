<?php
	set_include_path("/var/www/html/pel/src");
	require_once "/var/www/html/pel/src/PelJpeg.php";
	require_once "/var/www/html/pel/src/Pel.php";
	require_once "/var/www/html/pel/src/PelDataWindow.php";
	require_once "/var/www/html/pel/src/PelConvert.php";
	require_once "/var/www/html/pel/src/PelJpegMarker.php";
	require_once "/var/www/html/pel/src/PelJpegContent.php";
	require_once "/var/www/html/pel/src/PelExif.php";
	require_once "/var/www/html/pel/src/PelIfd.php";
	require_once "/var/www/html/pel/src/PelTiff.php";
	require_once "/var/www/html/pel/src/PelTag.php";
	require_once "/var/www/html/pel/src/PelFormat.php";
	require_once "/var/www/html/pel/src/PelEntry.php";
	require_once "/var/www/html/pel/src/PelEntryAscii.php";
	require_once "/var/www/html/pel/src/PelEntryNumber.php";
	require_once "/var/www/html/pel/src/PelEntryShort.php";
	require_once "/var/www/html/pel/src/PelEntrySLong.php";
	require_once "/var/www/html/pel/src/PelEntrySRational.php";
	require_once "/var/www/html/pel/src/PelEntryLong.php";
	require_once "/var/www/html/pel/src/PelEntryRational.php";
	require_once "/var/www/html/pel/src/PelEntryTime.php";
	require_once "/var/www/html/pel/src/PelEntryWindowsString.php";
	require_once "/var/www/html/pel/src/PelException.php";
	require_once "/var/www/html/pel/src/PelInvalidDataException.php";
	require_once "/var/www/html/pel/src/PelEntryVersion.php";
	require_once "/var/www/html/pel/src/PelEntryUndefined.php";
	use lsolesen\pel\Pel;
	use lsolesen\pel\PelConvert;
	use lsolesen\pel\PelDataWindow;
	use lsolesen\pel\PelEntryAscii;
	use lsolesen\pel\PelExif;
	use lsolesen\pel\PelIfd;
	use lsolesen\pel\PelTiff;
	use lsolesen\pel\PelJpeg;
	use lsolesen\pel\PelTag;

	echo "Добавление метаинформации<br>";

	if($_POST['passw']=='schef2002'){
		echo "Пароль пр0йд3н<br>";
		$pelJpeg = new PelJpeg("img/".$_POST['picName2']);
		$pelExif = $pelJpeg->getExif();
		if($pelExif == null){
			$pelExif = new PelExif();
			$pelJpeg->setExif($pelExif);
		}
		$pelTiff = $pelExif->getTiff();
		if ($pelTiff == null) {
		    $pelTiff = new PelTiff();
		    $pelExif->setTiff($pelTiff);
		}

		$pelIfd0 = $pelTiff->getIfd();
		if ($pelIfd0 == null) {
		    $pelIfd0 = new PelIfd(PelIfd::IFD0);
		    $pelTiff->setIfd($pelIfd0);
		}
		$pelIfd0->addEntry(new PelEntryAscii(PelTag::IMAGE_DESCRIPTION, $_POST['info']));
		$pelJpeg->saveFile('img/re'.$_POST['picName2']);
		echo 'img/re'.$_POST['picName2']."<br>";
	}
	else
	{
		echo "Пароль не пройд3н<br>";
	}
?>

<form method="post">
	<input type="text" name="picName2" placeholder="Название картинки" size="30">
	<input type="password" name="passw" placeholder="Пароль" size="30">
	<input type="text" name="info" placeholder="Тэг" size="30">
	<input id="submit" type="submit" value="Проверить">
</form>
