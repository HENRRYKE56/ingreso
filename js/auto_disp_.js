// JavaScript Document
var lista1 = "";
function auto_disp() {

    args = auto_disp.arguments;
    var keynum = "";
    e = args[5];
    var borrar = false;
    document.strTarget = "";
    var texto;
    cadena = '';
    contObj = 0;
    contObj2 = 0;
    contObj3 = 0;
    document.otherObj = "";
    document.theObjFocus = '';
    document.theObjValid = '';
    document.aTitles = [];
    boolOnReady = false;
    boolAfterSelected = false;
    for (var i = 6; i <= (args.length - 1); i++) {
        if (args[i].indexOf("sendObj_") != -1) {
            xPos = args[i].indexOf("sendObj_");
            val = findObj(args[i].substring(xPos + 8));
            if (contObj == 0) {
                theObj = val;
            }
            jQuery("#i_a"+args[i].substring(xPos + 8)).removeClass( "fa fa-check text-success" );
            jQuery("#i_a"+args[i].substring(xPos + 8)).addClass( "fa fa-times text-danger" );
            if (val) {
                if ((varval = val.value.trim()) != "") {
                    if (args[i].indexOf(":lenMin_") != -1) {
                        xlmPos = args[i].indexOf("lenMin_") + 8;
                        if (varval.length > parseInt(args[i].substring(xlmPos, xlmPos + 2)) * 1) {
                            if (cadena.length > 0) {
                                cadena += '&'
                            }
                            cadena += args[i].substring(xPos + 8) + '=' + varval;
                            contObj3 += 1;
                        }
                    } else {
                        if (!isNaN(varval)) {
                            if (varval.length > 0) {
                                if (cadena.length > 0) {
                                    cadena += '&'
                                }
                                cadena += args[i].substring(xPos + 8) + '=' + varval;
                                contObj3 += 1;
                            }
                        } else {
                            if (val.type != "text" || (val.type == "text" && varval.length > 4)) {
                                if (cadena.length > 0) {
                                    cadena += '&'
                                }
                                cadena += args[i].substring(xPos + 8) + '=' + varval;
                                contObj3 += 1;
                            }
                        }
                    }
                }
            }
            contObj += 1;
        }
        if (args[i].indexOf("getObj_") != -1) {
            xPos = args[i].indexOf("getObj_");
            val = findObj(args[i].substring(xPos + 7));
            if (contObj2 == 0) {
                theObjTarget = val;
            }
            if (document.strTarget.length > 0) {
                document.strTarget += ';'
            }
            // alert(args[i].substring(xPos + 7));
            document.strTarget += args[i].substring(xPos + 7)
            contObj2 += 1;
        }
        if (args[i].indexOf("aTitles_") != -1) {
            xPos = args[i].indexOf("aTitles_");
            document.aTitles = eval(args[i].substring(xPos + 8));
        }//
        if (args[i].indexOf("focusObj_") != -1) {
            xPos = args[i].indexOf("focusObj_");
            document.theObjFocus = args[i].substring(xPos + 9);
        }
        if (args[i].indexOf("validObj_") != -1) {
            xPos = args[i].indexOf("validObj_");
            document.theObjValid = args[i].substring(xPos + 9);
        }
        if (args[i].indexOf("onReady") != -1) {
            document.fnOnReady = eval(args[i]);
            boolOnReady = true
        }//
        if (args[i].indexOf("fnAfterSelected") != -1) {
            document.fnAfterSelected = eval(args[i]);
            boolAfterSelected = true;
        }//
        if (args[i].indexOf("otherObj_") != -1) {
            xPos = args[i].indexOf("otherObj_");
            document.otherObj = args[i].substring(xPos + 9);
            //alert(document.otherObj);
        }//  
		
		      

    }
    if (!boolOnReady)
        document.fnOnReady = function (objitemp) {
        };
    if (!boolAfterSelected)
        document.fnAfterSelected = function (rw, n) {
        };
    if (window.event) {
        keynum = e.keyCode;
    } else if (e.which) {
        keynum = e.which;
    }// IE // Netscape/Firefox/Opera
    if (keynum >= 96 && keynum <= 105)
        keynum -= 48;
    if (keynum == 189)
        keynum = 95;
    if (!(String.fromCharCode(keynum).match(/(\w)/)) && keynum != 8 && keynum != 13) {
        texto = textoAnt;
    } else {
        texto = theObj.value;
    }
    textoAnt = texto;
    if (texto != null && texto != "" && keynum != 37 && keynum != 38 && keynum != 39 && keynum != 40 && keynum != 13) {
        if (cadena.length > 0 && contObj3 == contObj) {
            var posicion = theObjTarget.getBoundingClientRect();
//                            alert((theObjTarget.offsetTop)+ "px    "+posicion.top+" px");
//alert((posicion.top - args[2]));
            var elemento_i = $("#" + args[1]);
            var position_n = elemento_i.position();
            // alert("left: " + position_n.left + ", top: " + position_n.top );
            cadena += '&entvalue=' + args[1];
            selftarget = 'div_LstAuto';
            selflink = args[0] + '.php';
			
			 if (args[11] != null) {
				 //alert(cadena);
                //cadena+="&queryc="+args[13];
                cadena += "&queryc=" + args[11];
            }

            if (document.theObjValid.length > 0) {
                xSpan = document.getElementById("e_" + document.theObjValid);
                setMsgSpan(xSpan, '<img src="img/ind_green2.gif" border="0" heigth="18" width="18">validando ...', '#333333');
            }
            var myConn = new XHConn();
            if (!myConn)
                alert("XMLHTTP no esta disponible. Inténtalo con un navegador más nuevo.");
            var peticion = function (oXML) {
                //document.getElementById('toolHelp').innerHTML='<pre>'+oXML.responseText+'</pre>';
//								winx=window.open();
//								winx.document.write(oXML.responseText);
                var datos = oXML.responseXML;
                elementos = datos.getElementsByTagName("elemento");
                var listaElementos = new Array();
                if (elementos) {
                    for (var i = 0; i < elementos.length; i++) {
                        //   alert(elementos[i].firstChild.data);
                        listaElementos[listaElementos.length] = elementos[i].firstChild.data;
                    }
                }
                if (listaElementos.length == 0 && document.theObjValid.length > 0) {

                    xSpan = document.getElementById("e_" + document.theObjValid);
                    setMsgSpan(xSpan, '<img src="img/img43.gif" border="0" >', '#FF0000');
                }
                var html_l = escribeLista(listaElementos);
                jQuery("#"+theObj.id).webuiPopover('destroy');
                jQuery('#'+theObj.id).webuiPopover({
                    title: '<div><div style="display: inline-block;width:70%;"><strong>Resultados de busqueda</strong></div>'+'<div style="display: inline-block;width:30%;text-align:right;"><button onclick="hideMeAutoLst();" style="background-color: transparent;border: none;" type="submit" class="btn btn-default" data-toggle="tooltip" title="Nuevo"><i style="font-size:21px;" aria-hidden="true" class="fa fa-times text-danger"></i></button></div>'+'</div>',
                    width: 500,
                    height: 210,
                    padding: false,
                    animation: 'pop',
                    content: html_l,
                    html: true,
                    
                });
                jQuery("#"+theObj.id).webuiPopover('show');
            };
            myConn.connect(selflink, "POST", cadena, peticion);
        } else {
            //fill.style.display = "none";
            if (document.theObjValid.length > 0) {
                xSpan = document.getElementById("e_" + document.theObjValid);
                setMsgSpan(xSpan, '<img src="img/img43.gif" border="0" >', '#FF0000');
            }
        }
    }
    if (keynum == 37) { // Izquierda  
    } else if (keynum == 38) { // Arriba 
        if (posicionListaFilling > 0) {
            seleccionaFilling('tr' + theObj.id, posicionListaFilling - 1)
        }
    } else if (keynum == 39) { // Derecha
    } else if (keynum == 40) { // Abajo
        if (theObj.value != "") {
            if (posicionListaFilling < listaE.length - 1) {
                seleccionaFilling('tr' + theObj.id, posicionListaFilling + 1)
            }
        }
    } else if (keynum == 8) { // Borrar 
        posicionListaFilling = 0;
    } else if (keynum == 13) {
//        if (fill.style.display == "block") {
//            seleccionaTextoFilling('tr' + theObj.id, posicionListaFilling);
//            setTimeout("document.fnAfterSelected('tr'+theObj.id, posicionListaFilling)", 500);
//            /*setInput(theObjTarget,theObjTarget2);*/}
    } else {// escribiendo
        posicionListaFilling = 0;
        //fill.scrollTop = 0;
    }
}
function hideMeAutoLst() {
    jQuery('#'+theObj.id).webuiPopover('destroy');
}
function escribeLista(lista) {
    var html = "";
    listaE = lista;
    lista1 = lista;
    if (lista.length == 0) {
        document.notBussyKeyEnter = true;
    } else {
        document.notBussyKeyEnter = false;
        var html = '<table class="table table-hover" >';
        if (document.aTitles.length > 0) {
            html += "<thead class='table-success'><tr>";
            for (var i = 0; i < document.aTitles.length; i++) {
                html += "<th class=\"titleToolTipBox_m\" style=\"width:" + (document.aTitles[i].width) + "px" + ";\">" + document.aTitles[i].title + "</th>"
            }
            html += "</tr><thead>";
        }
//			var html='<table bgcolor="#FFFFFF" cellspacing="1" ' + 'cellpadding="3" border="0" width="100%">';
        arrayTarget = document.strTarget.split(";");
        html +="<tbody>";
        for (var i = 0; i < lista.length; i++) {
            html += '<tr id="tr' + theObj.id + i +
                    '" ' + (posicionListaFilling == i ?
                            ' class="fill" ' : ' class="no-fill" ') +
                    ' onmousedown="seleccionaTextoFilling(\'tr' +
                    theObj.id + '\', ' + i + ',\'fnAfterSelected\',\''+theObj.id +'\');">';
            arraysplit = lista[i].split("@:::@");
            for (var ih = 0; ih < arraysplit.length; ih++) {
                arraysplit2 = arraysplit[ih].split("@===@");
                if (i < 10)
                    idname = '0' + i;
                else
                    idname = i;
                html += '<td id=\'' + idname + '_' + arraysplit2[0] + '\'>' + arraysplit2[1] + '</td>';
            }
            html += '</tr>';
        }
        html +="</tbody>";
        html += '</table>';
    }
    return html;
}

