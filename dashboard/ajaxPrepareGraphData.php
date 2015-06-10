<?php

	// get infos
	$machine = $_POST['machine'];
	$option  = $_POST['option'];
	
	// check option
	switch($option) {
		case "pourc":
			// get data
			$listMachineGraphPourc = $_POST['listMachineGraphPourc'];
			$graphPourc = $listMachineGraphPourc[$machine];
			
			// store as result
			$result = $graphPourc;
			break;
			
		case "pareto":
			// get data
			$listMachineGraphPareto = $_POST['listMachineGraphPareto'];
			$graphPareto = $listMachineGraphPareto[$machine];
			
			// store as result
			$result = $graphPareto;
			break;
			
		default:
			break;
	}
	
	// encode result in JSON and send back
	echo json_encode($result);

?>