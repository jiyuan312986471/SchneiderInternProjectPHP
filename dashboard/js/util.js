/*
*		START WITH
*/
String.prototype.startWith = function (str){
	if(str == null || str == "" || this.length == 0 || str.length > this.length)
	  return false;
	if(this.substr(0, str.length) == str)
	  return true;
	else
	  return false;
	return true;
};

/*
*		DRAW GRAPHS
*/
function drawPourcGraph(machine, graphPourc){
	new Morris.Line({
			// ID of the element in which to draw the chart.
			element: 'pourcDefaut' + machine,
			
			// Chart data records -- each entry in this array corresponds to a point on the chart.
			data: [
				{ nbr: graphPourc.jour[0], valeur: graphPourc.pourc[0] },
				{ nbr: graphPourc.jour[1], valeur: graphPourc.pourc[1] },
				{ nbr: graphPourc.jour[2], valeur: graphPourc.pourc[2] },
				{ nbr: graphPourc.jour[3], valeur: graphPourc.pourc[3] },
				{ nbr: graphPourc.jour[4], valeur: graphPourc.pourc[4] },
				{ nbr: graphPourc.jour[5], valeur: graphPourc.pourc[5] },
				{ nbr: graphPourc.jour[6], valeur: graphPourc.pourc[6] }
			],
			
			// The name of the data record attribute that contains x-values.
			xkey: 'nbr',
			
			// A list of names of data record attributes that contain y-values.
			ykeys: ['valeur'],
			
			// Labels for the ykeys -- will be displayed when you hover over the chart.
			labels: ['Pourcentage'],
			
			pointFillColors: ['#FF530D','#81530D','#BBD20D','#FF0000','#FF009D','#6F009D','#0953B4','#09DCB4','#046351','#E16351','#4C221C'],
			parseTime: false,
			hideHover: false,
	});
};

function drawParetoGraph(machine, listDefaut, listPareto){
	new Morris.Bar({
			// ID of the element in which to draw the chart.
			element: 'paretoDefaut' + machine,
			
			// Chart data records -- each entry in this array corresponds to a point on the chart.
			data: [
				{ pourcentage: listDefaut[0],  value: listPareto[0] },
				{ pourcentage: listDefaut[1],  value: listPareto[1] },
				{ pourcentage: listDefaut[2],  value: listPareto[2] },
				{ pourcentage: listDefaut[3],  value: listPareto[3] },
				{ pourcentage: listDefaut[4],  value: listPareto[4] },
				{ pourcentage: listDefaut[5],  value: listPareto[5] },
				{ pourcentage: listDefaut[6],  value: listPareto[6] },
				{ pourcentage: listDefaut[7],  value: listPareto[7] },
				{ pourcentage: listDefaut[8],  value: listPareto[8] },
				{ pourcentage: listDefaut[9],  value: listPareto[9] }
			],
			
			// The name of the data record attribute that contains x-values.
			xkey: 'pourcentage',
			
			// A list of names of data record attributes that contain y-values.
			ykeys: ['value'],
			
			// Labels for the ykeys -- will be displayed when you hover over the chart.
			labels: ['Pourcentage'],
		});
};

function drawGraph(machine, graphPourc, listDefaut, listPareto){
	// get label
	var idLabel = $("label.active").attr("id");
	
	// if pourcentage button selected
	if(idLabel.startWith("Pourcentage")) {
		// draw pourcentage graph
		drawPourcGraph(machine, graphPourc);
	}
	
	// if not
	else if(idLabel.startWith("Pareto")) {
		// draw pareto graph
		drawParetoGraph(machine, listDefaut, listPareto);
	}
};


/*
*		AJAX PREPARATION
*/
function createXMLHttpRequest() {
	var xmlHttp = null;
	if (window.XMLHttpRequest) {// code for all new browsers
		xmlHttp = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {// code for IE5 and IE6
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlHttp;
};

/*
*		AJAX STARTER
*/
function start(machine, option, graphPourc, listDefaut, listPareto){
	var xmlHttp = createXMLHttpRequest();
	var url = "ajaxStarter.php?machine=" + machine + "&option=" + option;
	xmlHttp.onreadystatechange = function(){ callbackStarter(xmlHttp, machine, graphPourc, listDefaut, listPareto, option) };
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
};

// Starter Callback
function callbackStarter(xmlHttp, machine, graphPourc, listDefaut, listPareto, option) {
	if (xmlHttp.readyState == 4 && xmlHttp.status == 200) { // 4 = "loaded" 200 = OK
		document.getElementById("graphMachine"+machine).innerHTML = xmlHttp.responseText;
		drawGraph(machine, graphPourc, listDefaut, listPareto);
		
		//setTimeout(function(){ start(machine, option, graphPourc, listDefaut, listPareto);},2000);
	}
};

/*
*		AJAX CHANGER POURCENTAGE GRAPH
*/
function changeToGraphPourc(machine, graphPourc){
	var xmlHttp = createXMLHttpRequest();
	var url = "";
	xmlHttp.onreadystatechange = function(){ callbackChangeToGraphPourc(xmlHttp, machine, graphPourc) };
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
};

// Pourcentage Graph Changer Callback
function callbackChangeToGraphPourc(xmlHttp, machine, graphPourc) {
	if (xmlHttp.readyState == 4 && xmlHttp.status == 200) { // 4 = "loaded" 200 = OK
		// prepare graph data
		graphPourc = eval("("+graphPourc+")");
		
		// clear corresponding graph on the page
		var element = document.getElementById("pourcDefaut"+machine);
		if(element){
			element.innerHTML = "";
		}
		else{
			element = document.getElementById("paretoDefaut"+machine);
			if(element){
				element.innerHTML = "";
			}
		}
		
		// change element id in order to draw graph
		element.setAttribute("id","pourcDefaut"+machine);
		
		// draw new graph
		drawPourcGraph(machine, graphPourc);
	}
};

/*
*		AJAX CHANGER PARETO GRAPH
*/
function changeToGraphPareto(machine, graphPareto){
	var xmlHttp = createXMLHttpRequest();
	var url = "";
	xmlHttp.onreadystatechange = function(){ callbackChangeToGraphPareto(xmlHttp, machine, graphPareto) };
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
};

// Pourcentage Graph Changer Callback
function callbackChangeToGraphPareto(xmlHttp, machine, graphPareto) {
	if (xmlHttp.readyState == 4 && xmlHttp.status == 200) { // 4 = "loaded" 200 = OK
		// get graph data
		graphPareto = eval("("+graphPareto+")");
		
		// get listDefaut
		var listDefaut = [];
    for (var defaut in graphPareto){
      listDefaut.push(defaut);
    }
		
		// get listPareto
		var listPareto = [];
    for (var defaut in graphPareto){
      listPareto.push(graphPareto[defaut]);
    }
		
		// clear corresponding graph on the page
		var element = document.getElementById("pourcDefaut"+machine);
		if(element){
			element.innerHTML = "";
		}
		else{
			element = document.getElementById("paretoDefaut"+machine);
			if(element){
				element.innerHTML = "";
			}
		}
		
		// change element id in order to draw graph
		element.setAttribute("id","paretoDefaut"+machine);
		
		// draw new graph
		drawParetoGraph(machine, listDefaut, listPareto);
	}
};