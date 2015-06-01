 <?php   
	/************************************************/
	/* Les fonctions utilisés dans les fichiers php */
	/************************************************/
	
	/* Fonction qui permet de compter le numéro journalier des produit mauvais pour la machine sélectionnée */
	/*Entre  : jour d'aujourd'hui, machine sélectionnée														*/
	/*Sortie : nombre des défauts pour cette machine pendant la journée										*/
	function nb_defaut_m ($jour,$machine,$conn)
	{
		$nb=0;
		$req="SELECT MAX(nb) AS nb FROM [ping2].[dbo].[graf] WHERE jour =  '$jour' AND  machine =  '$machine'";
    
		$row=sqlsrv_fetch_array(sqlsrv_query($conn, $req, array(), array("Scrollable"=>"buffered"))); 
		$nb=$row['nb'];
		return $nb;
	}
	
	/*Fonction qui permet de compter le numéro journalier des produit mauvais pour toutes les machines	*/
	/*Entre  : jour d'aujourd'hui																		*/
	/*Sortie : nombre des défauts pour toutes les machines pendant la journée							*/
	function nb_defaut ($jour,$conn)
	{
		$nb=0;
		$req="SELECT max(nb) as nb FROM [ping2].[dbo].[graftotal] where jour = '$jour' ";
    
		$row= sqlsrv_fetch_array(sqlsrv_query($conn, $req, array(), array("Scrollable"=>"buffered"))); 
		$nb=$row['nb'];
		return $nb;
	}
	
	/*Fonction permettante de calculer le paréto d'un défaut pour la machine séletionnée*/
	/*Entre  : defaut, machine sélectionné, nombre des défauts pour cette machine		*/
	/*Sortie : pourcetage pour ce défaut												*/
	function pareto_m($defaut,$machine,$nombre,$conn)
	{
		$type = 0;
		
		$row = sqlsrv_fetch_array(sqlsrv_query($conn, "SELECT top 1 [defau].[code],[defau].[nom],QuelleMachine,NumEnr,NumPal,[Date]
FROM [ping2].[dbo].[defaut] AS [defau]
JOIN [ping2].[dbo].[tesysk_auto] AS [defec] ON [defau].[code] = [defec].[CodeDefaut]
AND  cast(convert(char(8), [Date], 112) as int) =  cast(convert(char(8), GETDATE(), 112) as int)
",array(), array("Scrollable"=>"buffered")));

		//echo $row['QuelleMachine']."-----".$row['NumEnr']."------".$row['NumPal']."<br/>";
		
		$count = 0;
		
        $query=sqlsrv_query($conn, "SELECT [defau].[code],[defau].[nom],QuelleMachine,NumEnr,NumPal,[Date]
FROM [ping2].[dbo].[defaut] AS [defau]
JOIN [ping2].[dbo].[tesysk_auto] AS [defec] ON [defau].[code] = [defec].[CodeDefaut]
AND  cast(convert(char(8), [Date], 112) as int) =  cast(convert(char(8), GETDATE(), 112) as int)
AND defau.nom LIKE  '%$defaut%'
AND defec.QuelleMachine LIKE '%$machine%'
order by [date] asc",array(), array("Scrollable"=>"buffered"));
    		
		while($rownext = sqlsrv_fetch_array($query))
		{
			//echo $row['QuelleMachine']."-----".$row['NumEnr']."------".$row['NumPal']."<br/>";
			
			//echo $rownext['QuelleMachine']."-----".$rownext['NumEnr']."------".$rownext['NumPal']."<br/>";
			
			if($rownext['NumEnr'] == $row['NumEnr'] + 1 && $rownext['NumPal'] == $row['NumPal'])
				$count++;	
			
			$row = $rownext;
		}
		$row = sqlsrv_num_rows($query);
		//echo $count."/";
		//echo $row."<br/>";
		
        if($nombre != 0)
			$type = round($count/$nombre*100,2);
		//echo $count.'    '.$nombre."<br/>";
		return $type;
	}
	
	/*Fonction permettante de calculer le paréto d'un défaut pour la machine séletionnée*/
	/*Entre  : defaut, nombre des défauts pour toutes les machines						*/
	/*Sortie : pourcetage pour ce défaut journalier										*/
	function pareto($defaut,$nombre,$conn)
	{
		$type=0;
        $req="SELECT COUNT ([nom]) AS nb
FROM [ping2].[dbo].[defaut] AS [defau]
JOIN [ping2].[dbo].[tesysk_auto] AS [defec] ON [defau].[code] = [defec].[CodeDefaut]
AND defau.nom LIKE  '%$defaut%'
AND  cast(convert(char(8), [Date], 112) as int) =  cast(convert(char(8), GETDATE(), 112) as int)
GROUP BY [defau].[nom]";
    
		$row = sqlsrv_fetch_array(sqlsrv_query($conn, $req, array(), array("Scrollable"=>"buffered")));
		if($nombre != 0)
			$type = round($row['nb']/$nombre*100,2);
		return $type;
	}
	
	
	function convert_j($jour) {
		switch($jour) {
			case 'Sun':
				return 'Dim';
				break;
			case 'Mon':
				return 'Lun';
				break;
			case 'Tue':
				return 'Mar';
				break;
			case 'Wed':
				return 'Mer';
				break;
			case 'Thu':
				return 'Jeu';
				break;
			case 'Fri':
				return 'Ven';
				break;
			case 'Sat':
				return 'Sam';
				break;
			default:
				break;
		}
	}
	
	
	function nbdefaut($conn,$machine)
	{
		$row = sqlsrv_fetch_array(sqlsrv_query($conn, "select top 1 QuelleMachine,[Date],CodeDefaut,NumEnr,NumPal from [ping2].[dbo].[TeSysK_Auto]",array(), array("Scrollable"=>"buffered")));
		$count = 0;
		$graph = array
				(
					"jour" 	=> array("","","","","","",""),
					"nb"	=> array(0,0,0,0,0,0,0)
				);
	
		$donne=file_get_contents('graph_'.$machine.'.dat');
		$n = sscanf($donne,"%f\t%f\t%f\t%f\t%f\t%f\t%f\n%s\t%s\t%s\t%s\t%s\t%s\t%s",
					$graph['nb'][0],  $graph['nb'][1],  $graph['nb'][2],  $graph['nb'][3],  $graph['nb'][4],  $graph['nb'][5],  $graph['nb'][6],
					$graph['jour'][0],$graph['jour'][1],$graph['jour'][2],$graph['jour'][3],$graph['jour'][4],$graph['jour'][5],$graph['jour'][6]
					);

		if($graph['jour'][6] != date('D'))
		{
			for($i = 0; $i < 6; $i++)
			{
				$graph['nb'][$i] = $graph['nb'][$i+1];
			}
			$graph['nb'][6] = 0;
		
			$graph['jour'][6] = date('D');	
			$date = new DateTime();
			for($i = 0; $i < 6; $i++)
			{
				$date->add(new DateInterval('P1D'));
				if ($date->format('N')<8)
					$graph['jour'][$i]=$date->format('D');
			}
		}	
    
		$query = sqlsrv_query($conn, 
					"select QuelleMachine,[Date],CodeDefaut,NumEnr,NumPal 
					from [ping2].[dbo].[TeSysK_Auto] 
					where CodeDefaut > 0 
					and cast(convert(char(8), [Date], 112) as int) = cast(convert(char(8), GETDATE(), 112) as int) AND [CodeDefaut] >0
					and QuelleMachine = '$machine'"
					,array(), array("Scrollable"=>"buffered"));
		
		while($rownext = sqlsrv_fetch_array($query))
		{
			//echo $row['QuelleMachine']."-----".$row['NumEnr']."------".$row['NumPal']."<br/>";
			//echo $rownext['QuelleMachine']."-----".$rownext['NumEnr']."------".$rownext['NumPal']."<br/>";
			if($rownext['NumEnr'] == $row['NumEnr'] + 1 && $rownext['NumPal'] == $row['NumPal'])
				$count++;	
			$row = $rownext;
		}
		
		$line = sqlsrv_fetch_array(sqlsrv_query($conn, "SELECT COUNT(  [CodeDefaut] ) AS nombre 
						FROM  [ping2].[dbo].[TeSysK_Auto] 
						WHERE  cast(convert(char(8), [Date], 112) as int) = cast(convert(char(8), GETDATE(), 112) as int) 
						and QuelleMachine = '$machine'
						AND [CodeDefaut] = 0",
						array(), array("Scrollable"=>"buffered")));
		$nb_total = $line['nombre'];

		//Calculer le pourcentage du défaut
		if( $count != 0)
			$pourcentage = round($count/($nb_total+$count)*100,2);
		else
			$pourcentage = 0;
		
		file_put_contents("macdef/".$machine.".dat", $count);
		
		//GraphMachine
		if($graph['nb'][6]!= $pourcentage)
		{
			$graph['nb'][6] = $pourcentage;
		}
		//Enregistrer des données dans le graph.bat
		$donne = sprintf("%.2f\t%.2f\t%.2f\t%.2f\t%.2f\t%.2f\t%.2f\n%s\t%s\t%s\t%s\t%s\t%s\t%s", 
					$graph['nb'][0],
					$graph['nb'][1],
					$graph['nb'][2],
					$graph['nb'][3],
					$graph['nb'][4],
					$graph['nb'][5],
					$graph['nb'][6],
					$graph['jour'][0],
					$graph['jour'][1],
					$graph['jour'][2],
					$graph['jour'][3],
					$graph['jour'][4],
					$graph['jour'][5],
					$graph['jour'][6]);
	
		file_put_contents('graph_'.$machine.'.dat', $donne);
		return $nb_total.' '.$pourcentage;
		
	}
	

	
	
	
	
?>