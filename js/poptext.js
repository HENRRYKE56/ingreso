
var theObj = "";
function toolTip(text, me, title, target, liga, obj, numpar, numAdd) {
    theObj = me;
    theObj.onmousemove = updatePos;
    document.getElementById('toolTipBox').innerHTML = "" +
            "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" " +
            "<tr><td class=\"titleToolTipBox\" width=\"288\">" + title + "</td>" +
            "<td class=\"closeToolTipBox\" size=\"12\"><a id=\"aClose\" href=\"#\" onclick=\"hideMe();\">[X]</a></td></tr>" +
            "<tr><td class=\"bodyToolTipBox\" colspan=\"2\"><span id=\"contentToolTipBox\"" > +
            text +
            "</span></td></tr></table>";
    document.getElementById('toolTipBox').style.display = "block";
    window.onscroll = updatePos;
    getDatos(target, liga, obj, numpar, numAdd, title);

}
function toolTipAdd(text, me, title, target, liga, obj, numpar, numAdd, modPar) {
    theObj = me;
    theObj.onmousemove = updatePos;
    document.getElementById('toolTipBox').innerHTML = "" +
            "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" " +
            "<tr><td class=\"titleToolTipBox\" width=\"288\">" + title + "</td>" +
            "<td class=\"closeToolTipBox\" size=\"12\"><a id=\"aClose\" href=\"#\" onclick=\"hideMe();\">[X]</a></td></tr>" +
            "<tr><td class=\"bodyToolTipBox\" colspan=\"2\"><span id=\"contentToolTipBox\"" > +
            text +
            "</span></td></tr></table>";
    document.getElementById('toolTipBox').style.display = "block";
    window.onscroll = updatePos;
    getWindowAdd(target, liga, obj, numpar, numAdd, title, modPar);

}
function toolTipAdd2(text, me, title, target, liga, obj, numpar, numAdd, modPar) {
//theObj=me;
//theObj.onmousemove=updatePos;

    $("#tit_pag_dialog").html("" + title);//text
//var con_html='<div class="container-fluid">' +
//                '<div class="row">'+
//                    '<div class="col-12 col-sm-12">'+text
//                    '</div>'+
//                '</div>'+
//             "</div>";
//$("#bod_pag_dialog").html(""+con_html);
//$('#pag_dialog ').modal('show');

    getWindowAdd2(target, liga, obj, numpar, numAdd, title, modPar);
}
function toolTipAdd3(text, me, title, target, liga, obj, numpar, numAdd, modPar) {
    $("#tit_pag_dialog").html("" + title);//text
    getWindowAdd3(target, liga, obj, numpar, numAdd, title, modPar);
}
function toolTipAdd3_inner(text, me, title, target, liga, obj, numpar, numAdd, modPar, objSource) {
    theObj = me;
    str = "#";
//str=objSource.replace("div", "#lnk");
    document.getElementById(objSource).innerHTML = "" +
            "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >" +
            //"<tr><td class=\"titleToolTipBox\" >"+ title +"</td>" + 
            "<tr><td class=\"closeToolTipBox\"><a id=\"aClose\" href=\"" + str + "\" onclick=\"clearMe('" + objSource + "');\">Cerrar</a></td></tr>" +
            "<tr><td class=\"bodyToolTipBox\" colspan=\"2\"><span id=\"contentToolTipBox\"" > +
            text +
            '</span></td></tr></table>';
    getWindowAdd3_inner(objSource, liga, obj, numpar, numAdd, title, modPar);
}
function updatePos() {
    var ev = arguments[0] ? arguments[0] : event;
    var x = ev.clientX;
    var y = ev.clientY;
    if (y < 250)
        diffTop = y / 2;
    else
        diffTop = 250;
    diffX = 24;
    diffY = 0;
    document.getElementById('toolTipBox').style.top = y - diffTop + diffY + document.body.scrollTop + "px";
    document.getElementById('toolTipBox').style.left = x - 2 + diffX + document.body.scrollLeft + "px";
//theObj.onClick=hideMe;
}
function hideMe() {
    document.getElementById('toolTipBox').style.display = "none";
}

