<?php

	include_once 'include/util.php';
	include 'conn.php';
	
	// get options
	$machine 		= $_POST["machine"];
	$dateOffset = $_POST["dateOffset"];
	
	// get datas
	$listData = get24hData($conn, $machine, $dateOffset);
	$listData = json_encode($listData);
	
	echo "DATA!!!\nMachine: ".$machine."\nDateOffset: ".$dateOffset."\nData: ".$listData."\nEND!!!";

?>