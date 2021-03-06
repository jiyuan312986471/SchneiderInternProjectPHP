<?php

	include_once 'include/util.php';
	
	include 'conn.php';
	
	include 'include/listMachine.php';
	include 'include/listTypeProduit.php';
	include 'include/listDefaut.php';
	
	// get time
  $date  = date('Y-m-d');
  $heure = date('H:i');
  $jour  = date('D');
	
	// get pourcentage graph
	$graph = getPourcGraphData("All");

	// move previous data
	if($graph['jour'][6] != $jour) {		
		// algo with count
		for($i = 0; $i < count($graph['pourc'])-1; $i++) {
			$graph['pourc'][$i] = $graph['pourc'][$i+1];
		}
		
		$graph['pourc'][6] = 0;
		
		$graph['jour'][6] = $jour;
			
		$date = new DateTime();
		for($i = 0; $i < 6; $i++) {
			$date->add(new DateInterval('P1D'));
			if ($date->format('N')<8) {
				$graph['jour'][$i]=$date->format('D');
			}
		}
	}
	
	// Chercher des nb total et taux de defaut pour chaque machine
	$nbMachine = count($listMachine);
	$arrayNb = array();
	$arrayPourc = array();
	
	for($i = 0; $i < $nbMachine; $i++) {
		array_push($arrayNb, 0);
		array_push($arrayPourc, 0);
	}
	
	$paraMachine = array( "nb" 	=> $arrayNb, "pourc"	=> $arrayPourc );
	
	for($i = 0; $i < $nbMachine; $i++) {
		sscanf(nbdefaut($conn, $listMachine[$i]), "%d %f", $paraMachine['nb'][$i], $paraMachine['pourc'][$i]);
	}
	
	$sum = 0;
	$sumdefaut = 0;
	for ($i = 0; $i < count($paraMachine['nb']); $i++) {
		$sum = $paraMachine['nb'][$i] + $sum;
		$sumdefaut = $paraMachine['nb'][$i] * $paraMachine['pourc'][$i] + $sumdefaut;
	}
	
	if($sum == 0) {
		$nombre = 0;
	}
	else {
		$nombre = round($sumdefaut/$sum,2);
	}
	
	//GraphTotal
  if($graph['pourc'][6]!= $nombre) {
  	$graph['pourc'][6] = $nombre;
	}
	
	// Enregistrer des donn��es dans le graph.bat
	$donne = sprintf("%f\t%f\t%f\t%f\t%f\t%f\t%f\n%s\t%s\t%s\t%s\t%s\t%s\t%s", 
										$graph['pourc'][0],$graph['pourc'][1],$graph['pourc'][2],$graph['pourc'][3],$graph['pourc'][4],$graph['pourc'][5],$graph['pourc'][6],
										$graph['jour'][0], $graph['jour'][1], $graph['jour'][2], $graph['jour'][3], $graph['jour'][4], $graph['jour'][5], $graph['jour'][6] );
	//file_put_contents('../graph.dat', $donne);
	file_put_contents('graph.dat', $donne);
	
	// set date display format
	foreach($graph['jour'] as &$jour){
		$jour = convert_j($jour);
	}
	
	// encode graph into json and return
	echo json_encode($graph);

?>