function getWindowAdd(target, liga, obj, numpar, numAdd, title, modPar) {
    cadena = '';
    if (varval = document.getElementById(obj).value) {
        cadena = 'objname=' + obj + '&varval=' + varval + '&numpar=' + numpar + '&numAdd=' + numAdd + '&modPar=' + modPar;
        selftarget = target;
        selflink = liga + '.php';
        cargar_toolTip(selftarget, selflink, cadena, title);
    }
}
function getWindowAdd2(target, liga, obj, numpar, numAdd, title, modPar) {
    cadena = '';
    //if(varval=document.getElementById(obj).value){
    varval = numpar;
    cadena = 'objname=' + obj + '&varval=' + varval + '&numpar=' + numpar + '&numAdd=' + numAdd + '&modPar=' + modPar;
    selftarget = target;
    selflink = liga + '.php';
    cargar_toolTip(selftarget, selflink, cadena, title);
    //}

}
function getWindowAdd3(target, liga, obj, numpar, numAdd, title, modPar) {
    cadena = '';
    //if(varval=document.getElementById(obj).value){
    varval = numpar;
    cadena = 'objname=' + obj + '&varval=' + varval + '&numpar=' + numpar + '&numAdd=' + numAdd + '&modPar=' + modPar;
    selftarget = target;
    selflink = liga + '.php';
    cargar_toolTip2(selftarget, selflink, cadena, title);
    //}

}
function getWindowAdd3_inner(target, liga, obj, numpar, numAdd, title, modPar) {
    cadena = '';
    //if(varval=document.getElementById(obj).value){
    varval = numpar;
    cadena = 'objname=' + target + '&varval=' + varval + '&numpar=' + numpar + '&numAdd=' + numAdd + '&modPar=' + modPar;
    selftarget = target;
    selflink = liga + '.php';
    cargar_toolTip2_inner(selftarget, selflink, cadena, title, true, 700);
    //}
}
function getDatos(target, liga, obj, numpar, numAdd, title) {
    cadena = '';
    if (varval = document.getElementById(obj).value) {
        cadena = 'objname=' + obj + '&varval=' + varval + '&numpar=' + numpar + '&numAdd=' + numAdd;
        selftarget = target;
        selflink = liga + '.php';
        cargar_toolTip(selftarget, selflink, cadena, title);
    }
}
function sendAdm() {
    var cadena = '', xname = '', i, args = sendAdm.arguments;

    if (document.obj_retVal) {
        for (i = 5; i < (args.length); i++) {
            xname = args[i];
            val = findObj(args[i]);
            if (val) {
                if (val.value.trim() != "") {
                    if (cadena.length != 0)
                        cadena += "&";
                    cadena += xname + "=" + val.value.trim();
                }
            }
        }

        if (cadena.length != 0) {
            val = findObj(args[2]);
            if (val) {
                if (val.value.trim() != "") {
                    cadena += '&objname=' + args[2] + '&varval=' + val.value.trim();
                }
            }
            cadena += '&numpar=' + args[3] + '&numAdd=' + args[4];
            selftarget = "div_" + args[0];
            selflink = args[1] + '.php';
            cargar_general(selftarget, selflink, cadena);
        }
        hideMe();
        document.obj_retVal = false;
    }
}
function sendAdm2() {

    var cadena = '', xname = '', i, args = sendAdm2.arguments;

    if (document.obj_retVal) {
        frm = findObj('frmadd_ligth');
        for (i = 5; i < (args.length); i++) {
            xname = args[i];//val=findObj(args[i]);

            if (frm.elements[args[i]]) {
                if (frm.elements[args[i]].value.trim() != "") {
                    if (cadena.length != 0)
                        cadena += "&";
                    cadena += xname + "=" + frm.elements[args[i]].value.trim();
                }
            }
        }
        if (cadena.length != 0) {
            //val=findObj(args[2]);
            //if (val) {if (val.innerHTML.trim()!="") {cadena += '&objname='+ args[2] +'&varval=' + val.innerHTML.trim();}}
            cadena += '&objname=' + args[2] + '&varval=0';
            cadena += '&numpar=' + args[3] + '&numAdd=' + args[4];
            selftarget = args[0];
            selflink = args[1] + '.php';
            cargar_general(selftarget, selflink, cadena);
        }
        hideMe_bob();
    }
}
function hideMe_bob() {
    $('#pag_dialog ').modal('hide');

}
function clearMe(theObjClear) {
document.getElementById(theObjClear).innerHTML="";
}