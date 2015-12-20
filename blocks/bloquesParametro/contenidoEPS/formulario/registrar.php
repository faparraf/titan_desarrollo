<?php 
namespace bloquesParametro\contenidoCargo\formulario;



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
        $_REQUEST['tiempo']=time();
        
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
        // --------------------------------------------------------------------------------------------------
        
        $esteCampo = "marcoDatosBasicos";
	$atributos ['id'] = $esteCampo;
	$atributos ["estilo"] = "jqueryui";
	$atributos ['tipoEtiqueta'] = 'inicio';
	$atributos ["leyenda"] = "Registro EPS";
	echo $this->miFormulario->marcoAgrupacion ( 'inicio', $atributos );
        
        
        
        // --------------------------------------------------------------------------------------------------
        
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'nitRegistro';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'number';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        
        $atributos ['obligatorio'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, minSize[5]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'nombreRegistro';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        
        $atributos ['obligatorio'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, minSize[4]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
         // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'direccionRegistro';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        
        $atributos ['obligatorio'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, minSize[6]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
        // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'telefonoRegistro';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'number';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        
        $atributos ['obligatorio'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, minSize[7]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
            
         // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'extTelefonoRegistro';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'number';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        
        $atributos ['obligatorio'] = false;
        $atributos ['etiquetaObligatorio'] = false;
        $atributos ['validar'] = 'minSize[1]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
         // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'faxRegistro';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'number';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        
        $atributos ['obligatorio'] = false;
        $atributos ['etiquetaObligatorio'] = false;
        $atributos ['validar'] = 'minSize[5]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
         // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'extFaxRegistro';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'number';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        
        $atributos ['obligatorio'] = false;
        $atributos ['etiquetaObligatorio'] = false;
        $atributos ['validar'] = 'minSize[1]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
        //---------------- ARRAY LUGARES ----------------------------------------------------------------
       
$tsCiudades = array( 
    1 => array( 
        1 => 'LETICIA', 
        2 => 'EL ENCANTO', 
        3 => 'LA CHORRERA', 
        4 => 'LA PEDRERA', 
        5 => 'LA VICTORIA', 
        6 => 'MIRITI-PARANA', 
        7 => 'PUERTO ALEGRIA', 
        8 => 'PUERTO ARICA', 
        9 => 'PUERTO NARINO', 
        10 => 'SANTANDER', 
        11 => 'TARAPACA', 
    ), 
    2 => array( 
        1 => 'ABEJORRAL', 
        2 => 'ABRIAQUI', 
        3 => 'ALEJANDRIA', 
        4 => 'AMAGA', 
        5 => 'AMALFI', 
        6 => 'ANDES', 
        7 => 'ANGELOPOLIS', 
        8 => 'ANGOSTURA', 
        9 => 'ANORI', 
        10 => 'ANZA', 
        11 => 'APARTADO', 
        12 => 'ARBOLETES', 
        13 => 'ARGELIA', 
        14 => 'ARMENIA', 
        15 => 'BARBOSA', 
        16 => 'BELLO', 
        17 => 'BELMIRA', 
        18 => 'BETANIA', 
        19 => 'BETULIA', 
        20 => 'BRICENO', 
        21 => 'BURITICA', 
        22 => 'CACERES', 
        23 => 'CAICEDO', 
        24 => 'CALDAS', 
        25 => 'CAMPAMENTO', 
        26 => 'CANASGORDAS', 
        27 => 'CARACOLI', 
        28 => 'CARAMANTA', 
        29 => 'CAREPA', 
        30 => 'CARMEN DE VIBORAL', 
        31 => 'CAROLINA', 
        32 => 'CAUCASIA', 
        33 => 'CHIGORODO', 
        34 => 'CISNEROS', 
        35 => 'CIUDAD BOLIVAR', 
        36 => 'COCORNA', 
        37 => 'CONCEPCION', 
        38 => 'CONCORDIA', 
        39 => 'COPACABANA', 
        40 => 'DABEIBA', 
        41 => 'DON MATIAS', 
        42 => 'EBEJICO', 
        43 => 'EL BAGRE', 
        44 => 'ENTRERRIOS', 
        45 => 'ENVIGADO', 
        46 => 'FREDONIA', 
        47 => 'FRONTINO', 
        48 => 'GIRALDO', 
        49 => 'GIRARDOTA', 
        50 => 'GOMEZ PLATA', 
        51 => 'GRANADA', 
        52 => 'GUADALUPE', 
        53 => 'GUARNE', 
        54 => 'GUATAPE', 
        55 => 'HELICONIA', 
        56 => 'HISPANIA', 
        57 => 'ITAG&Uuml;I', 
        58 => 'ITUANGO', 
        59 => 'JARDIN', 
        60 => 'JERICO', 
        61 => 'LA CEJA', 
        62 => 'LA ESTRELLA', 
        63 => 'LA PINTADA', 
        64 => 'LA UNION', 
        65 => 'LIBORINA', 
        66 => 'MACEO', 
        67 => 'MARINILLA', 
        68 => 'MEDELLIN', 
        69 => 'MONTEBELLO', 
        70 => 'MURINDO', 
        71 => 'MUTATA', 
        72 => 'NARINO', 
        73 => 'NECHI', 
        74 => 'NECOCLI', 
        75 => 'OLAYA', 
        76 => 'PENOL', 
        77 => 'PEQUE', 
        78 => 'PUEBLORRICO', 
        79 => 'PUERTO BERRIO', 
        80 => 'PUERTO NARE', 
        81 => 'PUERTO TRIUNFO', 
        82 => 'REMEDIOS', 
        83 => 'RETIRO', 
        84 => 'RIONEGRO', 
        85 => 'SABANALARGA', 
        86 => 'SABANETA', 
        87 => 'SALGAR', 
        88 => 'SAN ANDRES', 
        89 => 'SAN CARLOS', 
        90 => 'SAN FRANCISCO', 
        91 => 'SAN JERONIMO', 
        92 => 'SAN JOSE DE LA MONTANA', 
        93 => 'SAN JUAN DE URABA', 
        94 => 'SAN LUIS', 
        95 => 'SAN PEDRO', 
        96 => 'SAN PEDRO DE URABA', 
        97 => 'SAN RAFAEL', 
        98 => 'SAN ROQUE', 
        99 => 'SAN VICENTE', 
        100 => 'SANTA BARBARA', 
        101 => 'SANTA FE DE ANTIOQUIA', 
        102 => 'SANTA ROSA DE OSOS', 
        103 => 'SANTO DOMINGO', 
        104 => 'SANTUARIO', 
        105 => 'SEGOVIA', 
        106 => 'SONSON', 
        107 => 'SOPETRAN', 
        108 => 'TAMESIS', 
        109 => 'TARAZA', 
        110 => 'TARSO', 
        111 => 'TITIRIBI', 
        112 => 'TOLEDO', 
        113 => 'TURBO', 
        114 => 'URAMITA', 
        115 => 'URRAO', 
        116 => 'VALDIVIA', 
        117 => 'VALPARAISO', 
        118 => 'VEGACHI', 
        119 => 'VENECIA', 
        120 => 'VIGIA DEL FUERTE', 
        121 => 'YALI', 
        122 => 'YARUMAL', 
        123 => 'YOLOMBO', 
        124 => 'YONDO', 
        125 => 'ZARAGOZA', 
    ), 
    3 => array( 
        1 => 'ARAUCA', 
        2 => 'ARAUQUITA', 
        3 => 'CRAVO NORTE', 
        4 => 'FORTUL', 
        5 => 'PUERTO RONDON', 
        6 => 'SARAVENA', 
        7 => 'TAME', 
    ), 
    4 => array( 
        1 => 'BARANOA', 
        2 => 'BARRANQUILLA', 
        3 => 'CAMPO DE LA CRUZ', 
        4 => 'CANDELARIA', 
        5 => 'GALAPA', 
        6 => 'JUAN DE ACOSTA', 
        7 => 'LURUACO', 
        8 => 'MALAMBO', 
        9 => 'MANATI', 
        10 => 'PALMAR DE VARELA', 
        11 => 'PIOJO', 
        12 => 'POLONUEVO', 
        13 => 'PONEDERA', 
        14 => 'PUERTO COLOMBIA', 
        15 => 'REPELON', 
        16 => 'SABANAGRANDE', 
        17 => 'SABANALARGA', 
        18 => 'SANTA LUCIA', 
        19 => 'SANTO TOMAS', 
        20 => 'SOLEDAD', 
        21 => 'SUAN', 
        22 => 'TUBARA', 
        23 => 'USIACURI', 
    ), 
    5 => array( 
        1 => 'ACHI', 
        2 => 'ALTOS DEL ROSARIO', 
        3 => 'ARENAL', 
        4 => 'ARJONA', 
        5 => 'ARROYOHONDO', 
        6 => 'BARRANCO DE LOBA', 
        7 => 'CALAMAR', 
        8 => 'CANTAGALLO', 
        9 => 'CARTAGENA DE INDIAS', 
        10 => 'CICUCO', 
        11 => 'CLEMENCIA', 
        12 => 'CORDOBA', 
        13 => 'EL CARMEN DE BOLIVAR', 
        14 => 'EL GUAMO', 
        15 => 'EL PENON', 
        16 => 'HATILLO DE LOBA', 
        17 => 'MAGANGUE', 
        18 => 'MAHATES', 
        19 => 'MARGARITA', 
        20 => 'MARIA LA BAJA', 
        21 => 'MOMPOS', 
        22 => 'MONTECRISTO', 
        23 => 'MORALES', 
        24 => 'PINILLOS', 
        25 => 'REGIDOR', 
        26 => 'RIOVIEJO', 
        27 => 'SAN CRISTOBAL', 
        28 => 'SAN ESTANISLAO', 
        29 => 'SAN FERNANDO', 
        30 => 'SAN JACINTO', 
        31 => 'SAN JACINTO DEL CAUCA', 
        32 => 'SAN JUAN NEPOMUCENO', 
        33 => 'SAN MARTIN DE LOBA', 
        34 => 'SAN PABLO', 
        35 => 'SANTA CATALINA', 
        36 => 'SANTA ROSA', 
        37 => 'SANTA ROSA DEL SUR', 
        38 => 'SIMITI', 
        39 => 'SOPLAVIENTO', 
        40 => 'TALAIGUA NUEVO', 
        41 => 'TIQUISIO', 
        42 => 'TURBACO', 
        43 => 'TURBANA', 
        44 => 'VILLANUEVA', 
        45 => 'ZAMBRANO', 
    ), 
    6 => array( 
        1 => 'ALMEIDA', 
        2 => 'AQUITANIA', 
        3 => 'ARCABUCO', 
        4 => 'BELEN', 
        5 => 'BERBEO', 
        6 => 'BETEITIVA', 
        7 => 'BOAVITA', 
        8 => 'BOYACA', 
        9 => 'BRICENO', 
        10 => 'BUENAVISTA', 
        11 => 'BUSBANZA', 
        12 => 'CALDAS', 
        13 => 'CAMPOHERMOSO', 
        14 => 'CERINZA', 
        15 => 'CHINAVITA', 
        16 => 'CHIQUINQUIRA', 
        17 => 'CHIQUIZA', 
        18 => 'CHISCAS', 
        19 => 'CHITA', 
        20 => 'CHITARAQUE', 
        21 => 'CHIVATA', 
        22 => 'CHIVOR', 
        23 => 'CIENEGA', 
        24 => 'COMBITA', 
        25 => 'COPER', 
        26 => 'CORRALES', 
        27 => 'COVARACHIA', 
        28 => 'CUBARA', 
        29 => 'CUCAITA', 
        30 => 'CUITIVA', 
        31 => 'DUITAMA', 
        32 => 'EL COCUY', 
        33 => 'EL ESPINO', 
        34 => 'FIRAVITOBA', 
        35 => 'FLORESTA', 
        36 => 'GACHANTIVA', 
        37 => 'GAMEZA', 
        38 => 'GARAGOA', 
        39 => 'GUACAMAYAS', 
        40 => 'GUATEQUE', 
        41 => 'GUAYATA', 
        42 => 'GUICAN', 
        43 => 'IZA', 
        44 => 'JENESANO', 
        45 => 'JERICO', 
        46 => 'LA CAPILLA', 
        47 => 'LA UVITA', 
        48 => 'LA VICTORIA', 
        49 => 'LABRANZAGRANDE', 
        50 => 'MACANAL', 
        51 => 'MARIPI', 
        52 => 'MIRAFLORES', 
        53 => 'MONGUA', 
        54 => 'MONGUI', 
        55 => 'MONIQUIRA', 
        56 => 'MOTAVITA', 
        57 => 'MUZO', 
        58 => 'NOBSA', 
        59 => 'NUEVO COLON', 
        60 => 'OICATA', 
        61 => 'OTANCHE', 
        62 => 'PACHAVITA', 
        63 => 'PAEZ', 
        64 => 'PAIPA', 
        65 => 'PAJARITO', 
        66 => 'PANQUEBA', 
        67 => 'PAUNA', 
        68 => 'PAYA', 
        69 => 'PAZ DE RIO', 
        70 => 'PESCA', 
        71 => 'PISVA', 
        72 => 'PUERTO BOYACA', 
        73 => 'QUIPAMA', 
        74 => 'RAMIRIQUI', 
        75 => 'RAQUIRA', 
        76 => 'RONDON', 
        77 => 'SABOYA', 
        78 => 'SACHICA', 
        79 => 'SAMACA', 
        80 => 'SAN EDUARDO', 
        81 => 'SAN JOSEDE PARE', 
        82 => 'SAN LUIS DE GACENO', 
        83 => 'SAN MATEO', 
        84 => 'SAN MIGUEL DE SEMA', 
        85 => 'SAN PABLO DE BORBUR', 
        86 => 'SANTA MARIA', 
        87 => 'SANTA ROSA DE VITERBO', 
        88 => 'SANTA SOFIA', 
        89 => 'SANTANA', 
        90 => 'SATIVANORTE', 
        91 => 'SATIVASUR', 
        92 => 'SIACHOQUE', 
        93 => 'SOATA', 
        94 => 'SOCHA', 
        95 => 'SOCOTA', 
        96 => 'SOGAMOSO', 
        97 => 'SOMONDOCO', 
        98 => 'SORA', 
        99 => 'SORACA', 
        100 => 'SOTAQUIRA', 
        101 => 'SUSACON', 
        102 => 'SUTAMARCHAN', 
        103 => 'SUTATENZA', 
        104 => 'TASCO', 
        105 => 'TENZA', 
        106 => 'TIBANA', 
        107 => 'TIBASOSA', 
        108 => 'TINJACA', 
        109 => 'TIPACOQUE', 
        110 => 'TOCA', 
        111 => 'TOG&Uuml;I', 
        112 => 'TOPAGA', 
        113 => 'TOTA', 
        114 => 'TUNJA', 
        115 => 'TUNUNGUA', 
        116 => 'TURMEQUE', 
        117 => 'TUTA', 
        118 => 'TUTAZA', 
        119 => 'UMBITA', 
        120 => 'VENTAQUEMADA', 
        121 => 'VILLA DE LEIVA', 
        122 => 'VIRACACHA', 
        123 => 'ZETAQUIRA', 
    ), 
    7 => array( 
        1 => 'AGUADAS', 
        2 => 'ANSERMA', 
        3 => 'ARANZAZU', 
        4 => 'BELALCAZAR', 
        5 => 'CHINCHINA', 
        6 => 'FILADELFIA', 
        7 => 'LA DORADA', 
        8 => 'LA MERCED', 
        9 => 'MANIZALES', 
        10 => 'MANZANARES', 
        11 => 'MARMATO', 
        12 => 'MARQUETALIA', 
        13 => 'MARULANDA', 
        14 => 'NEIRA', 
        15 => 'NORCASIA', 
        16 => 'PACORA', 
        17 => 'PALESTINA', 
        18 => 'PENSILVANIA', 
        19 => 'RIOSUCIO', 
        20 => 'RISARALDA', 
        21 => 'SALAMINA', 
        22 => 'SAMANA', 
        23 => 'SAN JOSE', 
        24 => 'SUPIA', 
        25 => 'VICTORIA', 
        26 => 'VILLAMARIA', 
        27 => 'VITERBO', 
    ), 
    8 => array( 
        1 => 'ALBANIA', 
        2 => 'BELEN DE LOS ANDAQUIES', 
        3 => 'CARTAGENA DEL CHAIRA', 
        4 => 'CURILLO', 
        5 => 'EL DONCELLO', 
        6 => 'EL PAUJIL', 
        7 => 'FLORENCIA', 
        8 => 'MILAN', 
        9 => 'MONTANITA', 
        10 => 'MORELIA', 
        11 => 'PUERTO RICO', 
        12 => 'SAN JOSE DEL FRAGUA', 
        13 => 'SAN VICENTE DEL CAGUAN', 
        14 => 'SOLANO', 
        15 => 'SOLITA', 
        16 => 'VALPARAISO', 
    ), 
    9 => array( 
        1 => 'AGUAZUL', 
        2 => 'CHAMEZA', 
        3 => 'HATO COROZAL', 
        4 => 'LA SALINA', 
        5 => 'MANI', 
        6 => 'MONTERREY', 
        7 => 'NUNCHIA', 
        8 => 'OROCUE', 
        9 => 'PAZ DE ARIPORO', 
        10 => 'PORE', 
        11 => 'RECETOR', 
        12 => 'SABANALARGA', 
        13 => 'SACAMA', 
        14 => 'SAN LUIS DE PALENQUE', 
        15 => 'TAMARA', 
        16 => 'TAURAMENA', 
        17 => 'TRINIDAD', 
        18 => 'VILLANUEVA', 
        19 => 'YOPAL', 
    ), 
    10 => array( 
        1 => 'ALMAGUER', 
        2 => 'ARGELIA', 
        3 => 'BALBOA', 
        4 => 'BOLIVAR', 
        5 => 'BUENOS AIRES', 
        6 => 'CAJIBIO', 
        7 => 'CALDONO', 
        8 => 'CALOTO', 
        9 => 'CORINTO', 
        10 => 'EL TAMBO', 
        11 => 'FLORENCIA', 
        12 => 'GUAPI', 
        13 => 'INZA', 
        14 => 'JAMBALO', 
        15 => 'LA SIERRA', 
        16 => 'LA VEGA', 
        17 => 'LOPEZ', 
        18 => 'MERCADERES', 
        19 => 'MIRANDA', 
        20 => 'MORALES', 
        21 => 'PADILLA', 
        22 => 'PAEZ', 
        23 => 'PATIA', 
        24 => 'PIAMONTE', 
        25 => 'PIENDAMO', 
        26 => 'POPAYAN', 
        27 => 'PUERTO TEJADA', 
        28 => 'PURACE', 
        29 => 'ROSAS', 
        30 => 'SAN SEBASTIAN', 
        31 => 'SANTA ROSA', 
        32 => 'SANTANDER DE QUILICHAO', 
        33 => 'SILVIA', 
        34 => 'SOTARA', 
        35 => 'SUAREZ', 
        36 => 'SUCRE', 
        37 => 'TIMBIO', 
        38 => 'TIMBIQUI', 
        39 => 'TORIBIO', 
        40 => 'TOTORO', 
        41 => 'VILLA RICA', 
    ), 
    11 => array( 
        1 => 'AGUACHICA', 
        2 => 'AGUSTIN CODAZZI', 
        3 => 'ASTREA', 
        4 => 'BECERRIL', 
        5 => 'BOSCONIA', 
        6 => 'CHIMI HAGUA', 
        7 => 'CHIRIGUANA', 
        8 => 'CURUMANI', 
        9 => 'EL COPEY', 
        10 => 'EL PASO', 
        11 => 'GAMARRA', 
        12 => 'GONZALEZ', 
        13 => 'LA GLORIA', 
        14 => 'LA JAGUA DE IBIRICO', 
        15 => 'LA PAZ', 
        16 => 'MANAURE BALCON DEL CESAR', 
        17 => 'PAILITAS', 
        18 => 'PELAYA', 
        19 => 'PUEBLO BELLO', 
        20 => 'RIO DE ORO', 
        21 => 'SAN ALBERTO', 
        22 => 'SAN DIEGO', 
        23 => 'SAN MARTIN', 
        24 => 'TAMALAMEQUE', 
        25 => 'VALLEDUPAR', 
    ), 
    12 => array( 
        1 => 'ACANDI', 
        2 => 'ALTO BAUDO', 
        3 => 'ATRATO', 
        4 => 'BAGADO', 
        5 => 'BAHIA SOLANO', 
        6 => 'BAJO BAUDO', 
        7 => 'BOJAYA', 
        8 => 'CARMEN DEL DARIEN', 
        9 => 'CERTEGUI', 
        10 => 'CONDOTO', 
        11 => 'EL CANTON DEL SAN PABLO', 
        12 => 'EL CARMEN', 
        13 => 'EL LITORAL DEL SAN JUAN', 
        14 => 'ITSMINA', 
        15 => 'JURADO', 
        16 => 'LLORO', 
        17 => 'MEDIO ATRATO', 
        18 => 'MEDIO BAUDO', 
        19 => 'MEDIO SAN JUAN', 
        20 => 'NOVITA', 
        21 => 'NUQUI', 
        22 => 'QUIBDO', 
        23 => 'RIO IRO', 
        24 => 'RIO QUITO', 
        25 => 'RIOSUCIO', 
        26 => 'SAN JOSE DEL PALMAR', 
        27 => 'SIPI', 
        28 => 'TADO', 
        29 => 'UNGUIA', 
        30 => 'UNION PANAMERICANA', 
    ), 
    13 => array( 
        1 => 'AYAPEL', 
        2 => 'BUENAVISTA', 
        3 => 'CANALETE', 
        4 => 'CERETE', 
        5 => 'CHIMA', 
        6 => 'CHINU', 
        7 => 'CIENAGA DE ORO', 
        8 => 'COTORRA', 
        9 => 'LA APARTADA', 
        10 => 'LORICA', 
        11 => 'LOS CORDOBAS', 
        12 => 'MOMIL', 
        13 => 'MONITOS', 
        14 => 'MONTELIBANO', 
        15 => 'MONTERIA', 
        16 => 'PLANETA RICA', 
        17 => 'PUEBLO NUEVO', 
        18 => 'PUERTO ESCONDIDO', 
        19 => 'PUERTO LIBERTADOR', 
        20 => 'PURISIMA', 
        21 => 'SAHAGUN', 
        22 => 'SAN ANDRES DE SOTAVENTO', 
        23 => 'SAN ANTERO', 
        24 => 'SAN BERNARDO DEL VIENTO', 
        25 => 'SAN CARLOS', 
        26 => 'SAN PELAYO', 
        27 => 'TIERRALTA', 
        28 => 'VALENCIA', 
    ), 
    14 => array( 
        1 => 'AGUA DE DIOS', 
        2 => 'ALBAN', 
        3 => 'ANAPOIMA', 
        4 => 'ANOLAIMA', 
        5 => 'APULO', 
        6 => 'ARBELAEZ', 
        7 => 'BELTRAN', 
        8 => 'BITUIMA', 
        9 => 'BOJACA', 
        10 => 'CABRERA', 
        11 => 'CACHIPAY', 
        12 => 'CAJICA', 
        13 => 'CAPARRAPI', 
        14 => 'CAQUEZA', 
        15 => 'CARMEN DE CARUPA', 
        16 => 'CHAGUANI', 
        17 => 'CHIA', 
        18 => 'CHIPAQUE', 
        19 => 'CHOACHI', 
        20 => 'CHOCONTA', 
        21 => 'COGUA', 
        22 => 'COTA', 
        23 => 'CUCUNUBA', 
        24 => 'EL COLEGIO', 
        25 => 'EL PENON', 
        26 => 'EL ROSAL', 
        27 => 'FACATATIVA', 
        28 => 'FOMEQUE', 
        29 => 'FOSCA', 
        30 => 'FUNZA', 
        31 => 'FUQUENE', 
        32 => 'FUSAGASUGA', 
        33 => 'GACHALA', 
        34 => 'GACHANCIPA', 
        35 => 'GACHETA', 
        36 => 'GAMA', 
        37 => 'GIRARDOT', 
        38 => 'GRANADA', 
        39 => 'GUACHETA', 
        40 => 'GUADUAS', 
        41 => 'GUASCA', 
        42 => 'GUATAQUI', 
        43 => 'GUATAVITA', 
        44 => 'GUAYABAL DE SIQUIMA', 
        45 => 'GUAYABETAL', 
        46 => 'GUTIERREZ', 
        47 => 'JERUSALEN', 
        48 => 'JUNIN', 
        49 => 'LA CALERA', 
        50 => 'LA MESA', 
        51 => 'LA PALMA', 
        52 => 'LA PENA', 
        53 => 'LA VEGA', 
        54 => 'LENGUAZAQUE', 
        55 => 'MACHETA', 
        56 => 'MADRID', 
        57 => 'MANTA', 
        58 => 'MEDINA', 
        59 => 'MOSQUERA', 
        60 => 'NARINO', 
        61 => 'NEMOCON', 
        62 => 'NILO', 
        63 => 'NIMAIMA', 
        64 => 'NOCAIMA', 
        65 => 'PACHO', 
        66 => 'PAIME', 
        67 => 'PANDI', 
        68 => 'PARATEBUENO', 
        69 => 'PASCA', 
        70 => 'PUERTO SALGAR', 
        71 => 'PULI', 
        72 => 'QUEBRADANEGRA', 
        73 => 'QUETAME', 
        74 => 'QUIPILE', 
        75 => 'RICAURTE', 
        76 => 'SAN ANTONIO DE TEQUENDAMA', 
        77 => 'SAN BERNARDO', 
        78 => 'SAN CAYETANO', 
        79 => 'SAN FRANCISCO', 
        80 => 'SAN JUAN DE RIOSECO', 
        81 => 'SASAIMA', 
        82 => 'SESQUILE', 
        83 => 'SIBATE', 
        84 => 'SILVANIA', 
        85 => 'SIMIJACA', 
        86 => 'SOACHA', 
        87 => 'SOPO', 
        88 => 'SUBACHOQUE', 
        89 => 'SUESCA', 
        90 => 'SUPATA', 
        91 => 'SUSA', 
        92 => 'SUTATAUSA', 
        93 => 'TABIO', 
        94 => 'TAUSA', 
        95 => 'TENA', 
        96 => 'TENJO', 
        97 => 'TIBACUY', 
        98 => 'TIBIRITA', 
        99 => 'TOCAIMA', 
        100 => 'TOCANCIPA', 
        101 => 'TOPAIPI', 
        102 => 'UBALA', 
        103 => 'UBAQUE', 
        104 => 'UBATE', 
        105 => 'UNE', 
        106 => 'UTICA', 
        107 => 'VENECIA', 
        108 => 'VERGARA', 
        109 => 'VIANI', 
        110 => 'VILLAGOMEZ', 
        111 => 'VILLAPINZON', 
        112 => 'VILLETA', 
        113 => 'VIOTA', 
        114 => 'YACOPI', 
        115 => 'ZIPACON', 
        116 => 'ZIPAQUIRA', 
    ), 
    15 => array( 
        1 => 'BARRANCO MINA', 
        2 => 'CACAHUAL', 
        3 => 'INIRIDA', 
        4 => 'LA GUADALUPE', 
        5 => 'MAPIRIPANA', 
        6 => 'MORICHAL', 
        7 => 'PANA-PANA', 
        8 => 'PUERTO COLOMBIA', 
        9 => 'SAN FELIPE', 
    ), 
    16 => array( 
        1 => 'ALBANIA', 
        2 => 'BARRANCAS', 
        3 => 'DIBULLA', 
        4 => 'DISTRACCION', 
        5 => 'EL MOLINO', 
        6 => 'FONSECA', 
        7 => 'HATO NUEVO', 
        8 => 'LA JAGUA DEL PILAR', 
        9 => 'MAICAO', 
        10 => 'MANAURE', 
        11 => 'RIOHACHA', 
        12 => 'SAN JUAN DEL CESAR', 
        13 => 'URIBIA', 
        14 => 'URUMITA', 
        15 => 'VILLANUEVA', 
    ), 
    17 => array( 
        1 => 'CALAMAR', 
        2 => 'EL RETORNO', 
        3 => 'MIRAFLORES', 
        4 => 'SAN JOSE DEL GUAVIARE', 
    ), 
    18 => array( 
        1 => 'ACEVEDO', 
        2 => 'AGRADO', 
        3 => 'AIPE', 
        4 => 'ALGECIRAS', 
        5 => 'ALTAMIRA', 
        6 => 'BARAYA', 
        7 => 'CAMPOALEGRE', 
        8 => 'COLOMBIA', 
        9 => 'ELIAS', 
        10 => 'GARZON', 
        11 => 'GIGANTE', 
        12 => 'GUADALUPE', 
        13 => 'HOBO', 
        14 => 'IQUIRA', 
        15 => 'ISNOS', 
        16 => 'LA ARGENTINA', 
        17 => 'LA PLATA', 
        18 => 'NATAGA', 
        19 => 'NEIVA', 
        20 => 'OPORAPA', 
        21 => 'PAICOL', 
        22 => 'PALERMO', 
        23 => 'PALESTINA', 
        24 => 'PITAL', 
        25 => 'PITALITO', 
        26 => 'RIVERA', 
        27 => 'SALADOBLANCO', 
        28 => 'SAN AGUSTIN', 
        29 => 'SANTA MARIA', 
        30 => 'SUAZA', 
        31 => 'TARQUI', 
        32 => 'TELLO', 
        33 => 'TERUEL', 
        34 => 'TESALIA', 
        35 => 'TIMANA', 
        36 => 'VILLAVIEJA', 
        37 => 'YAGUARA', 
    ), 
    19 => array( 
        1 => 'ALGARROBO', 
        2 => 'ARACATACA', 
        3 => 'ARIGUANI', 
        4 => 'CERRO DE SAN ANTONIO', 
        5 => 'CHIVOLO', 
        6 => 'CIENAGA', 
        7 => 'CONCORDIA', 
        8 => 'EL BANCO', 
        9 => 'EL PINON', 
        10 => 'EL RETEN', 
        11 => 'FUNDACION', 
        12 => 'GUAMAL', 
        13 => 'NUEVA GRANADA', 
        14 => 'PEDRAZA', 
        15 => 'PIJINO DEL CARMEN', 
        16 => 'PIVIJAY', 
        17 => 'PLATO', 
        18 => 'PUEBLOVIEJO', 
        19 => 'REMOLINO', 
        20 => 'SABANAS DE SAN ANGEL', 
        21 => 'SALAMINA', 
        22 => 'SAN SEBASTIAN DE BUENAVISTA', 
        23 => 'SAN ZENON', 
        24 => 'SANTA ANA', 
        25 => 'SANTA BARBARA DE PINTO', 
        26 => 'SANTA MARTA', 
        27 => 'SITIONUEVO', 
        28 => 'TENERIFE', 
        29 => 'ZAPAYAN', 
        30 => 'ZONA BANANERA', 
    ), 
    20 => array( 
        1 => 'ACACIAS', 
        2 => 'BARRANCA DE UPIA', 
        3 => 'CABUYARO', 
        4 => 'CASTILLA LA NUEVA', 
        5 => 'CUBARRAL', 
        6 => 'CUMARAL', 
        7 => 'EL CALVARIO', 
        8 => 'EL CASTILLO', 
        9 => 'EL DORADO', 
        10 => 'FUENTE DE ORO', 
        11 => 'GRANADA', 
        12 => 'GUAMAL', 
        13 => 'LA MACARENA', 
        14 => 'LEJANIAS', 
        15 => 'MAPIRIPAN', 
        16 => 'MESETAS', 
        17 => 'PUERTO CONCORDIA', 
        18 => 'PUERTO GAITAN', 
        19 => 'PUERTO LLERAS', 
        20 => 'PUERTO LOPEZ', 
        21 => 'PUERTO RICO', 
        22 => 'RESTREPO', 
        23 => 'SAN CARLOS DE GUAROA', 
        24 => 'SAN JUAN DE ARAMA', 
        25 => 'SAN JUANITO', 
        26 => 'SAN MARTIN', 
        27 => 'URIBE', 
        28 => 'VILLAVICENCIO', 
        29 => 'VISTAHERMOSA', 
    ), 
    21 => array( 
        1 => 'ABREGO', 
        2 => 'ARBOLEDAS', 
        3 => 'BOCHALEMA', 
        4 => 'BUCARASICA', 
        5 => 'CACHIRA', 
        6 => 'CACOTA', 
        7 => 'CHINACOTA', 
        8 => 'CHITAGA', 
        9 => 'CONVENCION', 
        10 => 'CUCUTA', 
        11 => 'CUCUTILLA', 
        12 => 'DURANIA', 
        13 => 'EL CARMEN', 
        14 => 'EL TARRA', 
        15 => 'EL ZULIA', 
        16 => 'GRAMALOTE', 
        17 => 'HACARI', 
        18 => 'HERRAN', 
        19 => 'LA ESPERANZA', 
        20 => 'LA PLAYA', 
        21 => 'LABATECA', 
        22 => 'LOS PATIOS', 
        23 => 'LOURDES', 
        24 => 'MUTISCUA', 
        25 => 'OCANA', 
        26 => 'PAMPLONA', 
        27 => 'PAMPLONITA', 
        28 => 'PUERTO SANTANDER', 
        29 => 'RAGONVALIA', 
        30 => 'SALAZAR', 
        31 => 'SAN CALIXTO', 
        32 => 'SAN CAYETANO', 
        33 => 'SANTIAGO', 
        34 => 'SARDINATA', 
        35 => 'SILOS', 
        36 => 'TEORAMA', 
        37 => 'TIBU', 
        38 => 'TOLEDO', 
        39 => 'VILLA CARO', 
        40 => 'VILLA DEL ROSARIO', 
    ), 
    22 => array( 
        1 => 'ALBAN', 
        2 => 'ALDANA', 
        3 => 'ANCUYA', 
        4 => 'ARBOLEDA', 
        5 => 'BARBACOAS', 
        6 => 'BELEN', 
        7 => 'BUESACO', 
        8 => 'CHACHAGUI', 
        9 => 'COLON (GEnova)', 
        10 => 'CONSACA', 
        11 => 'CONTADERO', 
        12 => 'CORDOBA', 
        13 => 'CUASPUD', 
        14 => 'CUMBAL', 
        15 => 'CUMBITARA', 
        16 => 'EL CHARCO', 
        17 => 'EL PENOL', 
        18 => 'EL ROSARIO', 
        19 => 'EL TABLON', 
        20 => 'EL TAMBO', 
        21 => 'FRANCISCO PIZARRO', 
        22 => 'FUNES', 
        23 => 'GUACHUCAL', 
        24 => 'GUAITARILLA', 
        25 => 'GUALMATAN', 
        26 => 'ILES', 
        27 => 'IMUES', 
        28 => 'IPIALES', 
        29 => 'LA CRUZ', 
        30 => 'LA FLORIDA', 
        31 => 'LA LLANADA', 
        32 => 'LA TOLA', 
        33 => 'LA UNION', 
        34 => 'LEIVA', 
        35 => 'LINARES', 
        36 => 'LOS ANDES', 
        37 => 'MAG&Uuml;I', 
        38 => 'MALLAMA', 
        39 => 'MOSQUERA', 
        40 => 'NARINO', 
        41 => 'OLAYA HERRERA', 
        42 => 'OSPINA', 
        43 => 'PASTO', 
        44 => 'POLICARPA', 
        45 => 'POTOSI', 
        46 => 'PROVIDENCIA', 
        47 => 'PUERRES', 
        48 => 'PUPIALES', 
        49 => 'RICAURTE', 
        50 => 'ROBERTO PAYAN', 
        51 => 'SAMANIEGO', 
        52 => 'SAN BERNARDO', 
        53 => 'SAN LORENZO', 
        54 => 'SAN PABLO', 
        55 => 'SAN PEDRO DE CARTAGO', 
        56 => 'SANDONA', 
        57 => 'SANTA BARBARA', 
        58 => 'SANTA CRUZ', 
        59 => 'SAPUYES', 
        60 => 'TAMINANGO', 
        61 => 'TANGUA', 
        62 => 'TUMACO', 
        63 => 'TUQUERRES', 
        64 => 'YACUANQUER', 
    ), 
    23 => array( 
        1 => 'COLON', 
        2 => 'MOCOA', 
        3 => 'ORITO', 
        4 => 'PUERTO ASIS', 
        5 => 'PUERTO CAICEDO', 
        6 => 'PUERTO GUZMAN', 
        7 => 'PUERTO LEGUIZAMO', 
        8 => 'SAN FRANCISCO', 
        9 => 'SAN MIGUEL', 
        10 => 'SANTIAGO', 
        11 => 'SIBUNDOY', 
        12 => 'VALLE DEL GUAMUEZ', 
        13 => 'VILLAGARZON', 
    ), 
    24 => array( 
        1 => 'ARMENIA', 
        2 => 'BUENAVISTA', 
        3 => 'CALARCA', 
        4 => 'CIRCASIA', 
        5 => 'CORDOBA', 
        6 => 'FILANDIA', 
        7 => 'GENOVA', 
        8 => 'LA TEBAIDA', 
        9 => 'MONTENEGRO', 
        10 => 'PIJAO', 
        11 => 'QUIMBAYA', 
        12 => 'SALENTO', 
    ), 
    25 => array( 
        1 => 'APIA', 
        2 => 'BALBOA', 
        3 => 'BELEN DE UMBRIA', 
        4 => 'DOSQUEBRADAS', 
        5 => 'GUATICA', 
        6 => 'LA CELIA', 
        7 => 'LA VIRGINIA', 
        8 => 'MARSELLA', 
        9 => 'MISTRATO', 
        10 => 'PEREIRA', 
        11 => 'PUEBLO RICO', 
        12 => 'QUINCHIA', 
        13 => 'SANTA ROSA DE CABAL', 
        14 => 'SANTUARIO', 
    ), 
    26 => array( 
        1 => 'PROVIDENCIA Y SANTA CATALINA', 
        2 => 'SAN ANDRES', 
    ), 
    27 => array( 
        1 => 'AGUADA', 
        2 => 'ALBANIA', 
        3 => 'ARATOCA', 
        4 => 'BARBOSA', 
        5 => 'BARICHARA', 
        6 => 'BARRANCABERMEJA', 
        7 => 'BETULIA', 
        8 => 'BOLIVAR', 
        9 => 'BUCARAMANGA', 
        10 => 'CABRERA', 
        11 => 'CALIFORNIA', 
        12 => 'CAPITANEJO', 
        13 => 'CARCASI', 
        14 => 'CEPITA', 
        15 => 'CERRITO', 
        16 => 'CHARALA', 
        17 => 'CHARTA', 
        18 => 'CHIMA', 
        19 => 'CHIPATA', 
        20 => 'CIMITARRA', 
        21 => 'CONCEPCION', 
        22 => 'CONFINES', 
        23 => 'CONTRATACION', 
        24 => 'COROMORO', 
        25 => 'CURITI', 
        26 => 'EL CARMEN', 
        27 => 'EL GUACAMAYO', 
        28 => 'EL PENON', 
        29 => 'EL PLAYON', 
        30 => 'ENCINO', 
        31 => 'ENCISO', 
        32 => 'FLORIAN', 
        33 => 'FLORIDABLANCA', 
        34 => 'GALAN', 
        35 => 'GAMBITA', 
        36 => 'GIRON', 
        37 => 'GUACA', 
        38 => 'GUADALUPE', 
        39 => 'GUAPOTA', 
        40 => 'GUAVATA', 
        41 => 'G&Uuml;EPSA', 
        42 => 'HATO', 
        43 => 'JESUS MARIA', 
        44 => 'JORDAN', 
        45 => 'LA BELLEZA', 
        46 => 'LA PAZ', 
        47 => 'LANDAZURI', 
        48 => 'LEBRIJA', 
        49 => 'LOS SANTOS', 
        50 => 'MACARAVITA', 
        51 => 'MALAGA', 
        52 => 'MATANZA', 
        53 => 'MOGOTES', 
        54 => 'MOLAGAVITA', 
        55 => 'OCAMONTE', 
        56 => 'OIBA', 
        57 => 'ONZAGA', 
        58 => 'PALMAR', 
        59 => 'PALMAS DEL SOCORRO', 
        60 => 'PARAMO', 
        61 => 'PIEDECUESTA', 
        62 => 'PINCHOTE', 
        63 => 'PUENTE NACIONAL', 
        64 => 'PUERTO PARRA', 
        65 => 'PUERTO WILCHES', 
        66 => 'RIONEGRO', 
        67 => 'SABANA DE TORRES', 
        68 => 'SAN ANDRES', 
        69 => 'SAN BENITO', 
        70 => 'SAN GIL', 
        71 => 'SAN JOAQUIN', 
        72 => 'SAN JOSE DE MIRANDA', 
        73 => 'SAN MIGUEL', 
        74 => 'SAN VICENTE DE CHUCURI', 
        75 => 'SANTA BARBARA', 
        76 => 'SANTA HELENA DEL OPON', 
        77 => 'SIMACOTA', 
        78 => 'SOCORRO', 
        79 => 'SUAITA', 
        80 => 'SUCRE', 
        81 => 'SURATA', 
        82 => 'TONA', 
        83 => 'VALLE DE SAN JOSE', 
        84 => 'VELEZ', 
        85 => 'VETAS', 
        86 => 'VILLANUEVA', 
        87 => 'ZAPATOCA', 
    ), 
    28 => array( 
        1 => 'BUENAVISTA', 
        2 => 'CAIMITO', 
        3 => 'CHALAN', 
        4 => 'COLOSO', 
        5 => 'COROZAL', 
        6 => 'COVENAS', 
        7 => 'EL ROBLE', 
        8 => 'GALERAS', 
        9 => 'GUARANDA', 
        10 => 'LA UNION', 
        11 => 'LOS PALMITOS', 
        12 => 'MAJAGUAL', 
        13 => 'MORROA', 
        14 => 'OVEJAS', 
        15 => 'PALMITO', 
        16 => 'SAMPUES', 
        17 => 'SAN BENITO ABAD', 
        18 => 'SAN JUAN DE BETULIA', 
        19 => 'SAN MARCOS', 
        20 => 'SAN ONOFRE', 
        21 => 'SAN PEDRO', 
        22 => 'SINCE', 
        23 => 'SINCELEJO', 
        24 => 'SUCRE', 
        25 => 'TOLU', 
        26 => 'TOLUVIEJO', 
    ), 
    29 => array( 
        1 => 'ALPUJARRA', 
        2 => 'ALVARADO', 
        3 => 'AMBALEMA', 
        4 => 'ANZOATEGUI', 
        5 => 'ARMERO', 
        6 => 'ATACO', 
        7 => 'CAJAMARCA', 
        8 => 'CARMEN DE APICALA', 
        9 => 'CASABIANCA', 
        10 => 'CHAPARRAL', 
        11 => 'COELLO', 
        12 => 'COYAIMA', 
        13 => 'CUNDAY', 
        14 => 'DOLORES', 
        15 => 'ESPINAL', 
        16 => 'FALAN', 
        17 => 'FLANDES', 
        18 => 'FRESNO', 
        19 => 'GUAMO', 
        20 => 'HERVEO', 
        21 => 'HONDA', 
        22 => 'IBAGUE', 
        23 => 'ICONONZO', 
        24 => 'LERIDA', 
        25 => 'LIBANO', 
        26 => 'MARIQUITA', 
        27 => 'MELGAR', 
        28 => 'MURILLO', 
        29 => 'NATAGAIMA', 
        30 => 'ORTEGA', 
        31 => 'PALOCABILDO', 
        32 => 'PIEDRAS', 
        33 => 'PLANADAS', 
        34 => 'PRADO', 
        35 => 'PURIFICACION', 
        36 => 'RIOBLANCO', 
        37 => 'RONCESVALLES', 
        38 => 'ROVIRA', 
        39 => 'SALDANA', 
        40 => 'SAN ANTONIO', 
        41 => 'SAN LUIS', 
        42 => 'SANTA ISABEL', 
        43 => 'SUAREZ', 
        44 => 'VALLE DE SAN JUAN', 
        45 => 'VENADILLO', 
        46 => 'VILLAHERMOSA', 
        47 => 'VILLARRICA', 
    ), 
    30 => array( 
        1 => 'ALCALA', 
        2 => 'ANDALUCIA', 
        3 => 'ANSERMANUEVO', 
        4 => 'ARGELIA', 
        5 => 'BOLIVAR', 
        6 => 'BUENAVENTURA', 
        7 => 'BUGA', 
        8 => 'BUGALAGRANDE', 
        9 => 'CAICEDONIA', 
        10 => 'CALI', 
        11 => 'CALIMA', 
        12 => 'CANDELARIA', 
        13 => 'CARTAGO', 
        14 => 'DAGUA', 
        15 => 'EL AGUILA', 
        16 => 'EL CAIRO', 
        17 => 'EL CERRITO', 
        18 => 'EL DOVIO', 
        19 => 'FLORIDA', 
        20 => 'GINEBRA', 
        21 => 'GUACARI', 
        22 => 'JAMUNDI', 
        23 => 'LA CUMBRE', 
        24 => 'LA UNION', 
        25 => 'LA VICTORIA', 
        26 => 'OBANDO', 
        27 => 'PALMIRA', 
        28 => 'PRADERA', 
        29 => 'RESTREPO', 
        30 => 'RIOFRIO', 
        31 => 'ROLDANILLO', 
        32 => 'SAN PEDRO', 
        33 => 'SEVILLA', 
        34 => 'TORO', 
        35 => 'TRUJILLO', 
        36 => 'TULUA', 
        37 => 'ULLOA', 
        38 => 'VERSALLES', 
        39 => 'VIJES', 
        40 => 'YOTOCO', 
        41 => 'YUMBO', 
        42 => 'ZARZAL', 
    ), 
    31 => array( 
        1 => 'CARURU', 
        2 => 'MITU', 
        3 => 'PACOA', 
        4 => 'PAPUNAUA', 
        5 => 'TARAIRA', 
        6 => 'YAVARATE', 
    ), 
    32 => array( 
        1 => 'CUMARIBO', 
        2 => 'LA PRIMAVERA', 
        3 => 'PUERTO CARRENO', 
        4 => 'SANTA ROSALIA', 
    ), 
); 
        
        
        
        //---------------- FIN ARRAY LUGARES
        
     
    // ---------------- CONTROL: Select --------------------------------------------------------
        $esteCampo = 'lugarRegistro';
        $atributos['nombre'] = $esteCampo;
        $atributos['id'] = $esteCampo;
        $atributos['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        $atributos['tab'] = $tab;
        $atributos['seleccion'] = -1;
        $atributos['evento'] = ' ';
        $atributos['deshabilitado'] = false;
        $atributos['limitar']= 50;
        $atributos['tamanno']= 1;
        $atributos['columnas']= 1;
        
        $atributos ['ajax_function'] = "";
        $atributos ['ajax_control'] = $esteCampo;
        
        $atributos ['obligatorio'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required';
                   
                  $tsDepartamentos = array( 
    array(1,'AMAZONAS'), 
    array(2,'ANTIOQUIA'), 
    array(3,'ARAUCA'), 
    array(4,'ATLANTICO'), 
    array(5,'BOLIVAR'), 
    array(6,'BOYACA'), 
    array(7,'CALDAS'), 
    array(8,'CAQUETA'), 
    array(9,'CASANARE'), 
    array(10,'CAUCA'), 
    array(11,'CESAR'), 
    array(12,'CHOCO'), 
    array(13,'CORDOBA'), 
    array(14,'CUNDINAMARCA'), 
    array(15,'GUAINIA'), 
    array(16,'GUAJIRA'), 
    array(17,'GUAVIARE'), 
    array(18,'HUILA'), 
    array(19,'MAGDALENA'), 
    array(20,'META'), 
    array(21,'N SANTANDER'), 
    array(22,'NARINO'), 
    array(23,'PUTUMAYO'), 
    array(24,'QUINDIO'), 
    array(25,'RISARALDA'), 
    array(26,'SAN ANDRES'), 
    array(27,'SANTANDER'), 
    array(28,'SUCRE'), 
    array(29,'TOLIMA'), 
    array(30,'VALLE DEL CAUCA'), 
    array(31,'VAUPES'), 
    array(32,'VICHADA'), 
); 
        
        $atributos['matrizItems'] = $tsDepartamentos;
        
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
        $esteCampo = 'nomRepreRegistro';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        
        $atributos ['obligatorio'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, minSize[2]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
         // ---------------- CONTROL: Cuadro de Texto --------------------------------------------------------
        $esteCampo = 'emailRegistro';
        $atributos ['id'] = $esteCampo;
        $atributos ['nombre'] = $esteCampo;
        $atributos ['tipo'] = 'text';
        $atributos ['estilo'] = 'jqueryui';
        $atributos ['marco'] = true;
        $atributos ['columnas'] = 1;
        $atributos ['dobleLinea'] = false;
        $atributos ['tabIndex'] = $tab;
        $atributos ['etiqueta'] = $this->lenguaje->getCadena ( $esteCampo );
        
        $atributos ['obligatorio'] = true;
        $atributos ['etiquetaObligatorio'] = true;
        $atributos ['validar'] = 'required, minSize[2]';
        
        if (isset ( $_REQUEST [$esteCampo] )) {
        	$atributos ['valor'] = $_REQUEST [$esteCampo];
        } else {
        	$atributos ['valor'] = '';
        }
        $atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo . 'Titulo' );
        $atributos ['deshabilitado'] = false;
        $atributos ['tamanno'] = 20;
        $atributos ['maximoTamanno'] = '';
        $tab ++;
        
        // Aplica atributos globales al control
        $atributos = array_merge ( $atributos, $atributosGlobales );
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        // --------------- FIN CONTROL : Cuadro de Texto --------------------------------------------------
        
        
        // ------------------Division para los botones-------------------------
        $atributos ["id"] = "botones";
        $atributos ["estilo"] = "marcoBotones";
        $atributos ["titulo"] = "Enviar Información";
        echo $this->miFormulario->division ( "inicio", $atributos );

        // -----------------CONTROL: Botón ----------------------------------------------------------------
        $esteCampo = 'enviarRegistro';
        $atributos ["id"] = $esteCampo;
        $atributos ["tabIndex"] = $tab;
        $atributos ["tipo"] = 'boton';
        // submit: no se coloca si se desea un tipo button genérico
        $atributos ['submit'] = true;
        $atributos ["estiloMarco"] = '';
        $atributos ["estiloBoton"] = 'jqueryui';
        // verificar: true para verificar el formulario antes de pasarlo al servidor.
        $atributos ["verificar"] = '';
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

        $valorCodificado = "actionBloque=" . $esteBloque ["nombre"]; //Ir pagina Funcionalidad
        $valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );//Frontera mostrar formulario
        $valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
        $valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
        $valorCodificado .= "&opcion=mostrar";
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