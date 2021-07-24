// JavaScript Document
function sendRep() { 
  var cadena1='',xname='',i,args=sendRep.arguments;
  var cadena2='';
   var cadena='';
  var chk=true;
  var chkStr="chk";
  var chkCnt=0;
  document.obj_retVal=false;
	  for (i=2; i<(args.length-1); i++) { xname=args[i];val=findObj(args[i]);
		if (val) {
			if (val.id.substring(0,3)==chkStr){
				if(val.checked){
					chk=true;
				}else{
				chk=false;
				}
			}
			if (val.value.trim()!="" && val.value.trim()!="ALL" && chk) {
				if (cadena.length!=0)cadena +="&";
					cadena += xname + "=" + val.value.trim();
			}}}cadena1=args[0]+cadena;cadena1 += '&fparam=' + args[1];cadena2=args[args.length-1]+cadena;
			cadena2 += '&fparam=' + args[1];openInIframe3(cadena1, cadena2);
}
function sendRep2() { 
  var args = sendRep2.arguments;
  args[0]();
    if(document.obj_retVal){
  var cadena1='',xname='',i,args=sendRep2.arguments;
  var cadena2='';
   var cadena='';
  var chk=true;
  var chkStr="chk";
  var chkCnt=0;
  document.obj_retVal=false;

	  for (i=3; i<(args.length); i++) { xname=args[i];val=findObj(args[i]);
		if (val) {
			if (val.id.substring(0,3)==chkStr){
				if(val.checked){
					chk=true;
				}else{
				chk=false;
				}
			}
			//alert(val.value.trim());
			  //  alert(val.type);
			if ((val.value.trim()!="" && val.value.trim()!="ALL" && val.value.trim()!="-1"  && chk && val.type!='checkbox') || (val.type=='checkbox' && val.checked)) {
				if (cadena.length!=0)cadena +="&";
					cadena += xname + "=" + val.value.trim();
			}}}
                //alert(findObj(args[1]).value);
                cadena1=args[1]+cadena;cadena1 += '&fparam=' + findObj('vparfile'+findObj(args[2]).value).value;
			openInIframe5(cadena1);
                    }else{
                        
                    }
}
function sendRep3() { 
  var args = sendRep3.arguments;
  args[0]();
    if(document.obj_retVal){
  var cadena1='',xname='',i,args=sendRep3.arguments;
  var cadena2='';
   var cadena='';
  var chk=true;
  var chkStr="chk";
  var chkCnt=0;
  document.obj_retVal=false;

	  for (i=3; i<(args.length); i++) { xname=args[i];val=findObj(args[i]);
		if (val) {
			if (val.id.substring(0,3)==chkStr){
				if(val.checked){
					chk=true;
				}else{
				chk=false;
				}
			}
			//alert(val.value.trim());
			  //  alert(val.type);
			if ((val.value.trim()!="" && val.value.trim()!="ALL" && val.value.trim()!="-1"  && chk && val.type!='checkbox') || (val.type=='checkbox' && val.checked)) {
				if (cadena.length!=0)cadena +="&";
					cadena += xname + "=" + val.value.trim();
			}}}
                //alert(findObj(args[1]).value);
                cadena1=args[1]+cadena;cadena1 += '&fparam=' + findObj('vparfile'+findObj(args[2]).value).value;
			openInIframe(cadena1); //}
                    }else{
                        
                    }
}
function sendRep3() { 
  var args = sendRep3.arguments;
  args[0]();
    if(document.obj_retVal){
  var cadena1='',xname='',i,args=sendRep3.arguments;
  var cadena2='';
   var cadena='';
  var chk=true;
  var chkStr="chk";
  var chkCnt=0;
  document.obj_retVal=false;

	  for (i=3; i<(args.length); i++) { xname=args[i];val=findObj(args[i]);
		if (val) {
			if (val.id.substring(0,3)==chkStr){
				if(val.checked){
					chk=true;
				}else{
				chk=false;
				}
			}
			//alert(val.value.trim());
			  //  alert(val.type);
			if ((val.value.trim()!="" && val.value.trim()!="ALL" && val.value.trim()!="-1"  && chk && val.type!='checkbox') || (val.type=='checkbox' && val.checked)) {
				if (cadena.length!=0)cadena +="&";
					cadena += xname + "=" + val.value.trim();
			}}}
                //alert(findObj(args[1]).value);
                cadena1=args[1]+cadena;cadena1 += '&fparam=' + findObj('vparfile'+findObj(args[2]).value).value;
			openInIframe(cadena1); //}
                    }else{
                        
                    }
}
function sendRep10() { 
  var args = sendRep10.arguments;
  args[0]();
    if(document.obj_retVal){
  var cadena1='',xname='',i,args=sendRep10.arguments;
  var cadena2='';
   var cadena='';
  var chk=true;
  var chkStr="chk";
  var chkCnt=0;
  document.obj_retVal=false;

	  for (i=3; i<(args.length); i++) { xname=args[i];val=findObj(args[i]);
		if (val) {
			if (val.id.substring(0,3)==chkStr){
				if(val.checked){
					chk=true;
				}else{
				chk=false;
				}
			}
			//alert(val.value.trim());
			  //  alert(val.type);
			if ((val.value.trim()!="" && val.value.trim()!="ALL" && val.value.trim()!="-1"  && chk && val.type!='checkbox') || (val.type=='checkbox' && val.checked)) {
				if (cadena.length!=0)cadena +="&";
					cadena += xname + "=" + val.value.trim();
			}}}
                //alert(findObj(args[1]).value);
                cadena1=args[1]+cadena;cadena1 += '&fparam=' + findObj('vparfile'+findObj(args[2]).value).value;
                                //console.log(cadena1);
			abrir(cadena1); //}
                    }else{
                        
                    }
}
function sendRep3_old() { 
  var cadena1='',xname='',i,args=sendRep3.arguments;
  var cadena2='';
   var cadena='';
  var chk=true;
  var chkStr="chk";
  var chkCnt=0;
  document.obj_retVal=false;
  //if (document.obj_retVal==true){
	  for (i=2; i<(args.length); i++) { xname=args[i];val=findObj(args[i]);
		if (val) {
			if (val.id.substring(0,3)==chkStr){
				if(val.checked){
					chk=true;
				}else{
				chk=false;
				}
			}
			//alert(val.value.trim());
			  //  alert(val.type);
			if ((val.value.trim()!="" && val.value.trim()!="ALL" && val.value.trim()!="-1"  && chk && val.type!='checkbox') || (val.type=='checkbox' && val.checked)) {
				if (cadena.length!=0)cadena +="&";
					cadena += xname + "=" + val.value.trim();
			}}}cadena1=args[0]+cadena;cadena1 += '&fparam=' + findObj('vparfile'+findObj(args[1]).value).value;
			openInIframe(cadena1); //}
			//openInIframe5(cadena1);
	//		document.obj_retVal=false;
}

