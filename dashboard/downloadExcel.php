<?php

	$fileName = $_GET['fileName'];
	
	$file = fopen("excel/temp.xls", "r");
	
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-excel");
	header("Content-Disposition:attachment;filename=\"".$fileName."\"");
	header("Content-Transfer-Encoding:binary");
	
	echo fread($file, filesize("excel/temp.xls"));
	fclose($file);

?>