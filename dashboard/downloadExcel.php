<?php

	$path = $_GET['path'];
	
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");;
	header("Content-Disposition:attachment;filename=\"".$path."\"");
	header("Content-Transfer-Encoding:binary");

?>