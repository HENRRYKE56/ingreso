/** XHConn - Simple XMLHTTP Interface - bfults@gmail.com - 2005-04-08        **
 ** Code licensed under Creative Commons Attribution-ShareAlike License      **
 ** http://creativecommons.org/licenses/by-sa/2.0/                           **/
//function XHConn(){
var XHConn = function () {
    var xmlhttp, bComplete = false;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e) {
            try {
                xmlhttp = new XMLHttpRequest();
            }
            catch (e) {
                xmlhttp = false;
            }
        }
    }

    if (!xmlhttp)
        return null;
    this.connect = function (sURL, sMethod, sVars, fnDone)
    {
        if (!xmlhttp)
            return false;
        bComplete = false;
        sMethod = sMethod.toUpperCase();

        try {
            if (sMethod == "GET")
            {
                xmlhttp.open(sMethod, sURL + "?" + sVars, true);
                sVars = "";
            }
            else
            {
                xmlhttp.open(sMethod, sURL, true);
                xmlhttp.setRequestHeader("Method", "POST " + sURL + " HTTP/1.1");
                xmlhttp.setRequestHeader("Content-Type",
                        "application/x-www-form-urlencoded");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && !bComplete) {
                    bComplete = true;
                    fnDone(xmlhttp);
                }

            };
            xmlhttp.send(sVars);
        }
        catch (z) {
            return false;
        }
        return true;
    };
    return this;
}
//function getSelect(target,liga,obj,entvalue,maxlen,numpar,numAdd,objclear){
//	cadena='';
//	document.getElementById(objclear).value='';
//	if(varval=document.getElementById(obj).value){
//		if (varval.length > maxlen){
//			
//			cadena='varval=' + varval + '&entvalue=' + entvalue + '&numpar=' + numpar + '&numAdd=' + numAdd;
//			selftarget = 'div_' + target;
//			selflink = liga + '.php';
//			cargar_general(selftarget, selflink,cadena);
//		}
//	}
//	
//}
//function cargar_general(target,liga,variable){	
//	document.getElementById(target).innerHTML = '<img src="img/ind_green2.gif" border="0" heigth="18" width="18">buscando datos...';
//	var myConn = new XHConn();
//		if (!myConn) alert("XMLHTTP no esta disponible. Inténtalo con un navegador más nuevo.");
//		var peticion = function (oXML) {  
//				document.getElementById(target).innerHTML = oXML.responseText; 
//				};
//		myConn.connect(liga, "POST", variable, peticion);
//}
function cargar_general(target, liga, variable) {
    args = cargar_general.arguments;
    document.getElementById(target).innerHTML = '<img src="img/ind_green2.gif" border="0" heigth="18" width="18">buscando datos...';
    var myConnection = new XHConn();
    if (!myConnection)
        alert("XMLHTTP no esta disponible. Inténtalo con un navegador más nuevo.");
    var peticion = function (oXML) {
        var ar=[];
        if(oXML.responseText.length > 0){
           ar=oXML.responseText.split("|");
        }
        var casos=ar[0];
        if(casos=="success"){
            if(ar.length > 1)alertify.success(ar[2]);
            else alertify.success("+  accion realizada con exito");   
            document.getElementById(target).innerHTML = (ar[1]?ar[1]:'OK');  
        }else if(casos=="error"){
            if(ar.length > 1)alertify.success(ar[2]);
            else alertify.error("* la accion solicitada no es valida");         
            document.getElementById(target).innerHTML = (ar[1]?ar[1]:'OK');  
        }else{
            document.getElementById(target).innerHTML = oXML.responseText;            
        }
        if (target.indexOf("_row_") != -1) {
            setTimeout(function () {
                if (oXML.responseText == 'HIDE') {
                    document.getElementById(target.substring(target.indexOf("_row_") + 1)).style.display = 'none';
                }
            }, 10);
        }
        if (args[4] === undefined) {
        } else {
            eval(args[4]);
        }
    };
    myConnection.connect(liga, "POST", variable, peticion);
}