function setInput(n) {
    if (n < 10) {
        idname = '0' + n;
    } else {
        idname = n;
    }
    arraysplit = textoAnt.split("@:::@");

    arrayTarget = document.strTarget.split(";");
    //fill = document.getElementById('div_LstAuto');
    for (var i = 0; i < arrayTarget.length; i++) {
        document.getElementById(arrayTarget[i]).value = document.getElementById(idname + '_' + arrayTarget[i]).innerHTML;


        //document.fnOnReady(document.getElementById(arrayTarget[i]));

    }//arraysplit[i]; }
    if (document.otherObj != "") {
        var arreglo_otros = document.otherObj.split("-");
        //alert(arreglo_otros);
        for (var o = 0; o < arreglo_otros.length; o++) {

            //  $('#'+arreglo_otros[o]).options.length = 0;
            //document.getElementById(arreglo_otros[o]).options.length = 0;
            // $("#"+arreglo_otros[o]).find('option').empty();
            //alert(arreglo_otros[o]);
            var auxcc = lista1;
            var valor = encuentravalor(auxcc, arreglo_otros[o])
            //alert(document.getElementById(idname + '_' + arreglo_otros[o]).innerHTML);
            if (arreglo_otros[o] == "fecha_nacimiento") {
                var valor = formatofecha(valor);
            }
//            
//                        if(arreglo_otros[o]=='id_colonia'){alert(valor); $('#'+arreglo_otros[o]+' option[value='+valor+']');}
//            else if(arreglo_otros[o]=='codigo_postal')$('#'+arreglo_otros[o]+' option[value='+valor+']'); 
            else
                $("#" + arreglo_otros[o]).val(valor);
            // document.getElementById(arreglo_otros[o]).value=valor;
            //document.getElementById(arreglo_otros[o]).value=document.getElementById(idname + '_' + arreglo_otros[o]).innerHTML;
        }
    }

    hideMeAutoLst();
    posicionListaFilling = 0;
    if (document.theObjFocus.length > 0) {
        document.getElementById(document.theObjFocus).select();
    }
    else {
        document.getElementById(arrayTarget[0]).select();
    }
    document.notBussyKeyEnter = true;
    if (document.theObjValid.length > 0) {
        xSpan = document.getElementById("e_" + document.theObjValid);
        setMsgSpan(xSpan, " Ok" + '&nbsp;&nbsp;<img src="img/img45.gif" border="0" >', '#99CC00');
    }
}

