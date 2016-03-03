<?php

namespace bloquesConcepto\contenidoConcepto\funcion;


include_once('Redireccionador.php');

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
       
        //***************************VALIDAR Formula*****************************************************************
        
        
        
        //-------------------------- Seccion Validar Formula ------------------------------------------------
        //-------------------------------------------------------------------------------------------------------
         
        $_entradaFormulaCompilador = $_REQUEST['formulaConcepto'];
        
        
        
        
        
        
        
        
        //----------------------------------------------------------------------------------------------------------
        //------------------------ Codigo A Ejecutar Una Vez VALIDADA la Formula -----------------------------------
        
        if(isset($_REQUEST['naturalezaInfoConcepto'])){
        	switch($_REQUEST['naturalezaInfoConcepto']){
        		case 1 :
        			$_REQUEST['naturalezaInfoConcepto']='Devenga';
        			break;
        		case 2 :
        			$_REQUEST['naturalezaInfoConcepto']='Deduce';
        			break;
        	}
        }
        
        $datosConcepto = array (
        		'nombre' => $_REQUEST['nombreInfoConcepto'],
        		'simbolo' => $_REQUEST['simboloInfoConcepto'],
        		'categoria' => $_REQUEST['categoriaInfoConcepto'],
        		'naturaleza' => $_REQUEST['naturalezaInfoConcepto'],
        		'descripcion' => $_REQUEST['descripcionInfoConcepto'],
        		'formula' => $_REQUEST['formulaConcepto'],
        		'id_concepto' => $_REQUEST['variable']
        );
        
        $cadenaSql = $this->miSql->getCadenaSql("modificarConcepto",$datosConcepto);
        $resultado = $primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");
        
        
        $datosLeyesConcepto = array(
        		'fk_concepto' => $_REQUEST['variable']
        );
        
        $cadenaSql = $this->miSql->getCadenaSql("eliminarLeyesModificar",$datosLeyesConcepto);
        $primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");//********************************
        
        $arrayLeyes = explode(",", $_REQUEST['leyRegistrosInfoConcepto']);
        $count = 0;
        
        while($count < count($arrayLeyes)){
        	 
        	$datosLeyesConcepto = array(
        			'fk_id_ley' => $arrayLeyes[$count],
        			'fk_concepto' => $_REQUEST['variable']
        	);
        	 
        	$cadenaSql = $this->miSql->getCadenaSql("insertarLeyesConcepto",$datosLeyesConcepto);
        	$primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");//********************************
        	 
        	$count++;
        
        }
        
        //---------------------------------------------------------------------------------------------------------
        //---------------------------------------------------------------------------------------------------------
        
        $datosCondicionesConcepto = array(
        		'fk_concepto' => $_REQUEST['variable']
        );
        
        $cadenaSql = $this->miSql->getCadenaSql("eliminarCondicionesModificar",$datosCondicionesConcepto);
        $primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");//********************************
        
        
        //***************************VALIDAR Condiciones*************************************************************
        
        
        // ---------------- INICIO: Lista Variables Control--------------------------------------------------------
        
        $cantidadCondiciones = $_REQUEST['cantidadCondicionesConcepto'];
        
        // ---------------- FIN: Lista Variables Control--------------------------------------------------------
        
        // --------------------------------- n Condiciones ----------------------------------
        
        $count = 0;
        $control = 0;
        $limite = 0;
         
        $arrayPartCondicion = explode(",", $_REQUEST['variablesRegistros']);
         
        while($control < $cantidadCondiciones){
        
        	$arrayCondiciones[$control] = 'Si(' .$arrayPartCondicion[$limite++]. ') Entonces{'.$arrayPartCondicion[$limite++].'}';
        	 
        	$control++;
        }
         
        while($count < $cantidadCondiciones){
        	 
        	//-------------------------- Seccion Validar Condiciones ------------------------------------------------
        	//Formato:
        	//					Si(condiciones) Entonces{Accion}
        	//-------------------------------------------------------------------------------------------------------
        	 
        	$_entradaCondicionCompilador = $arrayCondiciones[$count];
        	 
        	 
        	 
        	 
        	 
        	 
        	//----------------------------------------------------------------------------------------------------------
        	//------------------------ Codigo A Ejecutar Una Vez VALIDADA la Condicion -----------------------------------
        
        	$datosCondicionInser = array(
        			'cadena' => $arrayCondiciones[$count],
        			'fk_concepto' => $_REQUEST['variable']
        	);
        	 
        	$cadenaSql = $this->miSql->getCadenaSql("insertarCondicion",$datosCondicionInser);
        	$primerRecursoDB->ejecutarAcceso($cadenaSql, "acceso");//********************************
        	 
        	//-------------------------------------------------------------------------------------------------------
        
        	$count++;
        }
        
        
        if (!empty($resultado)) {
        	Redireccionador::redireccionar('modifico',$datosConcepto);
        	exit();
        } else {
        	Redireccionador::redireccionar('noInserto',$datosConcepto);
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

