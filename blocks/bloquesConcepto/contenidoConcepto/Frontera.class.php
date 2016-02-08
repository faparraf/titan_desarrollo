<?

namespace bloquesConcepto\contenidoConcepto;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
class Frontera {
	var $ruta;
	var $sql;
	var $funcion;
	var $lenguaje;
	var $miFormulario;
	var 

	$miConfigurador;
	function __construct() {
		$this->miConfigurador = \Configurador::singleton ();
	}
	public function setRuta($unaRuta) {
		$this->ruta = $unaRuta;
	}
	public function setLenguaje($lenguaje) {
		$this->lenguaje = $lenguaje;
	}
	public function setFormulario($formulario) {
		$this->miFormulario = $formulario;
	}
	function frontera() {
		$this->html ();
	}
	function setSql($a) {
		$this->sql = $a;
	}
	function setFuncion($funcion) {
		$this->funcion = $funcion;
	}
	function html() {
		
		
        $this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");
       

		
        if(isset($_REQUEST['opcion'])){
			switch ($_REQUEST ['opcion']) {
				
				case "registrar" :
					include_once ($this->ruta . "/formulario/registrarInfoBasica.php");
					break;
				case "siguiente" :
					include_once ($this->ruta . "/formulario/registrarFormulacion.php");
					break;
				case "condicion" :
					include_once ($this->ruta . "/formulario/registrarCondicion.php");
					break;
				case "modificar" :
					include_once ($this->ruta . "/formulario/modificar.php");
					break;
				case "verdetalle" :
					include_once ($this->ruta . "/formulario/verdetalle.php");
					break;
				case "inactivar" :
					include_once ($this->ruta . "/formulario/inactivar.php");
					break;
				case "mensaje" :
					include_once ($this->ruta . "/formulario/mensaje.php");
					break;
				case "form" :
					include_once ($this->ruta . "/formulario/form.php");
					break;
				case "detalle" :
					include_once ($this->ruta . "/formulario/detalle.php");
					break;  
        		}
                       
                       
		}else{
			include_once ($this->ruta . "/formulario/form.php");
		}
	}
}
?>
