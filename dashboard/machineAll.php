<?php

	/***********************************************************
  *																													 *
	*											FOR	THE PAGE		  									 *
  *																													 *
  ***********************************************************/
	
	session_start();
	
	include 'include/util.php';
  
  include 'conn.php';
	
	include 'include/listMachine.php';
	include 'include/listTypeProduit.php';
	include 'include/listDefaut.php';
  
  // get time
  $date = date('Y-m-d');
  $heure = date('H:i');
  $jour = date('D');
  
  // declare graph pourcentage
  $graphPourc = array();
  
  // declare graph pareto
  $graphPareto = array();
  
  // all graph pourcentage
  $listGraphPourc = array();
  
  // all graph pareto
  $listGraphPareto = array();
  
  // machine -> graphPourc
  $listMachineGraphPourc = array();
  
  // machine -> graphPareto
  $listMachineGraphPareto = array();
  
  if(isset($_SESSION["refreshTime"])){
		$refreshTime = $_SESSION["refreshTime"];
	}
	else{
		$refreshTime = 8;
	}
  
?>


<!------------------------------------------ PAGE STRUCTURE ------------------------------------------>

<!DOCTYPE html>
<html lang="en">
	<!-- Head -->
	<?php include 'divs/head.php'; ?>

	<body>
		<!-- Configuration Modal -->
  	<?php include 'divs/modalConfig.php'; ?>
    
    <div id="wrapper">
    	<!-- NavBar -->
      <?php include 'divs/navbar.php'; ?>

			<!-- JSON -->
		  <script src="js/json2.js"></script>
		
		  <!-- Initialize Display Option JavaScript -->
		  <script language="javascript">
		  	// listOption
		  	var listOption 	= new Array("pourc","pourc","pourc","pourc","pourc","pourc");
		   		
		  	// listMachine
		  	var listMachine = <?php echo json_encode($listMachine); ?>;
		   		
		  	// create OptionMachine
		  	var optionMachine = {};
		   		
		  	// combine 
		  	for(var index in listMachine){
		  		optionMachine[listMachine[index]] = listOption[index];
		  	}
		  </script>
		  
		  <!-- Graph Container -->
		  <script language="javascript">
		  	var listGraph = new Array();
		  </script>
				
      <!-- contenu -->
      <div id="page-wrapper">
        
        <!-- Title -->
      	<div class="row">
      		<div class="col-lg-12">
      			<h1 class="page-header">
      				Machines
      			</h1>
      		</div>
        </div>
        
        <!-- Graphs -->
       	<div class="row" id="graphs">

