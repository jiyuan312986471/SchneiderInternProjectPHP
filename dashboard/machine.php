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
							<button class="btn btn-primary btn-lg pull-right" id="export<?php echo $machineSelected; ?>" style="margin-top: -3px" data-toggle="modal" data-target="#modalExport">
								<i class="fa fa-database fa-fw"></i>
								Exporter <?php echo $machineSelected; ?>
							</button>
						</h1>
					</div>
				</div>
				
				<!-- Graphs -->
				<div class="row">
					<div class="row" id="graphMachine<?php echo $machineSelected; ?>"></div>
				</div>
				
			</div>
		</div>
		
		<!-- Common Script Src Pool -->
		<?php include 'include/scripts.php'; ?>
	    
	  <script type="text/javascript">
	  	// refresh every 8s
	  	var time = <?php echo $refreshTime; ?> * 1000;
		  setInterval(refreshMachine(<?php echo json_encode($machineSelected); ?>), time);
	  </script>
		
		<!-- Modal Exporter -->
		<div class="modal fade" id="modalExport<?php echo $machineSelected; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Exporter <?php echo $machineSelected; ?></h4>
					</div>
					<div class="modal-body">
						...
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary">Exporter</button>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Modal 24h Graph -->
		<div class="modal fade" id="modal24h<?php echo $machineSelected; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
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