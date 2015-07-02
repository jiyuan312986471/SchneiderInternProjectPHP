<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Slider Plugin -->
<script type='text/javascript' src="js/bootstrap-slider.js"></script>

<!-- Type Ahead -->
<script type='text/javascript' src="js/typeahead/bloodhound.js"></script>
<script type='text/javascript' src="js/typeahead/typeahead.bundle.js"></script>
<script type='text/javascript' src="js/typeahead/typeahead.jquery.js"></script>

<!-- Map JS -->
<script type='text/javascript' src="js/map.js"></script>

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
									<ul class="nav sidebar-nav navbar-collapse" style="padding: 0px">
										<?php foreach($listMachine as $machine){ ?>
														<li class="pull-left" style="width: 100%">
															<a href="#confMachinePage<?php echo $machine; ?>" id="confMachineMenu<?php echo $machine; ?>" data-toggle="tab">
																<i class="fa fa-wrench fa-fw"></i>
																<?php echo $machine; ?>
																<i class="fa fa-angle-right fa-fw pull-right"></i>
															</a>
														</li>
										<?php	} ?>
														<li class="pull-left" style="width: 100%">
															<a href="#confMachinePageAjout" id="confMachineMenuAjout" data-toggle="tab">
																<i class="fa fa-plus fa-fw"></i>
																Ajouter
																<i class="fa fa-angle-right fa-fw pull-right"></i>
															</a>
														</li>
									</ul>
								</nav>
								
								<!-- Conf Page machine -->
								<div class="tab-content col-sm-10" style="padding: 0px">
									<?php foreach($listMachineInfo as $machine => $machineInfo){ ?>
													<div role="tabpanel" class="tab-pane fade" id="confMachinePage<?php echo $machine; ?>">
														<div class="panel panel-default" style="margin: 0px">
															<div class="panel-heading">
																<h3>Machine <?php echo $machine; ?></h3>
															</div>
															<form>
																<!-- Nom Machine -->
																<div class="panel-body">
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<label class="col-sm-12">Nom</label>
																	</div>
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																    <div class="col-sm-offset-1 col-sm-7" style="padding: 0px">
																      <input id="inputNameMachine<?php echo $machine; ?>" type="text" class="form-control" placeholder="Nouveau Nom..." 
																      	value="<?php echo $machineInfo["Nom"]; ?>" disabled >
																    </div>
																    <button type="button" class="btn btn-sm btn-primary col-sm-3 pull-right" onclick="activeNameSetting('<?php echo $machine; ?>')">
																    	Modifier
																    </button>
																  </div>
																</div>
																
																<hr style="margin-top: 2px; margin-bottom: 2px">
																
																<!-- Seuil Pourc -->
																<div class="panel-body">
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<label class="col-sm-12">Seuil du Graph Pourcentage</label>
																	</div>
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																	  <input id="sliderSeuilPourc<?php echo $machine; ?>" type="text" data-slider-id="slider<?php echo $machine; ?>" 
																	    data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="<?php echo $machineInfo["Seuil"]; ?>" data-slider-enabled="false" />
																	  <span class="col-sm-3" id="currentSliderValLabel">Current Value: 
																	  	<span id="sliderVal<?php echo $machine; ?>" style="color: #428bca"><?php echo $machineInfo["Seuil"]; ?></span>
																	  </span>
																	  <button type="button" class="btn btn-sm btn-primary col-sm-3 pull-right" onclick="activeSeuilSetting('<?php echo $machine; ?>')">
																    	Modifier
																    </button>
																  </div>
																</div>
																
																<hr style="margin-top: 2px; margin-bottom: 2px">
																
																<!-- Type Produit -->
																<div class="panel-body">
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<label class="col-sm-12">Type Produit</label>
																	</div>
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<div class="col-sm-offset-1 col-sm-7" style="padding: 0px">
																			<select id="selectTypeProduit<?php echo $machine; ?>" class="form-control" disabled>
																				<?php 
																					foreach($listTypeProduit as $type){ 
																						if($machineInfo["TypeProduit"] == $type){
																				?>
																							<option selected><?php echo $type; ?></option>
																				<?php
																						}
																						else {
																				?>
																							<option><?php echo $type; ?></option>
																				<?php
																						}
																					}
																				?>
																			</select>
																		</div>
																		<button type="button" class="btn btn-sm btn-primary col-sm-3 pull-right" onclick="activeTypeProduitSetting('<?php echo $machine; ?>')">
																    	Modifier
																    </button>
																	</div>
																</div>
																
																<hr style="margin-top: 2px; margin-bottom: 2px">
																
																<!-- Status -->
																<div class="panel-body">
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<label class="col-sm-12">Machine Status</label>
																	</div>
																	<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
																		<?php if($machineInfo["Status"] == "Active"){ ?>
																						<button type="button" class="btn btn-success btn-lg col-sm-offset-1 col-sm-11" id="status<?php echo $machine; ?>" 
																							onclick="toggleMachineStatus('<?php echo $machine; ?>')">
																							Active
																						</button>
																		<?php } else { ?>
																						<button type="button" class="btn btn-danger btn-lg col-sm-offset-1 col-sm-11" id="status<?php echo $machine; ?>" 
																							onclick="toggleMachineStatus('<?php echo $machine; ?>')">
																							Disabled
																						</button>
																		<?php } ?>
																	</div>
																</div>
																
																<div class="panel-footer">
																	<button type="submit" class="btn btn-primary">Enregistrer</button>
																	<button type="button" class="btn btn-primary" onclick="resetMachineSetting(
																																													'<?php echo $machine; ?>',
																																													'<?php echo $machineInfo["Nom"]; ?>',
																																													<?php echo $machineInfo["Seuil"]; ?>,
																																													'<?php echo $machineInfo["TypeProduit"]; ?>',
																																													'<?php echo $machineInfo["Status"]; ?>'
																																												)">
																		Annuler
																	</button>
																</div>
															</form>
														</div>
													</div>
													
													<script language="javascript">
														// create slider
														$("#sliderSeuilPourc" + <?php echo json_encode($machine); ?>).slider();
														
														$("#sliderSeuilPourc" + <?php echo json_encode($machine); ?>).on("slide", function(slideEvt) {
															$("#sliderVal" + <?php echo json_encode($machine); ?>).text(slideEvt.value);
														});
														
														// set slider width and offset
														$("div.slider#slider" + <?php echo json_encode($machine); ?>).addClass("col-sm-offset-1 col-sm-5");
													</script>
													
									<?php } ?>
									
									<!-- New Machine -->
									<div role="tabpanel" class="tab-pane fade" id="confMachinePageAjout">
										<div class="panel panel-default" style="margin: 0px">
											<div class="panel-heading">
												<h3>Ajouter une Machine</h3>
											</div>
											<form>
												<!-- ID Machine -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-12">ID</label>
													</div>
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<div class="col-sm-offset-1 col-sm-8" style="padding: 0px">
															<input id="inputIdNewMachine" type="text" class="form-control" placeholder="ID de la machine...">
														</div>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Nom Machine -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-12">Nom</label>
													</div>
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<div class="col-sm-offset-1 col-sm-8" style="padding: 0px">
															<input id="inputNameNewMachine" type="text" class="form-control" placeholder="Nom de la machine...">
														</div>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Seuil Pourc -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-12">Seuil du Graph Pourcentage</label>
													</div>
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<input id="sliderSeuilPourcNewMachine" type="text" data-slider-id="sliderNewMachine" 
															data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="5" />
														<span class="col-sm-3" id="currentSliderValLabel">Current Value: 
															<span id="sliderValNewMachine" style="color: #428bca">5</span>
														</span>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Type Produit -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-12">Type Produit</label>
													</div>
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<div class="col-sm-offset-1 col-sm-7" style="padding: 0px">
															<select class="form-control">
																<?php foreach($listTypeProduit as $type){ ?>
																				<option><?php echo $type; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Status -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-12">Machine Status</label>
													</div>
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<button type="button" class="btn btn-success btn-lg col-sm-offset-1 col-sm-11" id="statusNewMachine" 
															onclick="toggleMachineStatus('NewMachine')">
															Active
														</button>
													</div>
												</div>
												
												<div class="panel-footer">
													<button type="submit" class="btn btn-primary">Enregistrer</button>
													<button type="button" class="btn btn-primary" onclick="resetMachineSetting('NewMachine')">Annuler</button>
												</div>
											</form>
										</div>
									</div>
									
									<script language="javascript">
										// create slider
										$("#sliderSeuilPourcNewMachine").slider();
										
										$("#sliderSeuilPourcNewMachine").on("slide", function(slideEvt){
											$("#sliderValNewMachine").text(slideEvt.value);
										});
										
										// set slider width and offset
										$("div.slider#sliderNewMachine").addClass("col-sm-offset-1 col-sm-8");
									</script>
									
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
				  	<div class="row">
				  		<div class="alert alert-info col-sm-12" style="margin: 0px">
						    <input id="sliderRefreshTime" type="text" data-slider-id="sliderRefresh" data-slider-min="8" data-slider-max="60" data-slider-step="1" data-slider-value="8" />
						    <span class="col-sm-3" id="currentRefreshTime">
						    	Refresh Time: 
						    	<span id="sliderRefreshVal">8</span>
						    	s
						    </span>
						    <input type="submit" class="btn btn-sm btn-primary col-sm-2" value="Enregistrer" />
					    </div>
				    </div>
				    
				    <script language="javascript">
				    	// create slider
				    	$("#sliderRefreshTime").slider({
				    			formatter: function(value) {
				    				return 'Current value: ' + value;
				    			}
				    	});
				    	
				    	// set slider width and offset
				    	$("div.slider#sliderRefresh").addClass("col-sm-offset-1 col-sm-5");
				    	
				    	// sliderRefresh Listener
				    	$("#sliderRefreshTime").on("slide", function(slideEvt) {
								$("#sliderRefreshVal").text(slideEvt.value);
							});
				    </script>
				    
				  </div>
				</div>
				
				<!-- DEFAUT -->
				<button type="button" class="btn btn-outline btn-primary btn-lg btn-block" data-toggle="collapse" data-target="#collapseConfigDefaut" 
					aria-expanded="false" aria-controls="collapseExample">
					Defaut
				</button>
				<div class="collapse" id="collapseConfigDefaut">
				  <div class="well" style="padding: 0px 0px 5px 0px">
				  	<!-- content -->
				    <div class="row">
							<div class="col-sm-12">
								<!-- menu defaut -->
								<nav class="navbar col-sm-2" style="padding: 0px; margin: 0px">
									<ul class="nav sidebar-nav navbar-collapse" style="padding: 0px">
										<li class="pull-left" style="width: 100%">
											<a href="#confDefautPageModif" id="confDefautMenuModif" data-toggle="tab">
												<i class="fa fa-wrench fa-fw"></i>
												Modifier
												<i class="fa fa-angle-right fa-fw pull-right"></i>
											</a>
										</li>
										<li class="pull-left" style="width: 100%">
											<a href="#confDefautPageAjout" id="confDefautMenuAjout" data-toggle="tab">
												<i class="fa fa-plus fa-fw"></i>
												Ajouter
												<i class="fa fa-angle-right fa-fw pull-right"></i>
											</a>
										</li>
									</ul>
								</nav>
								
								<!-- content defaut -->
								<div class="tab-content col-sm-10" style="padding: 0px">
									
									<!-- Conf Defaut Page Modif -->
									<div role="tabpanel" class="tab-pane fade" id="confDefautPageModif">
										<div class="panel panel-default" style="margin: 0px">
											<div class="panel-heading">
												<h3>Modifier un Defaut</h3>
											</div>
											<!-- Recherche -->
											<div class="panel-body">
												<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
													<label class="col-sm-3">
														<div class="pull-right">Recherche du Code :</div>
													</label>
													<div class="col-sm-8">
														<div class="input-group">
															<input type="text" class="typeahead" id="inputCode" class="form-control" placeholder="Saisissez le code defaut..."
																data-provide="typeahead">
															<div class="input-group-btn">
																<button id="researchCode" class="btn btn-primary">Rechercher</button>
															</div>
														</div>
													</div>
												</div>
											</div>
											
											<form id="formModifDefaut" action="#" name="formModifDefaut">
												<span id="defautInfo" style="display: none">
													<hr style="margin-top: 2px; margin-bottom: 2px">
													
													<!-- Code -->
													<div class="panel-body">
														<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
															<label class="col-sm-3">
																<div class="pull-right">Code Defaut :</div>
															</label>
															<div class="col-sm-6">
																<input id="codeDefautModif" type="text" class="form-control" placeholder="Code Defaut...">
															</div>
														</div>
													</div>
													
													<hr style="margin-top: 2px; margin-bottom: 2px">
													
													<!-- Nom -->
													<div class="panel-body">
														<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
															<label class="col-sm-3">
																<div class="pull-right">Nom Defaut :</div>
															</label>
															<div class="col-sm-6">
																<input id="nomDefautModif" type="text" class="form-control" placeholder="Nom du Defaut...">
															</div>
														</div>
													</div>
													
													<hr style="margin-top: 2px; margin-bottom: 2px">
													
													<!-- Nom Abrege -->
													<div class="panel-body">
														<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
															<label class="col-sm-3">
																<div class="pull-right">Nom Defaut Abrege :</div>
															</label>
															<div class="col-sm-6">
																<input id="nomAbregeDefautModif" type="text" class="form-control" placeholder="Nom du Defaut Abrege...">
															</div>
														</div>
													</div>
													
													<hr style="margin-top: 2px; margin-bottom: 2px">
													
													<!-- Type Produit -->
													<div class="panel-body">
														<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
															<label class="col-sm-3">
																<div class="pull-right">Type Produit :</div>
															</label>
															<div class="col-sm-6">
																<select id="typeProduitDefautModif" class="form-control">
																	<?php foreach($listTypeProduit as $type){ ?>
																					<option><?php echo $type; ?></option>
																	<?php } ?>
																</select>
															</div>
														</div>
													</div>
												</span>
												
												<!-- Panel Footer -->
												<div class="panel-footer">
													<input type="submit" class="btn btn-primary" value="Enregistrer">
													<input type="reset" id="confDefautCancel" class="btn btn-primary" value="Annuler">
												</div>
											</form>
										</div>
									</div>
									
									<!-- Conf Defaut Page Ajout -->
									<div role="tabpanel" class="tab-pane fade" id="confDefautPageAjout">
										<div class="panel panel-default" style="margin: 0px">
											<div class="panel-heading">
												<h3>Ajouter un defaut</h3>
											</div>
											
											<form id="formAjoutDefaut" action="#" name="formAjoutDefaut">
												<!-- Code -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-3">
															<div class="pull-right">Code Defaut :</div>
														</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" placeholder="Code Defaut...">
														</div>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Nom -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-3">
															<div class="pull-right">Nom Defaut :</div>
														</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" placeholder="Nom du Defaut...">
														</div>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Nom Abrege -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-3">
															<div class="pull-right">Nom Defaut Abrege :</div>
														</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" placeholder="Nom du Defaut Abrege...">
														</div>
													</div>
												</div>
												
												<hr style="margin-top: 2px; margin-bottom: 2px">
												
												<!-- Status -->
												<div class="panel-body">
													<div class="row" style="margin-left: -10px; margin-right: 0px; margin-bottom: 5px">
														<label class="col-sm-3">
															<div class="pull-right">Status :</div>
														</label>
														<div class="col-sm-6">
															<select class="form-control">
																<?php foreach($listTypeProduit as $type){ ?>
																				<option><?php echo $type; ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
												
												<!-- Panel Footer -->
												<div class="panel-footer">
													<button type="submit" class="btn btn-primary">Enregistrer</button>
													<button type="reset" class="btn btn-primary">Annuler</button>
												</div>
											</form>
										</div>
									</div>
								</div>
								
							</div>
						</div>
								
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

<script language="javascript">
	// activate machine name setting
	function activeNameSetting(machine){
		$("input#inputNameMachine" + machine).removeAttr("disabled");
	}
	
	// activate machine seuil setting
	function activeSeuilSetting(machine){
		var divSlider = $("#slider" + machine);
		if( divSlider.hasClass("slider-disabled") ){
			$("#sliderSeuilPourc" + machine).slider("enable");
		}
	}
	
	// activate machine type produit setting
	function activeTypeProduitSetting(machine){
		$("select#selectTypeProduit" + machine).removeAttr("disabled");
	}
	
	// activate and disactivate machine status
	function toggleMachineStatus(machine){
		var btn = $("button#status" + machine);
		if ( btn.hasClass("btn-danger") ){
			btn.removeClass("btn-danger");
			btn.addClass("btn-success");
			btn.text("Active");
		}
		else if ( btn.hasClass("btn-success") ){
			btn.removeClass("btn-success");
			btn.addClass("btn-danger");
			btn.text("Disabled");
		}
	}
	
	// reset current machine setting page
	function resetMachineSetting(machine, nom, seuil, typeProduit, status){
		if(machine != "NewMachine"){
			// reset name input
			$("input#inputNameMachine" + machine).val(nom);
			
			// disable name input
			$("input#inputNameMachine" + machine).attr("disabled", "disabled");
			
			// reset seuil slider
			$("#sliderSeuilPourc" + machine).slider('setValue', seuil);
			
			// disable seuil slider
			$("#sliderSeuilPourc" + machine).slider("disable");
			
			// reset value display
			$("#sliderVal" + machine).text(seuil);
			
			// reset status
			if(status == "Active"){
				$("button#status" + machine).removeClass("btn-danger");
				$("button#status" + machine).addClass("btn-success");
				$("button#status" + machine).text("Active");
			}
			else {
				$("button#status" + machine).removeClass("btn-success");
				$("button#status" + machine).addClass("btn-danger");
				$("button#status" + machine).text("Disabled");
			}
			
			// reset type produit
			var listType = $("select#selectTypeProduit" + machine).children("option");
			for(var i in listType){
				if($(listType[i]).text() == typeProduit){
					$(listType[i]).attr("selected", "selected");
				}
				else{
					$(listType[i]).removeAttr("selected");
				}
			}
			
			// disable type produit
			$("select#selectTypeProduit" + machine).attr("disabled", "disabled");
		}
		else {
			// clear ID
			$("input#inputId" + machine).val("");
			
			// clear name
			$("input#inputName" + machine).val("");
			
			// reset slider
			$("#sliderSeuilPourc" + machine).slider('setValue', 5);
			$("#sliderVal" + machine).text(5);
			
			// reset status
			$("button#status" + machine).removeClass("btn-danger");
			$("button#status" + machine).addClass("btn-success");
			$("button#status" + machine).text("Active");
		}
	}
	
	// search defaut info and show 
	$("button#researchCode").click(function (){
		// search defaut info by code
		var code = $("input#inputCode").val();
		getDefautInfo(code);
		
		// show info
		$("span#defautInfo").css("display","");
	})
	
	// hide defaut info page
	$("input#confDefautCancel").click(function (){
		$("span#defautInfo").css("display","none");
	})
	
	// popover for ajout machine's ID input
	$("input#inputIdNewMachine").focus(function (){
		$("input#inputIdNewMachine")
				.popover({
					"placement": "top",
					"content": "Chaque machine a un ID unique"
				})
				.blur(function () {
            $(this).popover('hide');
        });
	})
</script>

<script language="javascript">
	/********************************/
	/* 				Auto Complete 				*/
	/********************************/
	// preparer list code defaut
	var listCodeDefaut = eval(<?php echo json_encode($listCodeDefaut); ?>);
  
  var codes = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  local: listCodeDefaut
	});
  
  $("input#inputCode").typeahead({
  	hint: true,
  	highlight: true,
  	minLength: 1
  },
  {
  	source: codes
  });
</script>

<script language="javascript">
	/********************************/
	/* 			Code Defaut Search 			*/
	/********************************/	
	function getDefautInfo(codeDefaut){
		// get defaut
		var defauts = eval(<?php echo json_encode($listDefautConfig); ?>);
		var defautInfo = defauts[codeDefaut];
		
		// get infos
		var nom 				= defautInfo["Nom"];
		var nomAbrege 	= defautInfo["NomAbrege"];
		var typeProduit = defautInfo["TypeProduit"];
		
		// display info on defaut modif page
		$("input#codeDefautModif").val(codeDefaut);
		$("input#nomDefautModif").val(nom);
		$("input#nomAbregeDefautModif").val(nomAbrege);
		
		// display type produit
		var listType = $("select#typeProduitDefautModif").children("option");
		for(var i in listType){
			if($(listType[i]).text() == typeProduit){
				$(listType[i]).attr("selected", "selected");
			}
			else{
				$(listType[i]).removeAttr("selected");
			}
		}
	}	
</script>