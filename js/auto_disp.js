// JavaScript Document
var lista1 = "";
var f = -1;
var c = 0;
var activo_item = [0, 0];
var des_item = [0, 0];
var c_max = 0;
var f_max = 0;
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
    var fill = document.getElementsByClassName('webui-popover-content');
    for (var i = 6; i <= (args.length - 1); i++) {
        if (args[i].indexOf("sendObj_") != -1) {
            xPos = args[i].indexOf("sendObj_");
            val = findObj(args[i].substring(xPos + 8));
            if (contObj == 0) {
                theObj = val;
            }
            jQuery("#i_a" + args[i].substring(xPos + 8)).removeClass("fa fa-check text-success");
            jQuery("#i_a" + args[i].substring(xPos + 8)).addClass("fa fa-times text-danger");
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
    if (texto != null && texto != "" && keynum != 37 && keynum != 38 && keynum != 39 && keynum != 40 && keynum != 13 && keynum != 27 && keynum != 36 && keynum != 35) {
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
                jQuery("#" + theObj.id).webuiPopover('destroy');

                jQuery('#' + theObj.id).webuiPopover({
                    placement: 'bottom',
                    title: '<div><div style="display: inline-block;width:70%;"><strong>Resultados de busqueda</strong></div>' + '<div style="display: inline-block;width:30%;text-align:right;"><button onclick="hideMeAutoLst();" style="background-color: transparent;" type="submit" class="btn punteados b_s_sys_p" data-toggle="tooltip" title="Nuevo"><i style="font-size:21px;" aria-hidden="true" class="fa fa-times text-danger"></i></button></div>' + '</div>',
                    width: 500,
                    height: 210,
                    padding: false,
                    animation: 'pop',
                    content: html_l,
                    html: true,
                    onHide: function (element) {
                        f = -1;
                        c = 0;
                        activo_item = [0, 0];
                        des_item = [0, 0];
                        theObj.setAttribute(
                                'aria-activedescendant',
                                ''
                                );
                    },
                });
                fill = document.getElementsByClassName('webui-popover-content');

                jQuery("#" + theObj.id).webuiPopover('show');
                if (v_tc == 1) {
                    $(".div_tabla_sys_pop").addClass('oscuro_bread');
                    $(".card_sys_pop").addClass("oscuro_3");
                    $(".b_s_sys_p, .b_s_sys_p *").addClass("oscuro_b");
                    $(".b_s_sys_p").addClass("punteados_s");
                }else if(v_tc == 2){
                    $(".div_tabla_sys_pop").addClass('claro_bread');
                    $(".card_sys_pop").addClass("claro_3");
                    $(".b_s_sys_p, .b_s_sys_p *").addClass("claro_b");
                    $(".b_s_sys_p").addClass("punteados_l");                    
                }else if(v_tc == 0){
                    $(".div_tabla_sys_po").removeClass("oscuro_bread");
                    $(".card_sys_pop").removeClass("oscuro_3");
                    $(".b_s_sys_p, .b_s_sys_p *").removeClass("oscuro_b");
                    $(".b_s_sys_p").removeClass("punteados_s");
                    
                    $(".div_tabla_sys_po").removeClass("claro_bread");
                    $(".card_sys_pop").removeClass("claro_3");
                    $(".b_s_sys_p, .b_s_sys_p *").removeClass("claro_b");
                    $(".b_s_sys_p").removeClass("punteados_l");                    
                }


                jQuery("#" + theObj.id).attr('aria-expanded', 'true');

            };
            myConn.connect(selflink, "POST", cadena, peticion);
        } else {
            hideMeAutoLst();
            if (document.theObjValid.length > 0) {
                xSpan = document.getElementById("e_" + document.theObjValid);
                setMsgSpan(xSpan, '<img src="img/img43.gif" border="0" >', '#FF0000');
            }
        }
    }
    if (keynum == 37) { // Izquierda  
        if (theObj.value != "") {
            if (f_max > 0 && f > -1) {//seleccionaFilling(type,f_param,c_param,opc) {
                seleccionaFilling(2, null, null, 'izquierda');
                $(".webui-popover-content").scrollTop(f * 26.6);
            }

        }
    } else if (keynum == 38) { // Arriba 
        if (theObj.value != "") {
            if (f_max > 0) {//seleccionaFilling(type,f_param,c_param,opc) {
                seleccionaFilling(2, null, null, 'arriba');
                $(".webui-popover-content").scrollTop(f * 26.6);
            }

        }
    } else if (keynum == 39) { // Derecha
        if (theObj.value != "") {
            if (f_max > 0 && f > -1) {//seleccionaFilling(type,f_param,c_param,opc) {
                seleccionaFilling(2, null, null, 'derecha');
                $(".webui-popover-content").scrollTop(f * 26.6);
            }

        }
    } else if (keynum == 40) { // Abajo
        if (theObj.value != "") {
            if (f_max > 0) {//seleccionaFilling(type,f_param,c_param,opc) {
                seleccionaFilling(2, null, null, 'abajo');
                $(".webui-popover-content").scrollTop(f * 26.6);
            }

        }
    } else if (keynum == 8) { // Borrar 
        posicionListaFilling = -1;
    } else if (keynum == 13) {//enter
        seleccionaTextoFilling('tr' + theObj.id, f, 'fnAfterSelected', theObj.id);
    } else if (keynum == 27) {//esc 
        if (fill) {
            hideMeAutoLst();
            jQuery('#' + theObj.id).val("");
        }
    } else if (keynum == 36) {//inicio
        if (fill) {
            posicionListaFilling != -1 ? document.getElementById('tr' + theObj.id + (posicionListaFilling)).className = "fill_auto_disp_h" : 0;
            posicionListaFilling = -1;
            $(".webui-popover-content").scrollTop(0 * 26.6);
            seleccionaFilling('tr' + theObj.id, (posicionListaFilling + 1));
        }
    } else if (keynum == 35) {//end
        if (fill) {
            posicionListaFilling != -1 ? document.getElementById('tr' + theObj.id + (posicionListaFilling)).className = "fill_auto_disp_h" : 0;
            $(".webui-popover-content").scrollTop((listaE.length - 1) * 26.6);
            seleccionaFilling('tr' + theObj.id, (listaE.length - 1));
        }
    } else {// escribiendo
        posicionListaFilling = -1;
        if (fill) {
            $(".webui-popover-content").scrollTop(0);
            //fill.scrollTop = 0;
        }

    }
}
function hideMeAutoLst() {
    jQuery('#' + theObj.id).webuiPopover('destroy');
    jQuery("#" + theObj.id).attr('aria-expanded', 'false');
}