function seleccionaTextoFilling() {
    //alert('sdfsdfsdf');
    args0 = seleccionaTextoFilling.arguments;
    id = args0[0];
    id2 = args0[3];
    n = args0[1];
    var str = "";
    arrayTarget = document.strTarget.split(";");

    for (var i = 0; i < arrayTarget.length; i++) {
        //alert(id);
        if (str.length > 0) {
            str += '@:::@'
        }
        str += document.getElementById(id + n).childNodes[i].innerHTML;
    }
    textoAnt = str;
    posicionListaFilling = 0;
    setInput(n);
    if (args0.length == 3) {
        setTimeout("document.fnAfterSelected(id, n)", 500);//fa fa-check text-success
    }
            jQuery("#i_a"+id2).removeClass( "fa fa-times text-danger" );
            jQuery("#i_a"+id2).addClass( "fa fa-check text-success" );    
    hideMeAutoLst();
}
function encuentravalor(datos, ident) {
    var asplit = datos[0].split("@:::@");
    var valor = "";
    for (var i = 0; i < asplit.length; i++) {
        var asplit2 = asplit[i].split("@===@");
        if (asplit2[0] == ident)
            valor = asplit2[1];
    }
    return valor;
}
function formatofecha(cadena) {
    var axu = cadena.split("-");
    return axu[2] + "/" + axu[1] + "/" + axu[0];
}
function setValueSelect(SelectId, Value) {
    // alert('entraaa');
    SelectObject = document.getElementById(SelectId);
    for (index = 0; index < SelectObject.length; index++) {
        if (SelectObject[index].value == Value)
            SelectObject.selectedIndex = index;
    }
}
        