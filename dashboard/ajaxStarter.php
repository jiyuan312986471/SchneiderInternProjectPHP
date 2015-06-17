<?php

	$result = "";
	
	$machine = $_GET['machine'];
	$option  = $_GET['option'];
	
	// PANEL-HEADING: machine name
	if($option != "both") {
		$result .= "<div class=\"panel-heading\">";
		$result .= 		"Machine ".$machine;
		$result .=		"<div class=\"btn-group col-md-offset-7\" data-toggle=\"buttons\">";
		if($option == "pareto") {
			$result .= 		"<label class=\"btn btn-primary\" id=\"Pourcentage".$machine."\">";
			$result .= 			"<input type=\"radio\" name=\"options\" autocomplete=\"off\"> Pourcentage";
			$result .= 		"</label>";
			$result .= 		"<label class=\"btn btn-primary active\" id=\"Pareto".$machine."\">";
			$result .= 			"<input type=\"radio\" name=\"options\" autocomplete=\"off\"> Pareto";
			$result .= 		"</label>";
		}
		else if($option == "pourc") {
			$result .= 		"<label class=\"btn btn-primary active\" id=\"Pourcentage".$machine."\">";
			$result .= 			"<input type=\"radio\" name=\"options\" autocomplete=\"off\"> Pourcentage";
			$result .= 		"</label>";
			$result .= 		"<label class=\"btn btn-primary\" id=\"Pareto".$machine."\">";
			$result .= 			"<input type=\"radio\" name=\"options\" autocomplete=\"off\"> Pareto";
			$result .= 		"</label>";
		}
		$result .=		"</div>";
		$result .= "</div>";
	}
	
	// PANEL-BODY: graphs
	$result .= "<div class=\"panel-body\">";
	$result .= 		"<div class=\"row\">";
	if($option == "pourc") {
		// graphPourc
		$result .= 		"<div class=\"col-lg-12\">";
		$result .= 			"<div class=\"panel panel-default\">";
		$result .= 				"<div class=\"panel-heading\">";
		$result .= 					"Pourcentage Defauts ".$machine;
		$result .= 				"</div>";
		$result .= 				"<div class=\"panel-body\">";
		$result .= 					"<div id=\"pourcDefaut".$machine."\"></div>";
		$result .= 				"</div>";
		$result .= 			"</div>";
		$result .= 		"</div>";
	}
	else if($option == "pareto") {
		// graphPareto
		$result .= 		"<div class=\"col-lg-12\">";
		$result .= 			"<div class=\"panel panel-default\">";
		$result .= 				"<div class=\"panel-heading\">";
		$result .= 					"Pareto des Defauts ".$machine;
		$result .= 				"</div>";
		$result .= 				"<div class=\"panel-body\">";
		$result .= 					"<div id=\"paretoDefaut".$machine."\"></div>";
		$result .= 				"</div>";
		$result .= 			"</div>";
		$result .= 		"</div>";
	}
	else if($option == "both") {
		// graphPourc
		$result .= 		"<div class=\"col-lg-12\">";
		$result .= 			"<div class=\"panel panel-default\">";
		$result .= 				"<div class=\"panel-heading\">";
		$result .= 					"Pourcentage Defauts ".$machine;
		$result .= 				"</div>";
		$result .= 				"<div class=\"panel-body\">";
		$result .= 					"<div id=\"pourcDefaut".$machine."\"></div>";
		$result .= 				"</div>";
		$result .= 			"</div>";
		$result .= 		"</div>";
		
		// graphPareto
		$result .= 		"<div class=\"col-lg-12\">";
		$result .= 			"<div class=\"panel panel-default\">";
		$result .= 				"<div class=\"panel-heading\">";
		$result .= 					"Pareto des Defauts ".$machine;
		$result .= 				"</div>";
		$result .= 				"<div class=\"panel-body\">";
		$result .= 					"<div id=\"paretoDefaut".$machine."\"></div>";
		$result .= 				"</div>";
		$result .= 			"</div>";
		$result .= 		"</div>";
	}
	$result .= 		"</div>";
	$result .= "</div>";
	
	// PANEL-FOOTER: export
	if($option != "both") {
		$result .= "<div class=\"panel-footer\">";
		$result .= 		"<button class=\"btn btn-primary\" id=\"export".$machine."\">";
		$result .=			"<i class=\"fa fa-database fa-fw\"></i>";
		$result .=			" Exporter ".$machine;
		$result .=		"</button>";
		$result .= "</div>";
	}
	
	// return HTML part to AJAX
	echo $result;
	
?>



