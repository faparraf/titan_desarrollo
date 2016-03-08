<?php

namespace bloquesConcepto\contenidoConcepto\funcion;


include_once('Redireccionador.php');
include "Interprete.php";

class FormProcessor {
    
    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;
    var $miSql;
    var $conexion;
    
    function __construct($lenguaje, $sql) {
        
        $this->miConfigurador = \Configurador::singleton ();
        $this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
        $this->lenguaje = $lenguaje;
        $this->miSql = $sql;
    
    }
    
    function procesarFormulario() {    

        //Aquí va la lógica de procesamiento
        
        $conexion = 'estructura';
        $primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        
        
        $datos = array(
            'nombre' => $_REQUEST ['nombre'],
            'descripcion' => $_REQUEST ['descripcion'],
            'tipo_nomina' => $_REQUEST ['tipo_nomina'],
            'fecha_inicio' => $_REQUEST['fecha_inicio'],
            'fecha_fin' => $_REQUEST ['fecha_fin'],
            'usuario' => '1'
        );
        	
        
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("insertarPreliquidacion",$datos);
        //echo "SQL: ".$atributos ['cadena_sql'];
        $resultado=$primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "acceso");
        //Al final se ejecuta la redirección la cual pasará el control a otra página
         if (!empty($resultado)) {
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql("generarFormulaNomina",$_REQUEST['tipo_nomina']);
            $result=$primerRecursoDB->ejecutarAcceso($atributos['cadena_sql'], "busqueda");
            $nomina = $result[0]['formula'];
            $interprete = new \Interprete($this->lenguaje, $this->miSql, $primerRecursoDB);
            $arbol = $interprete->generarArbol($nomina);
            $interprete->evaluarArbol($arbol, 
                    array('tipo_vinculacion'=>$_REQUEST['tipo_vinculacion'],
                        'preliquidacion'=>$resultado));
            Redireccionador::redireccionar('inserto',$datos);
            exit();
        } else {
           Redireccionador::redireccionar('noInserto',$atributos ['cadena_sql']);
            exit();
        }
        
    	        
    }
    
    function resetForm(){
        foreach($_REQUEST as $clave=>$valor){
             
            if($clave !='pagina' && $clave!='development' && $clave !='jquery' &&$clave !='tiempo'){
                unset($_REQUEST[$clave]);
            }
        }
    }
    
}

$miProcesador = new FormProcessor ( $this->lenguaje, $this->sql );

$resultado= $miProcesador->procesarFormulario ();

