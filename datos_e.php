<?php

session_start();
include_once("lib/lib_function.php");
include_once("config/cfg.php");
include_once("lib/lib_pgsql.php");
include_once("lib/lib_entidad.php");
$strMsgErrorAll = array();
$strMsgErrorAll[] = "NO se encontraron coincidencias ";
$a_vals = explode("::", trim($_POST['varval']));
$apellidos = explode(',', trim($_POST['varval']));
//echo "<pre>";
//print_r($a_vals);
//print_r($_POST);
$allf = array();
$allv = array();
$aLabels = array();
$aLabels[] = array('Apellido Paterno', 'Apellido Materno', 'Numero de Casa', 'Numero de Familia', 'Numero de Manzana', 'Localidad', 'Clave Ageb', 'Calle', 'Referencia', 'Colonia', 'Numero de Folio');
$allf[] = array('p_ape', 's_ape', 'no_casa', 'no_inter', 'no_manzana', 'localidad', 'cve_ageb', 'calle', 'otr_ref', 'colonia', 'no_folio');
$allv[] = array('', '', '', '', '', '', '', '', '', '', '');



$objname = array();
$objname[] = 'apellido';
$strAdd = array();
$strFields = array();
$strFields[] = "a.p_ape, a.s_ape, a.no_casa, a.no_inter, a.no_manzana,l.localidad,a.cve_ageb,a.calle,a.otr_ref,a.colonia,a.no_folio ";
$strStyle = array();
$strTbl = array();
$strTbl[] = ' casa a LEFT JOIN localidad l ON a.cve_localidad = l.cve_localidad';
$strQry = array();
$strQry[] = " Where l.cve_localidad = '" . $apellidos[2] . "' and l.cve_jurisdiccion = '" . $__SESSION->getValueSession('cvejurisdiccion') . "' and l.cve_municipio = '" . $__SESSION->getValueSession('cvemunicipio') . "' and a.p_ape ";


$fieldCond = array();
$fieldCond[] = array('a.p_ape', 'a.s_ape');
//$fieldCond[]=array('cve_estado','cve_municipio');


$strStyle[] = 'style="color:#669900;"';
$strStyle[] = 'style="color:#669900;"';
$strStyle[] = 'style="color:#669900;"';
$strStyle[] = 'style="color:#669900;"';
$strStyle[] = 'style="color:#669900;"';
$strStyle[] = 'style="color:#669900;"';
$strStyle[] = 'style="color:#669900;"';
$consulWhere = $strQry[$_POST['numAdd']];
foreach ($fieldCond[$_POST['numAdd']] as $cont_val => $item_name) {
    if ($cont_val == 0) {
        $consulWhere .= " like ('%" . trim($apellidos[$cont_val]) . "%')";
    } else {
        $consulWhere .= " and a.s_ape like ('%" . trim($apellidos[$cont_val]) . "%')";
    }
}

$classval = new Entidad($allf, $allv);
$classval->ListaEntidades(array('p_ape'), $strTbl[$_POST['numAdd']], $consulWhere, $strFields[$_POST['numAdd']]);


if ($classval->NumReg > 0) {
    for ($i = 0; $i < $classval->NumReg; $i++) {
        $classval->VerDatosEntidad($i, $allf[$_POST['numAdd']]);

        $consulWheret = "  " . $consulWhere . " and c.no_folio = '" . $classval->no_folio . "' ";
        $classval2 = new Entidad(array('nombre', 'ap_pat', 'ap_mat', 'cve_sexo', 'fecha_nacimiento'), array('', '', '', '', ''));
        $classval2->ListaEntidades(array('nombre'), 'integrante a LEFT JOIN localidad l ON a.cve_localidad = l.cve_localidad LEFT JOIN casa c ON a.no_folio = c.no_folio', str_replace("a.s_ape", "c.s_ape", str_replace("a.p_ape", "c.p_ape", $consulWheret)), 'nombre,ap_pat,ap_mat,cve_sexo,fecha_nacimiento');
        $aLabels2 = array('nombre', 'ap_pat', 'ap_mat', 'genero', 'fecha_nacimiento');
        
//        echo '<pre>';
//        print_r($classval2);die();
        echo genOTable(0, '500', '', '', '', '2', '1'); /* ,'right' */
        foreach ($allf[$_POST['numAdd']] as $cnt_item => $item) {

            echo genORen();
            echo genCol($aLabels[$_POST['numAdd']][$cnt_item] . " :", '', '', '', $CFG_BGC[7], '', '', 'separ_verde rounded');
            echo genCol($classval->$item, ($cnt_item == 10 ? 2 : ''), '', '', $CFG_BGC[4], '', '', 'separ_verde_claro rounded');
            if ($cnt_item == 0) {
                for ($j = 0; $j < $classval2->NumReg; $j++) {
                    $classval2->VerDatosEntidad($j, array('nombre', 'ap_pat', 'ap_mat', 'cve_sexo', 'fecha_nacimiento'));
                    $integrantes = $classval2->nombre . " " . $classval2->ap_pat . " " . $classval2->ap_mat . " " . ($classval2->cve_sexo == 1?'H':'M') . " " . $classval2->fecha_nacimiento;
                    if ($j == 0) {
                        echo genOCol('', '', '', $CFG_BGC[4], '', '', $CFG_LBL[30], 10) . genOTable(0, '100%', '', 'border-0', $CFG_BGC[6], '2', '1');
                        echo genOren() . genCol("INTEGRANTES", '', '', '', $CFG_BGC[7], '', '', 'separ_verde rounded') . genCRen() . " \n";
                    }
                    echo genORen() . genCol(strtoupper($integrantes), '', '', '', $CFG_BGC[9], '', '', 'separ_verde_claro rounded') . genCRen() . " \n";
                }
                if ($classval2->NumReg > 0) {
                    echo genCTable() . genCCol();
                }
            }
        }
        echo genCTable();
        echo '<form action="./index.php?mod=14" method="post" name="ftemp">
			<input type="hidden" id="txtsearch" name="txtsearch" value="' . $classval->no_folio . '" />
			<input type="hidden" id="selsearch" name="selsearch" value="srch04" />
			<input type="hidden" id="op" name="op" value="1" />
			<input type="hidden" id="nivPo" name="nivPo" value="0" />
			<input id="btnSearch" name="btnSearch" type="submit" class="btn boton_war punteados" value="Actualizar" /> </form>';
    }
} else {
    echo genOTable(0, '', '', '', $CFG_BGC[6], '2', '1'); /* ,'right' */
    echo genORen() . genCol("No existen familias registradas que coincidan con ", '', '', '', $CFG_BGC[7], '', '', $CFG_LBL[30]) . genCol(strtoupper($apellidos[0] . " " . $apellidos[1]), '', '', '', $CFG_BGC[7], '', '', $CFG_LBL[29]) . genCRen() . " \n";
    echo genCTable();
}
?>
