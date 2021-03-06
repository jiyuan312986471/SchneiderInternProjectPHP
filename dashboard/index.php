<?php
	
	session_start();

	include_once 'include/util.php';
	
	include 'conn.php';
	
	include 'include/listMachine.php';
	include 'include/listTypeProduit.php';
	include 'include/listDefaut.php';
	
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
		sscanf(nbdefaut($conn, $listMachine[$i]),  "%d %f",$paraMachine['nb'][$i], $paraMachine['pourc'][$i]);
	}
	
	$sum = 0;
	$sumdefaut = 0;
	for ($i = 0; $i < $nbMachine; $i++) {
		$sum = $paraMachine['nb'][$i] + $sum;
		$sumdefaut = $paraMachine['nb'][$i] * $paraMachine['pourc'][$i] + $sumdefaut;
	}
	
	if($sum == 0) {
		$nombre = 0;
	}
	else {
		$nombre = round($sumdefaut/$sum,2);
	}
	
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
				
				<!-- Three indices -->
				<div class="row">
					<div class="col-lg-12">
						<div class="page-header">
							<div class="row">
								
								<!-- Pourcentage Defaut -->
								<div class="col-md-4">
									<div class="panel panel-primary">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-comments fa-5x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<div class="huge">
														<?php echo $nombre."%"; ?>
													</div>
													<div>Pourcentage Défaut</div>
												</div>
											</div>
										</div>
										<a href="#">
											<div class="panel-footer">
												<span class="pull-left">Voir</span>
												<span class="pull-right">
													<i class="fa fa-arrow-circle-right"></i>
												</span>
												<div class="clearfix"></div>
											</div>
										</a>
									</div>
								</div>
								
								<!-- QG Graphique -->
								<div class="col-md-4">
									<div class="panel panel-green">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-tasks fa-5x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<div class="huge"><?php echo $nbMachine; ?></div>
													<div>QG Graphique</div>
												</div>
											</div>
										</div>
										<a href="machineAll.php">
											<div class="panel-footer">
												<span class="pull-left">Voir</span>
												<span class="pull-right">
													<i class="fa fa-arrow-circle-right"></i>
												</span>
												<div class="clearfix"></div>
											</div>
										</a>
									</div>
								</div>
								
								<!-- Alertes -->
								<div class="col-md-4">
									<div class="panel panel-red">
										<div class="panel-heading">
											<div class="row">
												<div class="col-xs-3">
													<i class="fa fa-support fa-5x"></i>
												</div>
												<div class="col-xs-9 text-right">
													<div class="huge">
														<?php
															if(isset($Nbalert)){
																echo $Nbalert;
															}
															else {
																echo 0;
															}
														?>
													</div>
													<div>Alertes</div>
												</div>
											</div>
										</div>
										<a href="#">
											<div class="panel-footer">
												<span class="pull-left">Voir</span>
												<span class="pull-right">
													<i class="fa fa-arrow-circle-right"></i>
												</span>
												<div class="clearfix"></div>
											</div>
										</a>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				
				<!-- corps -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4>Pourcentage Défauts Usine</h4>
							</div>
							<div class="panel-body">
								<div id="pourcUsine"></div>
							</div>
							<div class="panel-footer">
								<!-- Modal Exporter Trigger -->
								<button type="button" class="btn btn-primary" id="exportAll" data-toggle="modal" data-target="#modalExportAll">
									<i class="fa fa-database fa-fw"></i>
									Exporter
								</button>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
		<!-- Common Script Src Pool -->
		<?php include 'include/scripts.php'; ?>
		
		<script language="javascript">
			(function($){
				// refresh
				var time = <?php echo $refreshTime; ?> * 1000;
				var graphPourc;
				refreshIndex(graphPourc, time);
			})(jQuery);
		</script>
		
		
		<!-- Modal Exporter -->
		<?php $listRef = getListRef($conn); ?>
		<div class="modal fade" id="modalExportAll" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					
					<!-- Modal Header -->
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Exporter</h4>
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
									<select id="selectRefAll" class="form-control">
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
									<div id="dateRangeAll" class="form-control" style="cursor: pointer">
										<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
										<span id="dateRangeValAll" class="pull-right"></span>
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
							<button id="buttonExportAll" type="button" class="btn btn-primary">Exporter</button>
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
	    	$('span#dateRangeValAll').html(start.format('D/M/YYYY HH:mm') + ' - ' + end.format('D/M/YYYY HH:mm'));
	    }
	    callback(moment().subtract(7, 'days'), moment());
	    	
	    $('#dateRangeAll').daterangepicker({
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
			$("button#buttonExportAll").on('click',function(){
				// reference check
				var ref = $("select#selectRefAll").val();
				if(ref === "empty"){
					alert("Veuillez choisir la reference !");
				}
				else{
					// time treatment
					var period = $("span#dateRangeValAll").text();
					var start = period.split("-")[0].trim();
					var end = period.split("-")[1].trim();
					
					start = moment(start, 'D/M/YYYY HH:mm');
					end = moment(end, 'D/M/YYYY HH:mm');
					
					start = start.format('YYYY-MM-DD HH:mm:ss.SSS');
					end = end.format('YYYY-MM-DD HH:mm:ss.SSS');
					
					console.log("start getting data");
					
					// get data by ajax
					$.ajax({
						url: "getDataToExport.php",
						type: "POST",
						data: {
							ref: ref,
							startTime: start,
							endTime: end,
							machine: "All"
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
		<div class="modal fade" id="modal24hAll" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">24h Graph au <span id="date24hGraphAll"></span></h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-12">
								<div id="graph24hAll"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	</body>
</html>