function cargar_xml(target, liga, variable) {
	//alert(target);
    disableSelect(document.getElementById(target), "buscando datos...");
    var myConn = new XHConn();
    if (!myConn)
        alert("XMLHTTP no esta disponible. Inténtalo con un navegador más nuevo.");
    var peticion = function (oXML) {
        var newOption;
        var datos = oXML.responseXML;
        elementos = datos.getElementsByTagName("elemento");
		//alert(peticion);
        if (elementos) {
			
            xSelect = document.getElementById(target);
            xSelect.length = 0;
            for (var i = 0; i < elementos.length; i++) {
                newOption = document.createElement("option");
                newOption.value = elementos[i].getAttribute('value');
                newOption.innerHTML = elementos[i].firstChild.data;
                xSelect.appendChild(newOption);
            }
                xSelect.disabled = false;            
        } else {
            disableSelect(document.getElementById(target), "sin datos... [seleccione una opcion valida]");
        }
    };
    myConn.connect(liga, "POST", variable, peticion);
}
function cargar_xml1(target, liga, variable) {
	//alert(target);
    disableSelect(document.getElementById(target), "buscando datos...");
    var myConn = new XHConn();
    if (!myConn)
        alert("XMLHTTP no esta disponible. Inténtalo con un navegador más nuevo.");
    var peticion = function (oXML) {
        var newOption;
        var datos = oXML.responseXML;
        elementos = datos.getElementsByTagName("elemento");
		//alert(peticion);
        if (elementos) {
			
            xSelect = document.getElementById(target);
            xSelect.length = 0;
            for (var i = 0; i < elementos.length; i++) {
                newOption = document.createElement("option");
                newOption.value = elementos[i].getAttribute('value');
                newOption.innerHTML = elementos[i].firstChild.data;
                xSelect.appendChild(newOption);
            }
                xSelect.disabled = false;            
        } else {
            disableSelect(document.getElementById(target), "sin datos... [seleccione una opcion valida]");
        }
        //console.log("cargar 2: "+aux_pedido);
        $("#CVEPED").val(aux_pedido);
        $("#CVEPED").trigger('change');
    };
    myConn.connect(liga, "POST", variable, peticion);
}
function cargar_xml12(target, liga, variable) {
	//alert(target);
    disableSelect(document.getElementById(target), "buscando datos...");
    var myConn = new XHConn();
    if (!myConn)
        alert("XMLHTTP no esta disponible. Inténtalo con un navegador más nuevo.");
    var peticion = function (oXML) {
        var newOption;
        var datos = oXML.responseXML;
        elementos = datos.getElementsByTagName("elemento");
		//alert(peticion);
        if (elementos) {
			
            xSelect = document.getElementById(target);
            xSelect.length = 0;
            for (var i = 0; i < elementos.length; i++) {
                newOption = document.createElement("option");
                newOption.value = elementos[i].getAttribute('value');
                newOption.innerHTML = elementos[i].firstChild.data;
                xSelect.appendChild(newOption);
            }
                xSelect.disabled = false;            
        } else {
            disableSelect(document.getElementById(target), "sin datos... [seleccione una opcion valida]");
        }
      //  console.log("contrato 1: "+aux_contrato);
        $("#CVEPROV").val(aux_contrato);
        $("#CVEPROV").trigger('change');
    };
    myConn.connect(liga, "POST", variable, peticion);
}
function disableSelect(xSelect, msg) {
	//alert(xSelect);
    xSelect.length = 0;
    var newOption = document.createElement("option");
    newOption.value = -1;
    newOption.innerHTML = msg;
    xSelect.appendChild(newOption);
    xSelect.disabled = true;
}


