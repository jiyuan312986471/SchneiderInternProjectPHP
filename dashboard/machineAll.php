<?php

	/***********************************************************
  *																													 *
	*											FOR	THE PAGE		  									 *
  *																													 *
  ***********************************************************/
	
	include 'util.php';
  require_once('../bdd.php');

  // DB connection
	$db = new bdd("SAMUEL-PC","bdd_user","user_bdd","ping2");
	$conn = $db->getConn();
  
  // get time
  $date = date('Y-m-d');
  $heure = date('H:i');
  $jour = date('D');
  
  // refresh
  //echo '<META HTTP-EQUIV="Refresh" CONTENT="8; URL=machineAll.php">';
  
  // declare 6 machines
  $listMachine = array("AK","SAK","DT1","DT2","SAD","DT3");
  
  // declare graph pourcentage
  $graphPourc = array();
  
  // declare graph pareto
  $graphPareto = array();
  
  // initialize display option
  $listOption = array("pourc","pourc","pourc","pourc","pourc","pourc");
  $optionMachine = array_combine($listMachine, $listOption);
  
  // all graph pourcentage
  $listGraphPourc = array();
  
  // all graph pareto
  $listGraphPareto = array();
  
  // machine -> graphPourc
  $listMachineGraphPourc = array();
  
  // machine -> graphPareto
  $listMachineGraphPareto = array();
  
?>


<!------------------------------------------ PAGE STRUCTURE ------------------------------------------>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Schneider application</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="css/plugins/timeline.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link href="css/plugins/morris.css" rel="stylesheet">
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
</head>

<body>
		<!------- JAVASCRIPT ------->
		<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
    
    <!-- Functions used JavaScript -->
   	<script src="js/util.js"></script>
    
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
       		<?php
       			include('divs/logo.php');
       			//notification et logout
            include('divs/barre.php');
            //Menu
            include('divs/menu.php');
          ?>
        </nav>

        <!-- contenu -->
        <div id="page-wrapper">
        	
        	<div class="row">
        		<div class="col-lg-12">
        			<h1 class="page-header">
        				Machines
        			</h1>
        		</div>
          </div>
          
        	<div class="row" id="graphs">


<!----------------------------------------- FOR EACH MACHINE ----------------------------------------->
  
<?php

  foreach($listMachine as $machine) {
  	
  	////////////////////////////////// DATA PREPARATION //////////////////////////////////
  	
  	// DISPLAY OPTION
  	$option = $optionMachine[$machine];
  	
  	// POURCENTAGE GRAPH
		$graphPourc = getPourcGraphData($machine);
  	
		// PARETO GRAPH
  	$graphPareto = getParetoGraphData($machine, $conn);
  	$listDefaut = array_keys($graphPareto);
  	$listPareto = array_values($graphPareto);
  	
		// push datas into graph lists
		array_push($listGraphPourc, $graphPourc);
		array_push($listGraphPareto, $graphPareto);
								
?>

<!------------------------------------ DRAW GRAPH OF EACH MACHINE ------------------------------------>
        	
	        	<!-- panel for machine -->
	        	<div class="col-lg-6">
		        	<div class="panel panel-success" id="graphMachine<?php echo $machine; ?>"></div>
			      </div>
		
		<!-- Draw Chosen Graph -->
    <script language="javascript">
    	start(
    		<?php echo json_encode($machine); ?>,
    		<?php echo json_encode($option); ?>,
    		<?php echo json_encode($graphPourc); ?>,
    		<?php echo json_encode($listDefaut); ?>,
    		<?php echo json_encode($listPareto); ?>
    	);
    </script>

<?php
  } // end foreach machine
?>

					</div>
				</div>
		</div>

<!------------------------------------------ PAGE STRUCTURE ------------------------------------------>

<?php

	// map machine list (as keys) with graphPourc list (as values)
	$listMachineGraphPourc = array_combine($listMachine, $listGraphPourc);
	
	// map machine list (as keys) with graphPourc list (as values)
	$listMachineGraphPareto = array_combine($listMachine, $listGraphPareto);

?>

<!-- MUTATION OBSERVER-->
<script language="javascript">
	// prepare mutation observer
	var MutationObserver = window.MutationObserver || window.WebKitMutationObserver ||  window.MozMutationObserver;
	var mutationObserverSupport = !!MutationObserver;
	
	// set callback function
	var callback = function(mutationRecords){
		// get mutation record
    mutationRecords.forEach(function(mutationRecord){
    	// get node
    	var node = mutationRecord.target;
    	
    	// check class value
    	if(node.attributes["class"].value.indexOf("active") >= 0) { // button active
    		// get id
    		var idTarget = node.attributes["id"].value;
    		
    		// Pourcentage button
    		if(idTarget.indexOf("Pourcentage") >= 0) {
    			// get machine
    			var machine = idTarget.substring("Pourcentage".length);
    			
    			// set option
    			var option = "pourc";
    			
    			// prepare parametres for AJAX
    			var url = "ajaxPrepareGraphData.php";
    			var datas = {
    				machine: machine,
    				option:	option,
    				listMachineGraphPourc: <?php echo json_encode($listMachineGraphPourc); ?>,
    			};
    			
    			// send data to AJAX
    			$.post(url, datas, function(data){alert(data)});
    		}
    		
    		// Pareto button
    		else if(idTarget.indexOf("Pareto") >= 0) {
    			// get machine
    			var machine = idTarget.substring("Pareto".length);
    			
    			// set option
    			var option = "pareto";
    			
    			// prepare parametres for AJAX
    			var url = "ajaxPrepareGraphData.php";
    			var datas = {
    				machine: machine,
    				option:	option,
    				listMachineGraphPareto: <?php echo json_encode($listMachineGraphPareto); ?>,
    			};
    			
    			// send data to AJAX
    			$.post(url, datas, function(data){alert(data)});
    		}
    	}
    });
	};
	
	// create mutation observer
	var mo = new MutationObserver(callback);
	
	// set element
	var element = document.getElementById('graphs');

	// set option
	var observerOption = {
	    attributes: true,
	    attributeFilter: ["class"],
	    subtree: true
	};
	
	// start observer
	mo.observe(element, observerOption);
</script>

</body>
</html>