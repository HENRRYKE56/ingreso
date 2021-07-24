// JavaScript Document

// Esta ya no es necesaria, despues de las pruebas se puede borrar 23-6-2003
function validaCURP2(curp){
	var segRaiz = "";
	var digVer  = "";
	var lngSuma      = 0.0;
	var lngDigito    = 0.0;
	var strDigitoVer = "";
	var intFactor    = new Array(17);
	var chrCaracter  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";

	segRaiz = curp.substring(0,17);
	digVer  = curp.substring(17,18);
	
	for(var i=0; i<17; i++)
	{
		for(var j=0;j<37; j++)
		{
			if(segRaiz.substring(i,i+1)==chrCaracter.substring(j,j+1))
			{  				
				intFactor[i]=j;
			}
		}
	}
	
	for(var k = 0; k < 17; k++)
	{
		lngSuma= lngSuma + ((intFactor[k]) * (18 - k));
	}
	
	lngDigito= (10 - (lngSuma % 10));
	
	if(lngDigito==10)
	{
		lngDigito=0;
	}

	var reg = /[A-Z]{4}\d{6}[HM][A-Z]{2}[B-DF-HJ-NP-TV-Z]{3}[A-Z0-9][0-9]/;
	if(curp.search(reg))
	{
		alert("La curp: " + curp + " no es valida, verifiqué ");
		return false;
		
	}
	
	if(!(parseInt(lngDigito)==parseInt(digVer)))
	{
		alert("La curp: " + curp + " no es valida, revisé el Digito Verificador (" +  lngDigito + ")");
		return false;
	}
	return true;
}
/* ******************************************************************************************* */
function validaCURP(curpval){
	/*alert("HOLA MUNDO");*/
//document.form1.outstring.value = document.form1.instring.value.toUpperCase();
var curpa=document.getElementById('curp').value;

document.getElementById('curp').value=curpa.toUpperCase();
	var reg = "";
	
	if(curpval.length > 18)
	{
		var digito = calculaDigito(curpval);
		
		reg = /[A-Z]{4}\d{6}[HM][A-Z]{2}[B-DF-HJ-NP-TV-Z]{3}[A-Z0-9][0-9]/;

		if(curpval.search(reg))
		{
		//	alert("La curp: " + curpval + " no es valida, verifiqué ");
			return false;
			
		}
		
		if(!(parseInt(digito) == parseInt(curpval.substring(17,18))))
		{
		//	alert("La curp: " + curpval + " no es valida, revisé el Digito Verificador (" +  digito + ")");
			return false;
		}
		return true;
	}
	else
	{
		switch (curpval.length) 
		{
		
			//case 0 :
				//alert("La curp: " + curpval + " no es valida, verifiqué ");				
				//break;
				
			case 1 :
		//		alert("La curp: " + curpval + " no es valida, verifiqué ");
				
				break;
			case 2 :
		//		alert("La curp: " + curpval + " no es valida, verifiqué ");
				break;
			case 3 :
		//		alert("La curp: " + curpval + " no es valida, verifiqué ");
				break;
			case 4 :
		//		alert("La curp: " + curpval + " no es valida, verifiqué ");
				break;
			case 5 :
		//		alert("La curp: " + curpval + " no es valida, verifiqué ");
				break;
			case 6 :
		//		alert("La curp: " + curpval + " no es valida, verifiqué ");
				break;
			case 7 :
		//		alert("La curp: " + curpval + " no es valida, verifiqué ");
				break;
			case 8 :
		//		alert("La curp: " + curpval + " no es valida, verifiqué ");
				break;
			case 9 :
		//		alert("La curp: " + curpval + " no es valida, verifiqué 18 digitos");
				break;
				
			case 10 :
				reg = /[A-Z]{4}\d{6}/;
				break;
			case 11 :
				reg = /[A-Z]{4}\d{6}[HM]/;
				break;
			case 12 :
				reg = /[A-Z]{4}\d{6}[HM][A-Z]/;
				break;
			case 13 :
				reg = /[A-Z]{4}\d{6}[HM][A-Z]{2}/;
				break;
			case 14 :
				reg = /[A-Z]{4}\d{6}[HM][A-Z]{2}[B-DF-HJ-NP-TV-Z]/;
				break;
			case 15 :
				reg = /[A-Z]{4}\d{6}[HM][A-Z]{2}[B-DF-HJ-NP-TV-Z]{2}/;
				break;
			case 16 :
				reg = /[A-Z]{4}\d{6}[HM][A-Z]{2}[B-DF-HJ-NP-TV-Z]{3}/;
				break;
			case 17 :
				reg = /[A-Z]{4}\d{6}[HM][A-Z]{2}[B-DF-HJ-NP-TV-Z]{3}[A-Z0-9]/;
				break;
		}
	
		if(curpval.search(reg))
		{
		//	alert("La curp: " + curpval + " no es valida, verifiqué ");
			return false;
		}else{
			//alert("La curp: " + curpval + " es valida");
			    var today = new Date();
    			var dd = today.getDate();
    			var mm = today.getMonth()+1; //January is 0!
			    var yyyy = today.getFullYear();
				if(dd<10){
					dd='0'+dd
				} 
				if(mm<10){
					mm='0'+mm
				} 
				var today = dd+'/'+mm+'/'+yyyy;
				var anio_compara=today.substring(8,10);//2000				
				var anio_curpc=curpval.substring(4,6);//1900
				//alert(anio_curpc);
					if(anio_curpc<=anio_compara){
						var anio_val_c=20;
						}else{
						var anio_val_c=19;
						}
						
			
			if (curpa.length==18){
			document.getElementById('fecha_nacimiento').value=anio_val_c+curpval.substring(4,6)+"-"+curpval.substring(6,8)+"-"+curpval.substring(8,10);
			document.getElementById('sexo').value=curpval.substring(10,11);
			}
			
			return true;
		}
	}
}

/* ******************************************************************************************* */
function calculaDigito(curp){
	var segRaiz      = curp.substring(0,17);
	var chrCaracter  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
	var intFactor    = new Array(17);
	var lngSuma      = 0.0;
	var lngDigito    = 0.0;
	
	for(var i=0; i<17; i++)
	{
		for(var j=0;j<37; j++)
		{
			if(segRaiz.substring(i,i+1)==chrCaracter.substring(j,j+1))
			{  				
				intFactor[i]=j;
			}
		}
	}
	
	for(var k = 0; k < 17; k++)
	{
		lngSuma= lngSuma + ((intFactor[k]) * (18 - k));
	}
	
	lngDigito= (10 - (lngSuma % 10));
	
	if(lngDigito==10)
	{
		lngDigito=0;
	}

	return lngDigito;
}
/* ******************************************************************************************* */