//function cargar_toolTip(target,liga,variable,title){
//	document.getElementById(target).innerHTML = '<img src="img/ind_green2.gif" border="0" heigth="18" width="18">buscando ...';
//	var myConn = new XHConn();
//		if (!myConn) alert("XMLHTTP no esta disponible. Inténtalo con un navegador más nuevo.");
//		var peticion = function (oXML) {  
//				document.getElementById(target).innerHTML = "" + 
//			"<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" " +
//			"<tr><td class=\"titleToolTipBox\" width=\"288\">"+ title + "</td>" + 
//			"<td class=\"closeToolTipBox\" size=\"12\"><a id=\"aClose\" href=\"#\" onclick=\"hideMe();\">[X]</a></td></tr>" + 
//			"<tr><td class=\"bodyToolTipBox\" colspan=\"2\">" + 
//			oXML.responseText +
//			"</td></tr></table>";
//				
//				
//				
//				};
//		myConn.connect(liga, "POST", variable, peticion);
//}
function cargar_toolTip(target, liga, variable, title, setClose) {
    args = cargar_toolTip.arguments;
    //$("#" + target).html('<img src="img/ind_green2.gif" border="0" heigth="18" width="18">buscando ...');
var con_html='<div class="container-fluid">' +
                '<div class="row">'+
                    '<div class="col-12 col-sm-12">'+'<img src="img/ind_green2.gif" border="0" heigth="18" width="18">&nbsp;buscando ...'+
                    '</div>'+
                '</div>'+
             "</div>";
    $("#bod_pag_dialog").html(""+con_html);    
    $('#pag_dialog ').modal('show');    
    var myConn = new XHConn();
    if (!myConn)
        alert("XMLHTTP no esta disponible. Inténtalo con un navegador más nuevo.");
    var peticion = function (oXML) {
       // alert(oXML.responseText);
var con_html='<div class="container-fluid" style="padding:0px;">' +
                '<div class="row">'+
                    '<div class="col-12 col-sm-12" style="padding:2px;">'+oXML.responseText+
                    '</div>'+
                '</div>'+
             "</div>";        
$("#bod_pag_dialog").html(con_html);          
//        $("#" + target).html("" +
//                "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >" +
//                "<tr><td class=\"bodyToolTipBox\">" +
//                oXML.responseText +
//                "</td></tr></table>");


        if (args[6] === undefined) {
        } else {
            eval(args[6]);
        }
    };
    //alert(liga);
    myConn.connect(liga, "POST", variable, peticion);

}
function cargar_toolTip2(target, liga, variable, title, setClose) {
    args = cargar_toolTip2.arguments;
    //$("#" + target).html('<img src="img/ind_green2.gif" border="0" heigth="18" width="18">buscando ...');
var con_html='<div class="container-fluid">' +
                '<div class="row">'+
                    '<div class="col-12 col-sm-12">'+'<img src="img/ind_green2.gif" border="0" heigth="18" width="18">&nbsp;buscando ...'+
                    '</div>'+
                '</div>'+
             "</div>";
    $("#bod_pag_dialog").html(""+con_html);    
   $('.modal-dialog').draggable({
    	"handle":".modal-header",
        axis: "x"
      });    
    $('#pag_dialog ').modal('show');    
    var myConn = new XHConn();
    if (!myConn)
        alert("XMLHTTP no esta disponible. Inténtalo con un navegador más nuevo.");
    var peticion = function (oXML) {
       // alert(oXML.responseText);
var con_html='<div class="container-fluid" style="padding:0px;">' +
                '<div class="row">'+
                    '<div class="col-12 col-sm-12" style="padding:2px;">'+oXML.responseText+
                    '</div>'+
                '</div>'+
             "</div>";        
$("#bod_pag_dialog").html(con_html);      
busca_detalle_en(c_e_d);
//        $("#" + target).html("" +
//                "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >" +
//                "<tr><td class=\"bodyToolTipBox\">" +
//                oXML.responseText +
//                "</td></tr></table>");


        if (args[6] === undefined) {
        } else {
            eval(args[6]);
        }
    };
    //alert(liga);
    myConn.connect(liga, "POST", variable, peticion);

}
function cargar_toolTip2_inner(target,liga,variable,title,setClose){
	args=cargar_toolTip2_inner.arguments;
	document.getElementById(target).innerHTML = '<img src="img/ind_green2.gif" border="0" heigth="18" width="18">buscando ...';
	var myConn = new XHConn();
		if (!myConn) alert("XMLHTTP no esta disponible. Inténtalo con un navegador más nuevo.");
		var peticion = function (oXML) {  
		//str=target.replace("div", "#lnk");
		str="#";
				document.getElementById(target).innerHTML = "" + 
			"<div class='rounded separ_verde_s_claro' style='background-color: #EEF7F4;'><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >" +
			//"<tr><td class=\"titleToolTipBox\">"+ title + "</td>" + 
			(setClose?("<tr><td class=\"closeToolTipBox\"><a id=\"aClose\" href=\""+str+"\" class='btn boton_can punteados' onclick=\"clearMe('"+ target +"');\">Cerrar</a></td></tr>"):"")+ 
			"<tr><td class=\"bodyToolTipBox\" colspan=\"2\">" + 
			oXML.responseText +
			"</td></tr></table><div>";
			if(args[5]) document.getElementById(target).style.width = (args[5])+ "px";
			if(args[6]===undefined){}else{eval(args[6]);}
				//window.location.hash = target.replace("div", "#lnk");
				document.getElementById(target).scrollIntoView(true);

				
				};
		myConn.connect(liga, "POST", variable, peticion);
}