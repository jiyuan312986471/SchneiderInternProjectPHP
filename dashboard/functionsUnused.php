<?php

	/* Fonction qui permet de compter le num��ro journalier des produit mauvais pour la machine s��lectionn��e */
	/* Entre  : jour d'aujourd'hui, machine s��lectionn��e																										*/
	/* Sortie : nombre des d��fauts pour cette machine pendant la journ��e																		*/
	function nb_defaut_m ($jour,$machine,$conn) {
		$nb = 0;
		$req = "SELECT MAX(nb) AS nb FROM [ping2].[dbo].[graf] WHERE jour =  '$jour' AND  machine =  '$machine'";
    
		$row = sqlsrv_fetch_array(sqlsrv_query($conn, $req, array(), array("Scrollable"=>"buffered"))); 
		$nb = $row['nb'];
		return $nb;
	}
	
	
	/* Fonction qui permet de compter le num��ro journalier des produit mauvais pour toutes les machines			*/
	/* Entre  : jour d'aujourd'hui																																					*/
	/* Sortie : nombre des d��fauts pour toutes les machines pendant la journ��e															*/
	function nb_defaut ($jour,$conn) {
		$nb = 0;
		$req = "SELECT max(nb) AS nb FROM [ping2].[dbo].[graftotal] WHERE jour = '$jour' ";
    
		$row = sqlsrv_fetch_array(sqlsrv_query($conn, $req, array(), array("Scrollable"=>"buffered"))); 
		$nb = $row['nb'];
		return $nb;
	}
	
	/* Fonction permettante de calculer le par��to d'un d��faut pour la machine s��letionn��e										*/
	/* Entre  : defaut, nombre des d��fauts pour toutes les machines																					*/
	/* Sortie : pourcetage pour ce d��faut journalier																												*/
	function pareto($defaut,$nombre,$conn) {
		$type = 0;
    $req = "SELECT COUNT ([nom]) AS nb
						FROM [ping2].[dbo].[defaut] AS [defau]
						JOIN [ping2].[dbo].[tesysk_auto] AS [defec] ON [defau].[code] = [defec].[CodeDefaut]
						AND defau.nom LIKE  '%$defaut%'
						AND  cast(convert(char(8), [Date], 112) as int) =  cast(convert(char(8), GETDATE(), 112) as int)
						GROUP BY [defau].[nom]";
    
		$row = sqlsrv_fetch_array(sqlsrv_query($conn, $req, array(), array("Scrollable"=>"buffered")));
		if($nombre != 0) {
			$type = round($row['nb']/$nombre*100,2);
		}
		return $type;
	}
	
	/* Fonction permettante de calculer le par��to d'un d��faut pour la machine s��letionn��e										*/
	/* Entre  : defaut, machine s��lectionn��, nombre des d��fauts pour cette machine													*/
	/* Sortie : pourcentage pour ce d��faut																																	*/
	function pareto_m($defaut,$machine,$nombre,$conn) {
		$type = 0;
		
		$row = sqlsrv_fetch_array(sqlsrv_query($conn, "SELECT TOP 1 [defau].[code],[defau].[nom],QuelleMachine,NumEnr,NumPal,[Date] 
																									 FROM [ping2].[dbo].[defaut] AS [defau]
																									 JOIN [ping2].[dbo].[TeSysK_Auto] AS [defec] ON [defau].[code] = [defec].[CodeDefaut]
																									 AND  cast(convert(char(8), [Date], 112) AS int) =  cast(convert(char(8), getdate(), 112) AS int)",
																					 array(), array("Scrollable"=>"buffered")));

		//echo $row['QuelleMachine']."-----".$row['NumEnr']."------".$row['NumPal']."<br/>";
		
		$count = 0;
		
    $query = sqlsrv_query($conn, "SELECT [defau].[code],[defau].[nom],QuelleMachine,NumEnr,NumPal,[Date]
																	FROM [ping2].[dbo].[defaut] AS [defau]
																	JOIN [ping2].[dbo].[tesysk_auto] AS [defec] ON [defau].[code] = [defec].[CodeDefaut]
																	AND  cast(convert(char(8), [Date], 112) as int) =  cast(convert(char(8), getdate(), 112) AS int)
																	AND defau.nom LIKE  '%$defaut%'
																	AND defec.QuelleMachine LIKE '%$machine%'
																	ORDER BY [Date] asc",
													array(), array("Scrollable"=>"buffered"));
    		
		while($rownext = sqlsrv_fetch_array($query)) {
			//echo $row['QuelleMachine']."-----".$row['NumEnr']."------".$row['NumPal']."<br/>";
			
			//echo $rownext['QuelleMachine']."-----".$rownext['NumEnr']."------".$rownext['NumPal']."<br/>";
			
			if($rownext['NumEnr'] == $row['NumEnr'] + 1 && $rownext['NumPal'] == $row['NumPal']) {
				$count++;
			}
			
			$row = $rownext;
		}
		$row = sqlsrv_num_rows($query);
		//echo $count."/";
		//echo $row."<br/>";
		
    if($nombre != 0) {
			$type = round($count/$nombre*100,2);
		}
		//echo $count.'    '.$nombre."<br/>";
		return $type;
	}
	
	/* Fonction																																															*/
	/* Entre	:																																															*/
	/* Sortie	:																																															*/
	function nbdefaut($conn,$machine) {
		$row = sqlsrv_fetch_array(sqlsrv_query($conn, "SELECT TOP 1 QuelleMachine,[Date],CodeDefaut,NumEnr,NumPal FROM [ping2].[dbo].[TeSysK_Auto]",array(), array("Scrollable"=>"buffered")));
		$count = 0;
		$graph = array("jour" => array("","","","","","",""), "nb"	 => array(0, 0, 0, 0, 0, 0, 0));
	
		$donne = file_get_contents('graph_'.$machine.'.dat');
		$n = sscanf($donne,"%f\t%f\t%f\t%f\t%f\t%f\t%f\n%s\t%s\t%s\t%s\t%s\t%s\t%s",
								$graph['nb'][0],  $graph['nb'][1],  $graph['nb'][2],  $graph['nb'][3],  $graph['nb'][4],  $graph['nb'][5],  $graph['nb'][6],
								$graph['jour'][0],$graph['jour'][1],$graph['jour'][2],$graph['jour'][3],$graph['jour'][4],$graph['jour'][5],$graph['jour'][6]);

		if($graph['jour'][6] != date('D')) {
			for($i = 0; $i < count($graph['nb'])-1; $i++) {
				$graph['nb'][$i] = $graph['nb'][$i+1];
			}
			$graph['nb'][6] = 0;
		
			$graph['jour'][6] = date('D');	
			$date = new DateTime();
			for($i = 0; $i < 6; $i++){
				$date->add(new DateInterval('P1D'));
				if ($date->format('N')<8) {
					$graph['jour'][$i]=$date->format('D');
				}
			}
		}	
    
		$query = sqlsrv_query($conn, "SELECT QuelleMachine,[Date],CodeDefaut,NumEnr,NumPal 
																	FROM [ping2].[dbo].[TeSysK_Auto] 
																	WHERE CodeDefaut > 0 
																	AND cast(convert(char(8), [Date], 112) AS int) = cast(convert(char(8), GETDATE(), 112) AS int) 
																	AND [CodeDefaut] > 0
																	AND QuelleMachine = '$machine'",
													array(), array("Scrollable"=>"buffered"));
		
		while($rownext = sqlsrv_fetch_array($query)) {
			//echo $row['QuelleMachine']."-----".$row['NumEnr']."------".$row['NumPal']."<br/>";
			//echo $rownext['QuelleMachine']."-----".$rownext['NumEnr']."------".$rownext['NumPal']."<br/>";
			if($rownext['NumEnr'] == $row['NumEnr'] + 1 && $rownext['NumPal'] == $row['NumPal']) {
				$count++;
			}
			$row = $rownext;
		}
		
		$line = sqlsrv_fetch_array(sqlsrv_query($conn, "SELECT count([CodeDefaut]) AS nombre 
																										FROM  [ping2].[dbo].[TeSysK_Auto] 
																										WHERE  cast(convert(char(8), [Date], 112) AS int) = cast(convert(char(8), GETDATE(), 112) AS int) 
																										AND QuelleMachine = '$machine'
																										AND [CodeDefaut] = 0",
																						array(), array("Scrollable"=>"buffered")));
		$nb_total = $line['nombre'];

		//Calculer le pourcentage du d��faut
		if($count != 0) {
			$pourcentage = round($count/($nb_total+$count)*100,2);
		}
		else {
			$pourcentage = 0;
		}
		
		file_put_contents("macdef/".$machine.".dat", $count);
		
		//GraphMachine
		if($graph['nb'][6]!= $pourcentage) {
			$graph['nb'][6] = $pourcentage;
		}
		//Enregistrer des donn��es dans le graph.bat
		$donne = sprintf("%.2f\t%.2f\t%.2f\t%.2f\t%.2f\t%.2f\t%.2f\n%s\t%s\t%s\t%s\t%s\t%s\t%s", 
											$graph['nb'][0],  $graph['nb'][1],  $graph['nb'][2],  $graph['nb'][3],  $graph['nb'][4],  $graph['nb'][5],  $graph['nb'][6],
											$graph['jour'][0],$graph['jour'][1],$graph['jour'][2],$graph['jour'][3],$graph['jour'][4],$graph['jour'][5],$graph['jour'][6]);
	
		file_put_contents('graph_'.$machine.'.dat', $donne);
		
		return $nb_total.' '.$pourcentage;
	}

?>