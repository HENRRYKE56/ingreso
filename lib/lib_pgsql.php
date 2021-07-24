<?php

/**
  -----------------------------------------------------------------
  Definici&oacute;n de clase: PGSQL
  Utilizada para controlar las operaciones de gesti&oacute;n con una Base
  de Datos en PGSQL.
  -----------------------------------------------------------------
 */
class Pgsql {

    var $Host;
    var $User;
    var $Pwd;
    var $BaseDatos;
    var $Sql;
    var $RtaSql;
    var $Enlace;
    var $NumReg;
    var $RowsAfected;
    var $InfoQry;
    var $Error;
    var $ver_errores;
    var $crear_l_sys;

    function Pgsql($num_con) {
        global $CFG_HOST, $CFG_USER, $CFG_DBPWD, $CFG_DBASE, $sh_errores_sys, $crear_logs_sys;
        $this->Host = $CFG_HOST[$num_con];
        $this->User = $CFG_USER[$num_con];
        $this->Pwd = $CFG_DBPWD[$num_con];
        $this->BaseDatos = $CFG_DBASE[$num_con];
        $this->Sql = "";
        $this->RtaSql = "";
        $this->Enlace = null;
        $this->NumReg = 0;
        $this->RowsAfected = 0;
        $this->InfoQry = "";
        $this->Error = 0;
        $v_e = 0;
        if (isset($sh_errores_sys) && $sh_errores_sys == 1) {
            $v_e = 1;
        }
        $this->ver_errores = $v_e;
        $c_l_s = 0;
        if (isset($crear_logs_sys) && $crear_logs_sys == 1) {
            $c_l_s = 1;
        }
        $this->crear_l_sys = $c_l_s;
    }

    function Conectarse() {
        try {
            $this->Enlace = mysqli_connect($this->Host, $this->User, $this->Pwd, $this->BaseDatos);
            if ($this->Enlace === false) {
                echo 'Ha habido un error <br>' . mysqli_connect_error();
            } else {
                // echo 'Conectado a la base de datos';
            }
        } catch (Exception $e) {
            echo 'Excepción conectarse: ' . $ex->getMessage();
        }
    }

    function Desconectarse() {
        try {
            mysqli_close($this->Enlace);
        } catch (Exception $e) {
            echo 'Excepción desconect: ' . $ex->getMessage();
        }
    }

    function Consultar($continue = false) {
        global $CFG_CONFIG;
        try {
            $this->Error = 0;
            if ($this->Enlace->connect_errno) {
                echo "Algo paso en la conexión: " . $mysqli->connect_error;
            } else {
                $this->RtaSql = $this->Enlace->query($this->Sql);
                if (!$this->RtaSql) {
                    if ($CFG_CONFIG['errors']) {
                        echo "Ocurrio un error en <br>:\n" . $this->Sql . "<br>:\n";
                    }
                    echo "Ocurrio un error al tratar de accesar al servidor [C] <br>:\n";
                    if ($continue) {
                        $this->InfoQry = $this->Enlace->error;
                        $this->Error = 1;
                        return;
                    } else {
                        exit;
                    }
                }
            }
            $this->NumReg = $this->RtaSql->num_rows;
        } catch (Exception $ex) {
            echo 'Excepción consultar: ' . $ex->getMessage();
        }
    }

    function Actualizar() {
        try {
            $this->RowsAfected = 0;
            $this->InfoQry = "";
            $this->Error = 0;
            if ($this->Enlace->connect_errno) {
                echo "Algo paso en la conexión: " . $mysqli->connect_error;
            } else {
                $this->RtaSql = $this->Enlace->query($this->Sql);
                $this->InfoQry = mysqli_info($this->Enlace);
                if (!$this->RtaSql) {
                    echo "Ocurrio un error al tratar de accesar al servidor [A] <br>:\n";
                    echo "An error occured in <br>:\n" . $this->Sql;
                } else {
                    $this->RowsAfected = $this->Enlace->affected_rows;
                }
            }
        } catch (Exception $ex) {
            echo 'Excepción actualizar: ' . $ex->getMessage();
        }
    }

    function LeerCampo($campo, $num) {
        if (!mysqli_data_seek($this->RtaSql, $num))//ajustar puntero en la fila seleccionada true si existe|false
            return false;
        if (!($row = mysqli_fetch_array($this->RtaSql)))//generando un array asociativo, numerico
            return false;
        if (!array_key_exists($campo, $row))//verificando que exista el campo en el array
            return false;
        return $row[$campo];
        //return (mysql_result($this->RtaSql, $num, $campo));
    }

    function mysqli_result($result, $iRow, $field = 0) {
        if (!mysqli_data_seek($result, $iRow))//ajustar puntero en la fila seleccionada true si existe|false
            return null;
        if (!($row = mysqli_fetch_array($result)))//generando un array asociativo, numerico
            return null;
        if (!array_key_exists($field, $row))//verificando que exista el campo en el array
            return null;
        return $row[$field];
    }

    function envia_errores($msj) {
        
    }

    function escribe_archivo($sql_es) {//FILE_SISTEMAS
        $fecha_proceso = date("Y-m-d H:i:s");
        $fecha_array = explode("-", $fecha_proceso);

        $ruta = FILE_SISTEMAS . "logs/" . $fecha_array[0]."/";
        $name_ar = "error_" . $fecha_array[1] . ".txt";
        
        

        if (!file_exists($ruta)) {
            mkdir($ruta, 0777);
        }
        $nuevo_archivo = fopen($ruta . $name_ar, "w");
        fwrite($nuevo_archivo, $linea);
        fclose($nuevo_archivo);
    }

}

/**
  -----------------------------------------------------------------
  Fin de la definicion de la clase PGSQL
  -----------------------------------------------------------------
 */
?>