<?php
	
	session_start();
	
	include 'include/util.php';
  
  include 'conn.php';
  
  include 'include/listMachine.php';
  include 'include/listTypeProduit.php';
  include 'include/listDefaut.php';
  
  // get machine
  $machineSelected = $_GET['machine'];
  
  if(isset($_SESSION["refreshTime"])){
		$refreshTime = $_SESSION["refreshTime"];
	}
	else{
		$refreshTime = 8;
	}
	
?>


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
			
			<!-- contenu -->
			<div id="page-wrapper">
				
				<!-- Machine name and export button -->
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Machine <?php echo $machineSelected; ?>
							<button class="btn btn-primary btn-lg pull-right" id="export<?php echo $machineSelected; ?>" style="margin-top: -3px" data-toggle="modal"
								data-target="#modalExport<?php echo $machineSelected; ?>">
								<i class="fa fa-database fa-fw"></i>
								Exporter <?php echo $machineSelected; ?>
							</button>
						</h1>
					</div>
				</div>
				
				<!-- Graphs -->
				<div class="row">
					<div class="row" id="graphMachine<?php echo $machineSelected; ?>">
						
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-success">
										<div class="panel-heading">
											<h4>Pourcentage Defauts <?php echo $machineSelected; ?></h4>
										</div>
										<div class="panel-body">
											<div id="pourcDefaut<?php echo $machineSelected; ?>"></div>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="panel panel-success">
										<div class="panel-heading">
											<h4>Pareto des Defauts <?php echo $machineSelected; ?></h4>
										</div>
										<div class="panel-body">
											<div id="paretoDefaut<?php echo $machineSelected; ?>"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				
			</div>
		</div>
		
		<!-- Common Script Src Pool -->
		<?php include 'include/scripts.php'; ?>
	    
	  <script type="text/javascript">
	  	(function($){
		  	// refresh
		  	var time = <?php echo $refreshTime; ?> * 1000;
		  	var graphPourc;
		  	var graphPareto;
		  	refreshMachine(<?php echo json_encode($machineSelected); ?>, graphPourc, graphPareto, time);
	  	})(jQuery);
	  </script>
		
		<!-- Modal Exporter -->
		<?php $listRef = getListRef($conn); ?>
		<div class="modal fade" id="modalExport<?php echo $machineSelected; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					
					<!-- Modal Header -->
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Exporter <?php echo $machineSelected; ?></h4>
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
									<select id="selectRef<?php echo $machineSelected; ?>" class="form-control">
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
									<div id="dateRange<?php echo $machineSelected; ?>" class="form-control" style="cursor: pointer">
										<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
										<span id="dateRangeVal<?php echo $machineSelected; ?>" class="pull-right"></span>
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
							<button id="buttonExport<?php echo $machineSelected; ?>" type="button" class="btn btn-primary">Exporter</button>
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
	    	$("span#dateRangeVal" + <?php echo json_encode($machineSelected); ?>).html(start.format('D/M/YYYY HH:mm') + ' - ' + end.format('D/M/YYYY HH:mm'));
	    }
	    callback(moment().subtract(7, 'days'), moment());
	    	
	    $("#dateRange" + <?php echo json_encode($machineSelected); ?>).daterangepicker({
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
			$("button#buttonExport" + <?php echo json_encode($machineSelected); ?>).on('click',function(){
				// reference check
				var ref = $("select#selectRef" + <?php echo json_encode($machineSelected); ?>).val();
				if(ref === "empty"){
					alert("Veuillez choisir la reference !");
				}
				else{
					// time treatment
					var period = $("span#dateRangeVal" + <?php echo json_encode($machineSelected); ?>).text();
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
							machine: <?php echo json_encode($machineSelected); ?>
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
		
		<!-- Modal 24h Graph -->
		<div class="modal fade" id="modal24h<?php echo $machineSelected; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">24h Graph pour <?php echo $machineSelected; ?> au <span id="date24hGraph<?php echo $machineSelected; ?>"></span></h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div id="graph24h<?php echo $machineSelected; ?>"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	</body>

</html>