<!----------------------------------------- FOR EACH MACHINE ----------------------------------------->
  
					<?php
					
					  foreach($listMachine as $machine) {
					  	
					  	////////////////////////////////// DATA PREPARATION //////////////////////////////////
					  	
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
					        	
					    <!-- panel for machine -->
						  <div class="col-lg-6">
						  	<div class="panel panel-success" id="graphMachine<?php echo $machine; ?>"></div>
						  </div>
					
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
	
	// map machine list (as keys) with graphPareto list (as values)
	$listMachineGraphPareto = array_combine($listMachine, $listGraphPareto);

?>

		<!-- Common Script Src Pool -->
		<?php include 'include/scripts.php'; ?>
		
		<!-- Graph Container -->
		<script language="javascript">
			// Map: machine -> graphContainer
			var mapMachineGraph = new Map();
			<?php foreach($listMachine as $machine){ ?>
				var machine = "<?php echo $machine; ?>";
				var graph;
				mapMachineGraph.put(machine, graph);
			<?php }	?>
		</script>
		
		<!-- MUTATION OBSERVER-->
		<script language="javascript">
			// refresh time
			var time = <?php echo $refreshTime; ?> * 1000;
			
			// draw graph and refresh
		  var jsonOptionMachine = JSON.stringify(optionMachine);
		  refreshMachineAllGraph(jsonOptionMachine, mapMachineGraph, time);
			
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
		    			optionMachine[machine] = option;
		    			
		    			// prepare parametres for AJAX
		    			var url = "ajaxPrepareGraphData.php";
		    			var datas = {
		    				machine: machine,
		    				option:	option,
		    				listMachineGraphPourc: <?php echo json_encode($listMachineGraphPourc); ?>,
		    			};
		    			
		    			// send data to AJAX
		    			$.post(url, datas, function(graphPourc){
		    				changeToGraphPourc(machine, graphPourc);
		    			});
		    		}
		    		
		    		// Pareto button
		    		else if(idTarget.indexOf("Pareto") >= 0) {
		    			// get machine
		    			var machine = idTarget.substring("Pareto".length);
		    			
		    			// set option
		    			var option = "pareto";
		    			optionMachine[machine] = option;
		    			
		    			// prepare parametres for AJAX
		    			var url = "ajaxPrepareGraphData.php";
		    			var datas = {
		    				machine: machine,
		    				option:	option,
		    				listMachineGraphPareto: <?php echo json_encode($listMachineGraphPareto); ?>,
		    			};
		    			
		    			// send data to AJAX
		    			$.post(url, datas, function(graphPareto){
		    				changeToGraphPareto(machine, graphPareto);
		    			});
		    		}
		    		
		    		// clear all timeouts
		    		var lastId = setTimeout(null,0);
		    		while(lastId--){
		    			clearTimeout(lastId);
		    		}
		    		
		    		// refresh after change
		    		jsonOptionMachine = JSON.stringify(optionMachine);
		    		refreshMachineAllGraph(jsonOptionMachine, mapMachineGraph, time);
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
		
		<!-- Modals Exporter -->
		<?php $listRef = getListRef($conn); ?>
		<?php foreach($listMachine as $machine) { ?>
			<div class="modal fade" id="modalExport<?php echo $machine; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						
						<!-- Modal Header -->
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Exporter <?php echo $machine; ?></h4>
						</div>
						
						<!-- Modal Body -->
						<?php if($listRef){ ?>
							<!-- Reference Selection -->
							<div class="modal-body">
								<div class="row">
									<label class="col-sm-3">
										<div class="pull-right">Reference :</div>
									</label>
									<div class="col-sm-7">
										<select id="selectRef<?php echo $machine; ?>" class="form-control">
											<option value="empty">-- Choisissez la reference --</option>
											<?php foreach($listRef as $ref){ ?>
												<option value="<?php echo $ref; ?>"><?php echo $ref; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
								
							<hr style="margin-top: 0px; margin-bottom: 2px">
								
							<!-- Period Selection -->
							<div class="modal-body">
								<div class="row">
									<label class="col-sm-3">
										<div class="pull-right">Duree :</div>
									</label>
									<div class="col-sm-7">
										<div id="dateRange<?php echo $machine; ?>" class="form-control" style="cursor: pointer">
											<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
											<span id="dateRangeVal<?php echo $machine; ?>" class="pull-right"></span>
											<b class="caret"></b>
										</div>
									</div>
								</div>
							</div>
								
						<?php } else { ?>
							<div class="modal-body">
								<h1 class="text-center">Connexion echec a la base de donnee.</h1>
							</div>
						<?php } ?>
						
						<!-- Modal Footer -->
						<?php if($listRef){ ?>
							<div class="modal-footer">
								<button id="buttonExport<?php echo $machine; ?>" type="button" class="btn btn-primary">Exporter</button>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
			
			<script language="javascript">
				/**********************************
				*				DATE RANGE PICKER
				**********************************/
				function callback(start, end) {
		    	$("span#dateRangeVal" + <?php echo json_encode($machine); ?>).html(start.format('D/M/YYYY HH:mm') + ' - ' + end.format('D/M/YYYY HH:mm'));
		    }
		    callback(moment().subtract(7, 'days'), moment());
		    	
		    $("#dateRange" + <?php echo json_encode($machine); ?>).daterangepicker({
			   	timePicker: true,
			   	timePickerIncrement: 60,
			   	timePicker24Hour: true,
			   	minDate: moment().subtract(3, 'month'),
			   	maxDate: moment(),
			   	opens: "left"
				}, callback);
			</script>
			
			<script language="javascript">
				/**********************************
				*					 EXPORT DATA
				**********************************/
				$("button#buttonExport" + <?php echo json_encode($machine); ?>).on('click',function(){
					// reference check
					var ref = $("select#selectRef" + <?php echo json_encode($machine); ?>).val();
					if(ref === "empty"){
						alert("Veuillez choisir la reference !");
					}
					else{
						// time treatment
						var period = $("span#dateRangeVal" + <?php echo json_encode($machine); ?>).text();
						var start = period.split("-")[0].trim();
						var end = period.split("-")[1].trim();
						
						start = moment(start, 'D/M/YYYY HH:mm');
						end = moment(end, 'D/M/YYYY HH:mm');
						
						start = start.format('YYYY-MM-DD HH:mm:ss.SSS');
						end = end.format('YYYY-MM-DD HH:mm:ss.SSS');
						
						// get data by ajax
						$.ajax({
							url: "getDataToExport.php",
							type: "POST",
							data: {
								ref: ref,
								startTime: start,
								endTime: end,
								machine: <?php echo json_encode($machine); ?>
							},
							dataType: "text",
							success: function(fileName){
								window.location.href = 'downloadExcel.php?fileName=' + fileName;
								console.log(fileName);
							}
						});
					}
				});
			</script>
		<?php } ?>
		
	</body>
</html>