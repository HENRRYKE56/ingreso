$(document).ready(function () {
    $( "#rec_passw" ).click(function() {
        var correo = $('#txtnomusuario_r').val();
        if (correo.trim() == 0) {
            alertify.error('Ingrese usuario');
            $("#txtnomusuario_r").focus();
            return false;
        } else {
            if (!validarEmail(correo)) {
                alertify.error('Ingrese usuario valido');
                $("#txtnomusuario_r").focus();
                return false;
            }
        }
        var datos="type=r_p";
            datos+="&user="+correo;
                $.ajax({
                    url: 'e_p.php',
                    type: 'POST',
                    dataType: 'json',
                    data: datos,
                    beforeSend: function() {
                        $('#ocultar_load_').addClass('fa fa-spinner fa-spin');
                        $('#rec_passw').attr('disabled','disabled');
                    },
                    success: function (response) {//echo json_encode(array('successful' => $success, 'estado' => $estado_proceso));
                            if(response.successful=='true'){
                            //logout  'logout'=>$logout
                            if(response.estado=='1'){
                                alertify.success("Se envio correo ! Proceso completo!");
                            }else{
                                alertify.error("No hay concidencias");
                            }

                        }else{
                            alertify.error("bondad al generar pass");
                        }
                       // alertify.success("! el registro se guardo!");
                    }, error: function (e) {
                        alertify.error("bondad al recuperar ");
                    },
                    complete: function() {
                        $('#ocultar_load_').removeClass('fa fa-spinner fa-spin');
                        $('#rec_passw').removeAttr('disabled');
                    },
                });            
        return false;
    }); 
});
function manda_correo(mail){
        var correo = $('#'+mail).val();
        if (correo.trim() == 0) {
            alertify.error('Ingrese correo');
            $("#correo_r").focus();
            return false;
        } else {
            if (!validarEmail(correo)) {
                alertify.error('Ingrese correo valido');
                $("#correo_r").focus();

            }
        }

}
function validarEmail(valor) {
    var retorna=false;
    if ((valor.trim()).length >=4) {
        retorna=true;
    }
    return retorna;
}