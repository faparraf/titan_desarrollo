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
            
            case 'insertarDetallePreliquidacion' :
                $cadenaSql = 'INSERT INTO ';
                $cadenaSql .= 'liquidacion.detalle_preliquidacion';
                $cadenaSql .= '( ';
                $cadenaSql .= 'preliquidacion,';
                $cadenaSql .= "persona,";
                $cadenaSql .= "concepto,";
                $cadenaSql .= "valor";
                $cadenaSql .= ") ";
                $cadenaSql .= "VALUES ";
                $cadenaSql .= "( ";
                $cadenaSql .= "'" . $variable ['preliquidacion']  . "', ";
                $cadenaSql .= "'" . $variable ['persona']  . "', ";
                $cadenaSql .= "'" . $variable ['concepto']  . "', ";
                $cadenaSql .= "'" . $variable ['valor']  . "'";
                $cadenaSql .= "); ";
                break;

            case 'generarFormulaNomina':
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'string_agg(c.simbolo, ' + ') as formula ';
                $cadenaSql .= 'FROM concepto.asociacion_concepto ac, ';
                $cadenaSql .= 'concepto.concepto c ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'ac.codigo = c.codigo ';
                $cadenaSql .= 'AND ac.codigo_nomina = '.$variable;
                break;
            
            case 'buscarVinculacion' :      
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'id as ID, ';
                $cadenaSql .= 'nombre as NOMBRE ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.tipo_vinculacion';        
                break;
            
            case 'buscarFormulaConcepto' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'formula as FORMULA ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'concepto.concepto ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= "simbolo = '$variable'";
                break;
            
            case 'buscarValorParametro' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'valor as VALOR ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'parametro.parametro_liquidacion ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= "simbolo = '$variable'";
                break;
            
            case 'buscarReferenciaVariable' :
                $cadenaSql = 'SELECT ';
                $cadenaSql .= 'valor as VALOR ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'concepto.variable ';
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
            
            case 'buscarReferenciasEvaluacion':
                $cadenaSql = 'SELECT p.documento as id, c.sueldo as valor ';
                $cadenaSql .= 'FROM parametro.cargo c, ';
                $cadenaSql .= 'novedad.cargoxfuncionario cf, ';
                $cadenaSql .= 'novedad.funcionario f, ';
                $cadenaSql .= 'novedad.identificacion_expedicion i, ';
                $cadenaSql .= 'persona.persona_natural p ';
                $cadenaSql .= 'WHERE c.codigo_cargo = cf.codigo_cargo ';
                $cadenaSql .= 'AND cf.id_funcionario = f.id_funcionario ';
                $cadenaSql .= 'AND f.id_datos_identificacion = i.id_datos_identificacion ';
                $cadenaSql .= 'AND i.documento = p.documento ';
                $cadenaSql .= '';
                break;
            
            case 'buscarEstadisticasEvaluacion':
                $cadenaSql = 'SELECT count(p.documento) as personas, c.sueldo as valor ';
                $cadenaSql .= 'FROM parametro.cargo c, ';
                $cadenaSql .= 'novedad.cargoxfuncionario cf, ';
                $cadenaSql .= 'novedad.funcionario f, ';
                $cadenaSql .= 'novedad.identificacion_expedicion i, ';
                $cadenaSql .= 'persona.persona_natural p ';
                $cadenaSql .= 'WHERE c.codigo_cargo = cf.codigo_cargo ';
                $cadenaSql .= 'AND cf.id_funcionario = f.id_funcionario ';
                $cadenaSql .= 'AND f.id_datos_identificacion = i.id_datos_identificacion ';
                $cadenaSql .= 'AND i.documento = p.documento ';
                $cadenaSql .= 'group by c.sueldo ';
                break;
            
            case 'buscarPersonasxVinculacion':
                $cadenaSql = 'SELECT p.documento as id ';
                $cadenaSql .= 'FROM ';
                $cadenaSql .= 'persona.vinculacion_persona_natural v, ';
                $cadenaSql .= 'persona.persona_natural p ';
                $cadenaSql .= 'WHERE ';
                $cadenaSql .= 'p.documento = v.documento ';
                $cadenaSql .= 'AND v.id_tipo_vinculacion = '.$variable;
                break;
            

        }
                
        
        return $cadenaSql;
    
    }
}
?>
