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
