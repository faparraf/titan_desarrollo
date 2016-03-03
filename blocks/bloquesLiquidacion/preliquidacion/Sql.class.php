<?php

namespace bloquesConcepto\contenidoConcepto;

if (! isset ( $GLOBALS ["autorizado"] )) {
    include ("../index.php");
    exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

/**
 * IMPORTANTE: Se recomienda que no se borren registros. Utilizar mecanismos para - independiente del motor de bases de datos,
 * poder realizar rollbacks gestionados por el aplicativo.
 */



class Sql extends \Sql {
    
    var $miConfigurador;
    
    function getCadenaSql($tipo, $variable = '') {
        
        
        
        /**
         * 1.
         * Revisar las variables para evitar SQL Injection
         */
        $prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
        $idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
        $cadenaSql='';
        switch ($tipo) {
            
            /**
             * Clausulas específicas
             */
            case 'insertarPreliquidacion' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'liquidacion.preliquidacion';
                $cadenaSql .= '( ';
                $cadenaSql .= 'nombre,';
                $cadenaSql .= "descripcion,";
                $cadenaSql .= "tipo_nomina,";
                $cadenaSql .= "id_usuario,";
                $cadenaSql .= "estado, ";
                $cadenaSql .= "fecha_inicio, ";
                $cadenaSql .= "fecha_fin ";
                $cadenaSql .= ") ";
                $cadenaSql .= "VALUES ";
                $cadenaSql .= "( ";
                $cadenaSql .= "'" . $variable ['nombre']  . "', ";
                $cadenaSql .= "'" . $variable ['descripcion']  . "', ";
                $cadenaSql .= "'" . $variable ['tipo_nomina']  . "', ";
                $cadenaSql .= "'" . $variable ['usuario']  . "', ";
                $cadenaSql .= "'ACTIVO', ";
                $cadenaSql .= "'" . $variable ['fecha_inicio']  . "', ";
                $cadenaSql .= "'" . $variable ['fecha_fin']. "' ";
                $cadenaSql .= ") ";
                $cadenaSql .= "RETURNING  id; ";
                break;

            case 'buscarVinculacion' :      
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id as ID, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.tipo_vinculacion';        
                break;
            
            case 'buscarFormula' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'formula as FORMULA ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'concepto.concepto ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= "simbolo = '$variable'";
                break;
                    
            case 'buscarNomina' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'n.codigo_nomina as ID, ';
                $cadenaSql .= 'n.nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'liquidacion.nomina n';
                break;

            case 'buscarNominaAjax' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'n.codigo_nomina as ID, ';
                $cadenaSql .= 'n.nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'liquidacion.nomina n, ';
                $cadenaSql .= 'parametro.tipo_vinculacion v ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'v.id = n.id AND ';
                $cadenaSql .= 'v.id = '."'$variable'";
                break;
            
            case 'buscarSimbolo' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id_ldn as ID, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.ley_decreto_norma ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'estado != \'Inactivo\';';
                break;

            case 'buscarCategoria' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id as ID, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'concepto.categoria ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'estado != \'Inactivo\';';
                break;

            

            case 'buscarRegistrosDePreliquidacion' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'nombre as NOMBRE, ';
                $cadenaSql .= 'descripcion as DESCRIPCION, ';
                $cadenaSql .= 'fecha_inicio as FECHA_INICIO, ';
                $cadenaSql .= 'fecha_fin as FECHA_FIN, ';
                $cadenaSql .= 'fecha as FECHA_PRELIQUIDACION, ';
                $cadenaSql .= 'estado as ESTADO, ';
                $cadenaSql .= 'id as ID ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'liquidacion.preliquidacion';
                break;

            case 'consultarRegistroDePreliquidacion' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'p.id as ID, ';
                $cadenaSql .= 'p.nombre as NOMBRE, ';
                $cadenaSql .= 'p.descripcion as DESCRIPCION, ';
                $cadenaSql .= 'p.estado as ESTADO, ';
                $cadenaSql .= "'n.nombre' as NOMINA, ";
                $cadenaSql .= "u.nombre||' '||u.apellido as USUARIO, ";
                $cadenaSql .= "'v.nombre' as VINCULACION ";
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'liquidacion.preliquidacion p, ';
                $cadenaSql .= 'nomina_usuario u, ';
                $cadenaSql .= 'parametro.tipo_vinculacion v, ';
                $cadenaSql .= 'liquidacion.nomina n ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'p.id_usuario = u.id_usuario AND ';
                $cadenaSql .= 'n.codigo_nomina = p.tipo_nomina AND ';
                $cadenaSql .= 'n.id= v.id AND ';
                $cadenaSql .= 'p.id = ' . $variable . ';';
                break;

        }
                
        
        return $cadenaSql;
    
    }
}
?>
