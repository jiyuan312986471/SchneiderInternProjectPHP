<!-- Slider Plugin -->
<link href="css/bootstrap-slider.css" rel="stylesheet">
<script type='text/javascript' src="js/bootstrap-slider.js"></script>

<!-- Modal Configer -->
<div class="modal fade bs-example-modal-lg" id="modalConfig" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			
			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Configuration</h4>
			</div>
			
			<!-- Modal Body -->
			<div class="modal-body">
				<!-- MACHINE -->
				<button type="button" class="btn btn-outline btn-primary btn-lg btn-block" data-toggle="collapse" data-target="#collapseConfigMachine" 
					aria-expanded="false" aria-controls="collapseExample">
					Machine
				</button>
				<div class="collapse" id="collapseConfigMachine">
					<div class="well" style="padding: 0px 0px 5px 0px">
						<div class="row">
							<div class="col-sm-12">
								<!-- menu machine -->
								<nav class="navbar col-sm-2" style="padding: 0px; margin: 0px">
									<ul class="nav sidebar-nav navbar-collapse" style="padding: 0px" id="side-menu">
										<?php foreach($listMachine as $machine){ ?>
														<li class="pull-left" style="width: 100%">
															<a href="#confMachinePage<?php echo $machine; ?>" id="confMachineMenu<?php echo $machine; ?>" data-toggle="tab">
																<i class="fa fa-wrench fa-fw"></i>
																<?php echo $machine; ?>
																<i class="fa fa-angle-right fa-fw pull-right"></i>
															</a>
														</li>
										<?php	} ?>
									</ul>
								</nav>
								<!-- Conf Page machine -->
								<div class="tab-content col-sm-10" style="padding: 0px">
									<?php foreach($listMachine as $machine){ ?>
													<div role="tabpanel" class="tab-pane" id="confMachinePage<?php echo $machine; ?>">
														<div class="panel panel-default">
															<div class="panel-heading">
																Machine <?php echo $machine; ?>
															</div>
															<form>
																<!-- Nom Machine -->
																<div class="panel-body">
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<label class="col-sm-12">Nom</label>
																	</div>
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																    <div class="col-sm-offset-1 col-sm-7" style="padding: 0px">
																      fdafdasfsadfasdfadsf
																    </div>
																    <button class="btn btn-sm btn-primary col-sm-3 pull-right">Modifier</button>
																  </div>
																  <div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																  	<input type="text" class="col-sm-offset-1 col-sm-7" style="padding: 1px" placeholder="Nouveau Nom...">
																  	<input type="submit" class="btn btn-sm btn-primary col-sm-3 pull-right" value="Enregistrer">
																  </div>
																</div>
																
																<hr style="margin-top: 2px; margin-bottom: 2px">
																
																<!-- Seuil Pourc -->
																<div class="panel-body">
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<label class="col-sm-12">Seuil du Graph Pourcentage</label>
																	</div>
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																    <div class="col-sm-offset-1 col-sm-7" style="padding: 0px">
																    	<!-- Bootstrap Slider: Remain to finish -->
																      <input id="sliderSeuilPourc" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="5" data-slider-enabled="false"/>
																			<input id="sliderSeuilPourc-enabled" type="checkbox"/> Enabled
																			<script language="javascript">
																				// Without JQuery
																				var slider = new Slider("#sliderSeuilPourc");
																				
																				$("#sliderSeuilPourc-enabled").click(function() {
																					if(this.checked) {
																						// Without JQuery
																						slider.enable();
																					}
																					else {
																						// Without JQuery
																						slider.disable();
																					}
																				});
																			</script>
																    </div>
																    <button class="btn btn-sm btn-primary col-sm-3 pull-right">Modifier</button>
																  </div>
																</div>
																<div class="panel-footer">
																	<button type="submit" class="btn btn-primary">Enregistrer</button>
																</div>
															</form>
														</div>
													</div>
									<?php } ?>
							  </div>
					  
					 		</div>
					 	</div>
					</div>
				</div>
				
				<!-- REFRESH FREQUENCY -->
				<button type="button" class="btn btn-outline btn-primary btn-lg btn-block" data-toggle="collapse" data-target="#collapseConfigFrequence" 
					aria-expanded="false" aria-controls="collapseExample">
					Frequence d'actualisation
				</button>
				<div class="collapse" id="collapseConfigFrequence">
				  <div class="well">
				  	<!-- content -->
				    collapseConfigFrequence
				  </div>
				</div>
				
				<!-- DEFAUT -->
				<button type="button" class="btn btn-outline btn-primary btn-lg btn-block" data-toggle="collapse" data-target="#collapseConfigDefaut" 
					aria-expanded="false" aria-controls="collapseExample">
					Defaut
				</button>
				<div class="collapse" id="collapseConfigDefaut">
				  <div class="well">
				  	<!-- content -->
				    collapseConfigDefaut
				  </div>
				</div>
				
			</div>
			
			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">Valider</button>
			</div>
		</div>
	</div>
</div>