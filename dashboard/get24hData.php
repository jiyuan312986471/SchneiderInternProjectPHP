<?php

	include_once 'include/util.php';
	include 'conn.php';
	
	// get options
	$machine 		= $_POST["machine"];
	$dateOffset = $_POST["dateOffset"];
	
	// get datas
	$listData = get24hData($conn, $machine, $dateOffset);
	
	// hour list
	$listHour = array();
	for($i = 0; $i < 24; $i++){
		array_push($listHour, $i.":00");
	}
	
	if($listData != NULL){
		// data lists by hour
		$listDataHour = array();
		$dataHour0 = array();
		$dataHour1 = array();
		$dataHour2 = array();
		$dataHour3 = array();
		$dataHour4 = array();
		$dataHour5 = array();
		$dataHour6 = array();
		$dataHour7 = array();
		$dataHour8 = array();
		$dataHour9 = array();
		$dataHour10 = array();
		$dataHour11 = array();
		$dataHour12 = array();
		$dataHour13 = array();
		$dataHour14 = array();
		$dataHour15 = array();
		$dataHour16 = array();
		$dataHour17 = array();
		$dataHour18 = array();
		$dataHour19 = array();
		$dataHour20 = array();
		$dataHour21 = array();
		$dataHour22 = array();
		$dataHour23 = array();
		
		// regroup data by hour
		foreach($listData as $data){
			// get hour
			$dateTime = $data["Date"];
			$hour = $dateTime->format('G');
			
			// check hour and regroup
			switch($hour){
				case "0":
					array_push($dataHour0, $data);
					break;
				
				case "1":
					array_push($dataHour1, $data);
					break;
					
				case "2":
					array_push($dataHour2, $data);
					break;
					
				case "3":
					array_push($dataHour3, $data);
					break;
					
				case "4":
					array_push($dataHour4, $data);
					break;
					
				case "5":
					array_push($dataHour5, $data);
					break;
					
				case "6":
					array_push($dataHour6, $data);
					break;
					
				case "7":
					array_push($dataHour7, $data);
					break;
					
				case "8":
					array_push($dataHour8, $data);
					break;
					
				case "9":
					array_push($dataHour9, $data);
					break;
					
				case "10":
					array_push($dataHour10, $data);
					break;
					
				case "11":
					array_push($dataHour11, $data);
					break;
					
				case "12":
					array_push($dataHour12, $data);
					break;
					
				case "13":
					array_push($dataHour13, $data);
					break;
					
				case "14":
					array_push($dataHour14, $data);
					break;
					
				case "15":
					array_push($dataHour15, $data);
					break;
					
				case "16":
					array_push($dataHour16, $data);
					break;
					
				case "17":
					array_push($dataHour17, $data);
					break;
					
				case "18":
					array_push($dataHour18, $data);
					break;
					
				case "19":
					array_push($dataHour19, $data);
					break;
					
				case "20":
					array_push($dataHour20, $data);
					break;
					
				case "21":
					array_push($dataHour21, $data);
					break;
					
				case "22":
					array_push($dataHour22, $data);
					break;
				
				case "23":
					array_push($dataHour23, $data);
					break;
					
				default:
					break;
			}
		}
		
		// push data into list
		array_push($listDataHour, $dataHour0);
		array_push($listDataHour, $dataHour1);
		array_push($listDataHour, $dataHour2);
		array_push($listDataHour, $dataHour3);
		array_push($listDataHour, $dataHour4);
		array_push($listDataHour, $dataHour5);
		array_push($listDataHour, $dataHour6);
		array_push($listDataHour, $dataHour7);
		array_push($listDataHour, $dataHour8);
		array_push($listDataHour, $dataHour9);
		array_push($listDataHour, $dataHour10);
		array_push($listDataHour, $dataHour11);
		array_push($listDataHour, $dataHour12);
		array_push($listDataHour, $dataHour13);
		array_push($listDataHour, $dataHour14);
		array_push($listDataHour, $dataHour15);
		array_push($listDataHour, $dataHour16);
		array_push($listDataHour, $dataHour17);
		array_push($listDataHour, $dataHour18);
		array_push($listDataHour, $dataHour19);
		array_push($listDataHour, $dataHour20);
		array_push($listDataHour, $dataHour21);
		array_push($listDataHour, $dataHour22);
		array_push($listDataHour, $dataHour23);
		
		// calcul result list
		$listPourc = array();
		
		// calculate pourc by hour
		foreach($listDataHour as $dataHour){
			// calculate nbDefaut and nbTotal
			$nbDefaut = 0;
			$nbTotal = 0;
			while($row = current($dataHour)){
				$rowNext = next($dataHour);
				
				if($row['CodeDefaut'] > 0 && $rowNext['NumEnr'] == $row['NumEnr'] + 1 && $rowNext['NumPal'] == $row['NumPal']){
					$nbDefaut++;
				}
				else if($row['CodeDefaut'] == 0){
					$nbTotal++;
				}
				
				$row = $rowNext;
			}
			
			// calculate pourc
			$pourc = calcuPourc($nbDefaut, $nbTotal);
			
			// store result
			array_push($listPourc, $pourc);
		}
	}
	else{
		$listPourc = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	}
	
	// date
	$date = get24hGraphDate($dateOffset);
	
	// map hour list and data lists
	$listData = array("hour" => $listHour, "pourc" => $listPourc);
	$listData = json_encode($listData);
	
	echo $listData."AND".$date;

?>