//function escribeLista(lista) {
//    var html = "";
//    listaE = lista;
//    lista1 = lista;
//    if (lista.length == 0) {
//        hideMeAutoLst();
//        document.notBussyKeyEnter = true;
//    } else {
//        document.notBussyKeyEnter = false;
//        var html = '<div><table class="table color_negro tabla_sys_en rounded" >';
//        if (document.aTitles.length > 0) {
//            html += "<thead class='separ_rojo_medio'><tr>";
//            for (var i = 0; i < document.aTitles.length; i++) {
//                html += "<th scope='col' class=\"titleToolTipBox_m oscuro_1\" style=\"width:" + (document.aTitles[i].width) + "px" + ";\">" + document.aTitles[i].title + "</th>"
//            }
//            html += "</tr><thead>";
//        }
////			var html='<table bgcolor="#FFFFFF" cellspacing="1" ' + 'cellpadding="3" border="0" width="100%">';
//        arrayTarget = document.strTarget.split(";");
//        html += '<tbody aria-labelledby="l_' + theObj.id + '" role="grid" id="popover_webui_acce">';
//        var row = 0;
//        f_max = lista.length;
//        for (var i = 0; i < lista.length; i++) {
//            html += '<tr role="row" class="table_hover_cab table_hover_sys table_hover_oscuro"  id="tr' + theObj.id + i +
//                    '" ' +
//                    ' class="row_' + i + '"  ' +
//                    ' onmousedown="seleccionaTextoFilling(\'tr' +
//                    theObj.id + '\', ' + i + ',\'fnAfterSelected\',\'' + theObj.id + '\');">';
//            arraysplit = lista[i].split("@:::@");
//            c_max = arraysplit.length;
//            var scope_r = " scope='row' ";
//            for (var ih = 0; ih < arraysplit.length; ih++) {
//                arraysplit2 = arraysplit[ih].split("@===@");
//                if (i < 10)
//                    idname = '0' + i;
//                else
//                    idname = i;
//                if (ih == 0) {
//                } else
//                    (scope_r = "");
//                html += '<td ' + scope_r + ' role="gridcell" onmouseover="seleccionaFilling(1,' + i + ',' + ih + ')" class=" row_' + i + '_' + ih + '" id=\'' + idname + '_' + ih + '_' + arraysplit2[0] + '\'>' + arraysplit2[1] + '</td>';
//            }
//            html += '</tr>';
//        }
//        html += "</tbody>";
//        html += '</table><div>';
//    }
//    return html;
//}