//////Agregar a sicovid copia esta parte y agregaselo al otro

var myVar;
var reloj;
var con_reloj = 0;
function sendRep2_recarga() {
    var args = sendRep2_recarga.arguments;
    $("#inicio").attr("disabled", true);
    $("#parar").attr("disabled", false);
    reloj = setInterval(function () {
        actualiza_reloj(args);
    }, 1000);
}
function parar_recarga() {
    clearInterval(myVar);
    clearInterval(reloj);
    con_reloj = 0;
    $("#reloj").html("0seg");
    $("#inicio").attr("disabled", false);
    $("#parar").attr("disabled", true);
}
function actualiza_reloj(args) {
    var tiempo_recarga = ($("#recarga").val()) * 1;
    con_reloj++;
    var time_real = con_reloj;
    var unidad_med = "seg";
    if (con_reloj > 59) {
        time_real = (con_reloj / 60).toFixed(1);
        unidad_med = "min";
    }
    $("#reloj").html(time_real + " " + unidad_med);
    // console.log(tiempo_recarga+" "+con_reloj);
    if (tiempo_recarga == (con_reloj)) {
        recargar(args);
    }



}
function recargar(parametros) {
    con_reloj = 0;
    var args = parametros;

    var cadena1 = '', xname = '', i;
    var cadena2 = '';
    var cadena = '';
    var chk = true;
    var chkStr = "chk";
    var chkCnt = 0;
    document.obj_retVal = false;
    for (i = 2; i < (args.length); i++) {
        xname = args[i];
        val = findObj(args[i]);
        if (val) {
            if (val.id.substring(0, 3) == chkStr) {
                if (val.checked) {
                    chk = true;
                } else {
                    chk = false;
                }
            }
            if ((val.value.trim() != "" && val.value.trim() != "ALL" && val.value.trim() != "-1" && chk && val.type != 'checkbox') || (val.type == 'checkbox' && val.checked)) {
                if (cadena.length != 0)
                    cadena += "&";
                cadena += xname + "=" + val.value.trim();
            }
        }
    }
    cadena1 = args[0] + cadena;
    cadena1 += '&fparam=' + findObj('vparfile' + findObj(args[1]).value).value;
    openInIframe_recarga(cadena1);
}
function openInIframe_recarga(cadena1) {
    var $preparingFileModal = $("#preparing-file-modal");
    $preparingFileModal.dialog({height: 300, width: 350, modal: true});
    load_response_recarga('miiframe', cadena1);
}
function load_response_recarga(target, cadena1) {
    var myConnection = new XHConn();
    if (!myConnection)
        alert("XMLHTTP no esta disponible. Inténtalo con un navegador más nuevo.");
    var peticion = function (oXML) {
        $("#" + target).html(oXML.responseText);

        var $preparingFileModal = $("#preparing-file-modal");
        $preparingFileModal.dialog('close');
    };
    var pars = cadena1.split('?');
    myConnection.connect(pars[0], "GET", pars[1], peticion);

//    var peticion = false;
//    var testPasado = false;
//    try {
//        peticion = new XMLHttpRequest();
//    } catch (trymicrosoft) {
//        try {
//            peticion = new ActiveXObject("Msxml2.XMLHTTP");
//        } catch (othermicrosoft) {
//            try {
//                peticion = new ActiveXObject("Microsoft.XMLHTTP");
//            } catch (failed) {
//                peticion = false;
//            }
//        }
//    }
//    //Obtenemos el contenido del div
//    //donde se cargaran los resultados
//    var element = document.getElementById(target);
//    //Obtenemos el valor seleccionado del combo anterior
//    //construimos la url definitiva
//    var pars = cadena1.split('?');
//    var fragment_url = pars[0] + '?' + pars[1];
//    //abrimos la url
//    peticion.open("GET", fragment_url);
//    peticion.onreadystatechange = function () {
//        if (peticion.readyState == 4) {
//            //escribimos la respuesta
//            element.innerHTML = peticion.responseText;
//            var $preparingFileModal = $("#preparing-file-modal");
//            $preparingFileModal.dialog('close');
//        }
//    }
//    peticion.send(null);
}
