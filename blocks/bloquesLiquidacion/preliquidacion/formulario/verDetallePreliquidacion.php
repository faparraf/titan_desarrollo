<?php 
 namespace bloquesConcepto\contenidoConcepto\formulario;



if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}


class Formulario {

    var $miConfigurador;
    var $lenguaje;
    var $miFormulario;

    function __construct($lenguaje, $formulario, $sql) {

        $this->miConfigurador = \Configurador::singleton ();

        $this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );

        $this->lenguaje = $lenguaje;

        $this->miFormulario = $formulario;
        
        $this->miSql = $sql;

    }

    function formulario() {

        /**
         * IMPORTANTE: Este formulario está utilizando jquery.
         * Por tanto en el archivo ready.php se delaran algunas funciones js
         * que lo complementan.
         */

        // Rescatar los datos de este bloque
        $esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

        // ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
        /**
        * Atributos que deben ser aplicados a todos los controles de este formulario.
        * Se utiliza un arreglo
        * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
        *
        * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
        * $atributos= array_merge($atributos,$atributosGlobales);
        */
        $atributosGlobales ['campoSeguro'] = 'true';
  
        
        $conexion = 'estructura';
        $primerRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        
        //var_dump($primerRecursoDB);
        //exit;
        
        // -------------------------------------------------------------------------------------------------

        // ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
        $esteCampo = $esteBloque ['nombre'];
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;

        // Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
        $atributos ['tipoFormulario'] = '';

        // Si no se coloca, entonces toma el valor predeterminado 'POST'
        $atributos ['metodo'] = 'POST';

        // Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
        $atributos ['action'] = 'index.php';
        $atributos ['titulo'] = false;//$this->lenguaje->getCadena ( $esteCampo );

        // Si no se coloca, entonces toma el valor predeterminado.
        $atributos ['estilo'] = '';
        $atributos ['marco'] = true;
        $tab = 1;
        // ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------

        // ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
        $atributos ['tipoEtiqueta'] = 'inicio';
        echo $this->miFormulario->formulario ( $atributos );

        // ---------------- SECCION: Controles del Formulario -----------------------------------------------
        
        
		$_identificadorPreliquidacion = $_REQUEST['variable'];//Codigo Unico que identifica el Concepto      
		
		$cadenaSqlDetalle = $this->miSql->getCadenaSql("consultarRegistrosDePreliquidacion",$_identificadorPreliquidacion);
		$matrizDatosConcepto = $primerRecursoDB->ejecutarAcceso($cadenaSqlDetalle, "busqueda", $_identificadorPreliquidacion, "consultarRegistrosDeConceptos");
		
        // --------------------------------------------------------------------------------------------------
        
        $esteCampo = "marcoDatosBasicos";
		$atributos ['id'] = $esteCampo;
		$atributos ["estilo"] = "jqueryui";
		$atributos ['tipoEtiqueta'] = 'inicio';
		$atributos ["leyenda"] = "VER DETALLE PRELIQUIDACIÓN";
		echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
        
        
        
        
         // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'nombre';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['obligatorio'] = false;
        $atributos ['etiquetaObligatorio'] = false;
        $atributos ['validar'] = '';
        $atributos ['anchoEtiqueta'] = 230;
        $atributos ['valor'] = $matrizDatosConcepto[0]['nombre'];
        
        //$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = true;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
   
                
		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'descripcion';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 92;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = "DESCRIPCIÓN";
        
        $atributos ['obligatorio'] = false;
        $atributos ['etiquetaObligatorio'] = false;
        $atributos ['validar'] = '';
        
        $atributos ['valor'] = $matrizDatosConcepto[0]['descripcion'];
        
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = true;
        $atributos ['filas'] = 4;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
        // ---------------- CONTROL: Select --------------------------------------------------------
        $esteCampo = 'tipo_vinculacion';
        $atributos['nombre'] = $esteCampo;
        $atributos['id'] = $esteCampo;
        $atributos['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['anchoEtiqueta'] = 230;
        $atributos['tab'] = $tab;
        $atributos['seleccion'] = $matrizDatosConcepto[0]['tipo_vinculacion'];
        $atributos['evento'] = ' ';
        $atributos['deshabilitado'] = true;
        $atributos['limitar']= 50;
        $atributos['tamanno']= 1;
        $atributos['columnas']= 1;
        	
        $atributos ['obligatorio'] = false;
        $atributos ['etiquetaObligatorio'] = false;
        $atributos ['validar'] = '';
        
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarVinculacion" );
        $matrizItems = $primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
         
        if ($matrizItems) {
        	$atributos['matrizItems'] = $matrizItems;
        } else {
        
        	$matrizItems = array(
        			array(-1,'No existe Categoria Registrada')
        			 
        	);
        
        	$atributos['matrizItems'] = $matrizItems;
        	$atributos['deshabilitado'] = true;
        }
        	
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        
        $atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $tab ++;
        	
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroLista ( $atributos );
        // --------------- FIN CONTROL : Select --------------------------------------------------
        
        //-----------------------------------------------------------------------------------------------------------
        //Control Busqueda de n Leyes --------------------------------------------------------------------------
        
        $cadenaSqlDetalle = $this->miSql->getCadenaSql("consultarLeyesDeConceptos",$_identificadorPreliquidacion);
        $matrizDatosLeyes = $primerRecursoDB->ejecutarAcceso($cadenaSqlDetalle, "busqueda", $_identificadorPreliquidacion, "consultarLeyesDeConceptos");
        $i = 0; $cadenaSelectMultiple = '';
        
        while($i < count($matrizDatosLeyes)){
        	$cadenaSelectMultiple = $cadenaSelectMultiple . $matrizDatosLeyes[$i]['id'] . ',';
        	$i++;
        }
        $cadenaSelectMultiple = substr($cadenaSelectMultiple, 0, -1);
        
        
        
        
        //-------------------------------------------------------------------------------------------------------
        
        // ---------------- CONTROL: Select --------------------------------------------------------
	        $esteCampo = 'ley';
	        $atributos['nombre'] = $esteCampo;
	        $atributos['id'] = $esteCampo;
	        $atributos['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
	        $atributos['tab'] = $tab;
	        $atributos['seleccion'] = -1;
	        $atributos['evento'] = ' ';
	        $atributos['deshabilitado'] = true;
	        $atributos['limitar']= 50;
	        $atributos['tamanno']= 4;
	        $atributos['columnas']= 1;
	        
	        $atributos ['obligatorio'] = false;
	        $atributos ['etiquetaObligatorio'] = false;
	        $atributos ['validar'] = '';
	        $atributos ['multiple'] = true;
	        
	        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarLey" );
	        $matrizItems = $primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
	        
	        if ($matrizItems) {
	        	$atributos['matrizItems'] = $matrizItems;
	        } else {
	        	
	        	$matrizItems = array(
	        			array(-1,'No existe Ley Registrada')
	        			 
	        	);
	        	
	        	$atributos['matrizItems'] = $matrizItems;
	        	$atributos['deshabilitado'] = true;
	        }
	  
	        $tab ++;
	        
	        // Aplica atributos globales al control
	        $atributos = array_merge ( $atributos, $atributosGlobales );
	        echo $this->miFormulario->campoCuadroLista ( $atributos );
	        // --------------- FIN CONTROL : Select --------------------------------------------------
	        
	        unset($atributos);
	
        	// ---------------- CONTROL: Select --------------------------------------------------------
	        $esteCampo = 'naturaleza';
	        $atributos['nombre'] = $esteCampo;
	        $atributos['id'] = $esteCampo;
	        $atributos['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
	        $atributos['tab'] = $tab;
	        $atributos['seleccion'] = $matrizDatosConcepto[0]['naturaleza'];
	        $atributos['evento'] = ' ';
	        $atributos['deshabilitado'] = true;
	        $atributos['limitar']= 50;
	        $atributos['tamanno']= 1;
	        $atributos['columnas']= 1;
	        $atributos ['anchoEtiqueta'] = 230;
	        
	        $atributos ['obligatorio'] = false;
	        $atributos ['etiquetaObligatorio'] = false;
	        $atributos ['validar'] = '';
	        
	        $naturaleza = array( 
    			array(1,'Devenga'), 
    			array(2,'Deduce'), 
   
			); 
	        
        	$atributos['matrizItems'] =  $naturaleza;
	        
	        if (isset ( $_REQUEST [$esteCampo] )) {
	        	$atributos ['valor'] = $_REQUEST [$esteCampo];
	        } else {
	        	$atributos ['valor'] = '';
	        }
	        $tab ++;
	        
	        // Aplica atributos globales al control
	        $atributos = array_merge ( $atributos, $atributosGlobales );
	        echo $this->miFormulario->campoCuadroLista ( $atributos );
	        // --------------- FIN CONTROL : Select --------------------------------------------------
	        
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'descripcion';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 92;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = "DESCRIPCIÓN";
        
        $atributos ['obligatorio'] = false;
        $atributos ['etiquetaObligatorio'] = false;
        $atributos ['validar'] = '';
        
        $atributos ['valor'] = $matrizDatosConcepto[0]['descripcion'];
        
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = true;
        $atributos ['filas'] = 4;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoTextArea( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto ------------
        
        unset($atributos);
        
        // --------------------------------------------------------------------------------------------------
        
        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "FÓRMULA DEL CONCEPTO";
        echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
        // --------------------------------------------------------------------------------------------------
        
        $atributos ["id"] = "formula";
        $atributos ["estilo"] = "row";
        echo $this->miFormulario->division ( "inicio", $atributos );
        {
        	$atributos ["id"] = "ingresoFormula";
        	$atributos ["estilo"] = "col-md-12";
        	echo $this->miFormulario->division ( "inicio", $atributos );
        	{
        		// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        		$esteCampo = 'formula';
        		$atributos ['id'] = $esteCampo;
        		$atributos ['nombre'] = $esteCampo;
        		$atributos ['estilo'] = '';
        		$atributos ['marco'] = false;
        		$atributos ['columnas'] = 80;
        		$atributos ['filas'] = 10;
        		$atributos ['tabIndex'] = $tab;
        		$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        		$atributos ['anchoEtiqueta'] = 90;
        		$atributos ['deshabilitado'] =true;
        			
        		$atributos ['obligatorio'] = false;
        		$atributos ['etiquetaObligatorio'] = false;
        		$atributos ['validar'] = '';
        			
        		$atributos ['valor'] = $matrizDatosConcepto[0]['formula'];
        		
        		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        		$tab ++;
        			
        		// Aplica atributos globales al control
        		$atributos = array_merge ( $atributos, $atributosGlobales );
        		echo $this->miFormulario->campoTextArea ( $atributos );
        		// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        	}
        	echo $this->miFormulario->division ( "fin");
        }
        echo $this->miFormulario->division ( "fin");
        	
        
        echo $this->miFormulario->marcoAgrupacion ( "fin" );
        
        //-----------------------------------------------------------------------------------------------------------
        //Control Busqueda de n Condiciones --------------------------------------------------------------------------
        
        
        $cadenaSqlDetalle = $this->miSql->getCadenaSql("consultarCondicionesDeConceptos",$_identificadorPreliquidacion);
        $matrizDatosControl = $primerRecursoDB->ejecutarAcceso($cadenaSqlDetalle, "busqueda", $_identificadorPreliquidacion, "consultarCondicionesDeConceptos");
        
        if($matrizDatosControl != null){
        	$cadenaSqlDetalle = $this->miSql->getCadenaSql("consultarCondicionesDeConceptos",$_identificadorPreliquidacion);
        	$matrizDatosCondiciones = array_reverse($primerRecursoDB->ejecutarAcceso($cadenaSqlDetalle, "busqueda", $_identificadorPreliquidacion, "consultarCondicionesDeConceptos"));
        }
        $i = 0; $indice = 1;
        
        $esteCampo = "marcoDatosBasicos";
        $atributos ['id'] = $esteCampo;
        $atributos ["estilo"] = "jqueryui";
        $atributos ['tipoEtiqueta'] = 'inicio';
        $atributos ["leyenda"] = "CONDICIONES DEL CONCEPTO";
        echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
        // --------------------------------------------------------------------------------------------------
        while($i < count($matrizDatosControl) && $matrizDatosControl != null){
        	
        	
        	//---- Lectura del Contenido de la Cadena de Condiciones -----------------------------
        	$typeCaseA = substr($matrizDatosCondiciones[$i]['cadena'], 3);
        	$typeCaseB = explode( ')', $typeCaseA );
        	$typeCaseC = substr($typeCaseB[1], 10);
        	$typeCaseD = explode( '}', $typeCaseC );
        	
        	// $typeCaseB[0] Contenido de la Condicion (Si)
        	// $typeCaseD[0] Contenido de la Condicion (Entonces)
        	//------------------------------------------------------------------------------------
        	
        	$esteCampo = "marcoDatosBasicos";
        	$atributos ['id'] = $esteCampo;
        	$atributos ["estilo"] = "jqueryui";
        	$atributos ['tipoEtiqueta'] = 'inicio';
        	$atributos ["leyenda"] = "CONDICION # ".$indice++;
        	echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
        	// -------------------------------------------------------------------------------------
        	
	        	// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
	        	$esteCampo = 'condicionSi';
	        	$atributos ['id'] = $esteCampo.$i;
	        	$atributos ['nombre'] = $esteCampo;
	        	$atributos ['estilo'] = '';
	        	$atributos ['marco'] = false;
	        	$atributos ['columnas'] = 80;
	        	$atributos ['filas'] = 2;
	        	$atributos ['tabIndex'] = $tab;
	        	$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
	        	$atributos ['anchoEtiqueta'] = 90;
	        	$atributos ['deshabilitado'] =true;
	        	 
	        	$atributos ['obligatorio'] = false;
	        	$atributos ['etiquetaObligatorio'] = false;
	        	$atributos ['validar'] = '';
	        	 
	        	$atributos ['valor'] = $typeCaseB[0];
	        	
	        	$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
	        	$tab ++;
	        	 
	        	// Aplica atributos globales al control
	        	$atributos = array_merge ( $atributos, $atributosGlobales );
	        	echo $this->miFormulario->campoTextArea ( $atributos );
	        	// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        	
        		
	        	// ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
	        	$esteCampo = 'condicionEntonces';
	        	$atributos ['id'] = $esteCampo.$i;
	        	$atributos ['nombre'] = $esteCampo;
	        	$atributos ['estilo'] = '';
	        	$atributos ['marco'] = false;
	        	$atributos ['columnas'] = 80;
	        	$atributos ['filas'] = 2;
	        	$atributos ['tabIndex'] = $tab;
	        	$atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
	        	$atributos ['anchoEtiqueta'] = 90;
	        	$atributos ['deshabilitado'] =true;
	        	 
	        	$atributos ['obligatorio'] = false;
	        	$atributos ['etiquetaObligatorio'] = false;
	        	$atributos ['validar'] = '';
	        	 
	        	$atributos ['valor'] = $typeCaseD[0];
	        	
	        	$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
	        	$tab ++;
	        	 
	        	// Aplica atributos globales al control
	        	$atributos = array_merge ( $atributos, $atributosGlobales );
	        	echo $this->miFormulario->campoTextArea ( $atributos );
	        	// --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        	
        	
        	echo $this->miFormulario->marcoAgrupacion ( "fin" );
        	
        	$i++;
        }
        
        echo $this->miFormulario->marcoAgrupacion ( "fin" );
        
        unset($atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'leyRegistros';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        	
        $atributos ['valor'] = '';
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 30;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        	
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
        unset($atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'estadoPagina';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
         
        $atributos ['valor'] = 'verDetalle';
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
         
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
        unset($atributos);
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'cargaSelectMultiple';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
         
        $atributos ['valor'] = $cadenaSelectMultiple;
        $atributos ['deshabilitado'] = false;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
         
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
                
        // ------------------Division para los botones-------------------------
        $atributos ["id"] = "botonesInfo";
        $atributos ["estilo"] = "marcoBotones";
        $atributos ["titulo"] = "Enviar Información";
        echo $this->miFormulario->division ( "inicio", $atributos );

        // -----------------CONTROL: Botón ----------------------------------------------------------------
        $esteCampo = 'botonRegresarConsulta';
        $atributos ["id"] = $esteCampo;
        $atributos ["tabIndex"] = $tab;
        $atributos ["tipo"] = 'boton';
        // submit: no se coloca si se desea un tipo button genérico
        $atributos ['submit'] = true;
        $atributos ["estiloMarco"] = '';
        $atributos ["estiloBoton"] = 'jqueryui';
        // verificar: true para verificar el formulario antes de pasarlo al servidor.
        $atributos ["verificar"] = true;
        $atributos ["tipoSubmit"] = 'jquery'; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
        $atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos ['nombreFormulario'] = $esteBloque ['nombre'];
        $tab ++;

        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoBoton ( $atributos );
        
      
        
        // -----------------FIN CONTROL: Botón -----------------------------------------------------------

        // ------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division ( "fin" );
        echo $this->miFormulario->marcoAgrupacion ( 'fin' );
        // ------------------- SECCION: Paso de variables ------------------------------------------------

        /**
         * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
         * SARA permite realizar esto a través de tres
         * mecanismos:
         * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
         * la base de datos.
         * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
         * formsara, cuyo valor será una cadena codificada que contiene las variables.
         * (c) a través de campos ocultos en los formularios. (deprecated)
        */

        // En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:

        // Paso 1: crear el listado de variables

        //$valorCodificado = "actionBloque=" . $esteBloque ["nombre"]; //Ir pagina Funcionalidad
       // $valorCodificado  = "action=" . $esteBloque ["nombre"];
        
        $valorCodificado = "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );//Frontera mostrar formulario
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=form";
        /**
         * SARA permite que los nombres de los campos sean dinámicos.
         * Para ello utiliza la hora en que es creado el formulario para
         * codificar el nombre de cada campo. 
         */
      	$valorCodificado .= "&campoSeguro=" . $_REQUEST['tiempo'];
        // Paso 2: codificar la cadena resultante
        $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );

        $atributos ["id"] = "formSaraData"; // No cambiar este nombre
        $atributos ["tipo"] = "hidden";
        $atributos ['estilo'] = '';
        $atributos ["obligatorio"] = false;
        $atributos ['marco'] = true;
        $atributos ["etiqueta"] = "";
        $atributos ["valor"] = $valorCodificado;
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        unset ( $atributos );

        // ----------------FIN SECCION: Paso de variables -------------------------------------------------

        // ---------------- FIN SECCION: Controles del Formulario -------------------------------------------

        // ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
        // Se debe declarar el mismo atributo de marco con que se inició el formulario.
        $atributos ['marco'] = true;
        $atributos ['tipoEtiqueta'] = 'fin';
        echo $this->miFormulario->formulario ( $atributos );

        return true;

    }

    function mensaje() {

        // Si existe algun tipo de error en el login aparece el siguiente mensaje
        $mensaje = $this->miConfigurador->getVariableConfiguracion ( 'mostrarMensaje' );
        $this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', null );

        if ($mensaje) {

            $tipoMensaje = $this->miConfigurador->getVariableConfiguracion ( 'tipoMensaje' );

            if ($tipoMensaje == 'json') {

                $atributos ['mensaje'] = $mensaje;
                $atributos ['json'] = true;
            } else {
                $atributos ['mensaje'] = $this->lenguaje->getCadena ( $mensaje );
            }
            // -------------Control texto-----------------------
            $esteCampo = 'divMensaje';
            $atributos ['id'] = $esteCampo;
            $atributos ["tamanno"] = '';
            $atributos ["estilo"] = 'information';
            $atributos ["etiqueta"] = '';
            $atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
            echo $this->miFormulario->campoMensaje ( $atributos );
            unset ( $atributos );

             
        }

        return true;

    }

}

$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario, $this->sql );


$miFormulario->formulario ();
$miFormulario->mensaje ();

?>