function escribeLista(lista) {
    var html = "";
    var ar_th=['','oscuro_1','claro_1'];
    listaE = lista;
    lista1 = lista;
    if (lista.length == 0) {
        hideMeAutoLst();
        document.notBussyKeyEnter = true;
    } else {
        document.notBussyKeyEnter = false;
        var html = '<div><table class="table table-hover color_negro tabla_sys_en rounded" >';
        if (document.aTitles.length > 0) {
            html += '<thead><tr class="bg-success">';
            for (var i = 0; i < document.aTitles.length; i++) {
                html += "<th scope='col' class=\"titleToolTipBox_m "+ar_th[v_tc]+"\" style=\"width:" + (document.aTitles[i].width) + "px" + ";\">" + document.aTitles[i].title + "</th>"
            }
            html += "</tr><thead>";
        }
//			var html='<table bgcolor="#FFFFFF" cellspacing="1" ' + 'cellpadding="3" border="0" width="100%">';
        arrayTarget = document.strTarget.split(";");
        html += '<tbody aria-labelledby="l_' + theObj.id + '" role="grid" id="popover_webui_acce">';
        var row = 0;
        f_max = lista.length;
        var ar_tha=['','table_hover_oscuro','table_hover_claro'];
        for (var i = 0; i < lista.length; i++) {
            html += '<tr role="row" class="table_hover_cab table_hover_sys '+ar_tha[v_tc]+' "  id="tr' + theObj.id + i +
                    '" ' +
                    ' class="row_' + i + '"  ' +
                    ' onmousedown="seleccionaTextoFilling(\'tr' +
                    theObj.id + '\', ' + i + ',\'fnAfterSelected\',\'' + theObj.id + '\');">';
            arraysplit = lista[i].split("@:::@");
            c_max = arraysplit.length;
            var scope_r = " scope='row' ";
            for (var ih = 0; ih < arraysplit.length; ih++) {
                arraysplit2 = arraysplit[ih].split("@===@");
                if (i < 10)
                    idname = '0' + i;
                else
                    idname = i;
                if (ih == 0) {
                } else
                    (scope_r = "");
                html += '<td ' + scope_r + ' role="gridcell" onmouseover="seleccionaFilling(1,' + i + ',' + ih + ')" class=" row_' + i + '_' + ih + '" id=\'' + idname + '_' + ih + '_' + arraysplit2[0] + '\'>' + arraysplit2[1] + '</td>';
            }
            html += '</tr>';
        }
        html += "</tbody>";
        html += '</table><div>';
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
    for (var i = 0; i < arrayTarget.length; i++) {
        document.getElementById(arrayTarget[i]).value = document.getElementById(idname + '_' + i + '_' + arrayTarget[i]).innerHTML;


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
    } else {
        document.getElementById(arrayTarget[0]).select();
    }
    document.notBussyKeyEnter = true;
    if (document.theObjValid.length > 0) {
        xSpan = document.getElementById("e_" + document.theObjValid);
        setMsgSpan(xSpan, " Ok" + '&nbsp;&nbsp;<img src="img/img45.gif" border="0" >', '#99CC00');
    }
}
function seleccionaFilling(type, f_param, c_param, opc) {
    if (type == 1) {
        f = f_param;
        c = c_param;
    } else if (type == 2) {
        switch (opc) {
            case "abajo":
                f++;
                break;
            case "arriba":
                f--;
                break;
            case "derecha":
                c++;
                break;
            case "izquierda":
                c--;
                break;
        }
        verfica_item(f, c);
    }
    des_item = activo_item;
    activo_item = [f, c];
    $(".row_" + des_item[0]).removeClass("fill_auto_disp_con").addClass("fill_auto_disp_sin");

    $(".row_" + activo_item[0]).removeClass("fill_auto_disp_sin").addClass("fill_auto_disp_con");

    $(".row_" + des_item[0] + "_" + des_item[1]).removeClass("punteados_auto_con").addClass("punteados_auto_sin");
    $(".row_" + activo_item[0] + "_" + activo_item[1]).removeClass("punteados_auto_sin").addClass("punteados_auto_con");

    var desacc = document.getElementsByClassName("row_" + des_item[0] + "_" + des_item[1]);
    desacc = desacc[0];
    desacc.setAttribute('aria-selected', 'false');

    var actual = document.getElementsByClassName("row_" + activo_item[0] + "_" + activo_item[1]);
    actual = actual[0];
    theObj.setAttribute(
            'aria-activedescendant',
            actual.id
            );
    actual.setAttribute('aria-selected', 'true');
//    document.getElementById(id + n).className = "fill_auto_disp";
//    var actual=document.getElementsByClassName('row_'+n+"_"+0);
//    actual=actual[0];
//   // alert(actual.id); 00_0_des_modulo_padre
//    theObj.setAttribute(
//      'aria-activedescendant',
//      actual.id
//    );   
//    $("#"+actual.id).addClass("punteados_auto");
//    actual.setAttribute('aria-selected','true');
//    // console.log('tr' + theObj.id+" "+(posicionListaFilling));
//    if (n == posicionListaFilling || posicionListaFilling < 0) {
//    }
//    else
//        document.getElementById(id + (posicionListaFilling < 0 ? 0 : posicionListaFilling)).className = "fill_auto_disp_h";
//    posicionListaFilling = n;
}
function verfica_item(f_p, c_p) {
    var entra = false;
    if (f_p == f_max) {
        f = 0;
        c = c_p;
        entra = true;
    }
    if (f_p < 0) {
        f = f_max - 1;
        c = c_p;
        entra = true;
    }
    if (c_p == c_max) {
        var f_p_aux = f_p + 1;
        var ar_i = verfica_item(f_p_aux, 0);
        f = ar_i[0];
        c = ar_i[1];
        entra = true;
    }
    if (c_p < 0) {
        var f_p_aux = f_p - 1;
        var ar_i = verfica_item(f_p_aux, c_max - 1);
        f = ar_i[0];
        c = ar_i[1];
        entra = true;
    }
    if (!entra) {
        f = f_p;
        c = c_p;
    }
    return [f, c];
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
    jQuery("#i_a" + id2).removeClass("fa fa-times text-danger");
    jQuery("#i_a" + id2).addClass("fa fa-check text-success");
    theObj.setAttribute(
            'aria-activedescendant',
            '');
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
        