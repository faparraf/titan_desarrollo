<?php
namespace bloquesConcepto\contenidoConcepto\funcion;
//include 'NodoConceptoInterfaz.php';
/**
*	NodoConcepto
*	@package 	Interprete
*	@subpackage	NodoConcepto
*	@author 	Fabio Parra
*/
class NodoConcepto{// implements NodoConceptoInterfaz{
	//Nombre del concepto que se esta evaluando
	var $nombreConcepto	= null;

	//Valor del concepto que se esta evaluando
	var $valorConcepto	= null;

	//Referencia de consulta propia del concepto
	var $referencia		= null;

	//Operadores involucrados en el calculo del valor del concepto
	var $operadores		= null;

	//Conceptos hojas del actual objeto
	var $conceptos		= array();

	/**
	*	Constructor de la clase nodoConcepto
	*	@param string $nombreConcepto Nombre del concepto que se esta evaluando
	*	@param string $referencia Referencia de consulta propia del concepto
	*	@param array $operadores Operadores involucrados en el calculo del valor del concepto
	*	@param array $conceptos Array de objetos tipo nodoConcepto
	*	@param double $valorConcepto Valor concreto del concepto en caso de tratarse de una hoja
	*/
	function __construct($nombreConcepto, $referencia, $operadores, $conceptos, $valorConcepto = null){
		$this->nombreConcepto	= $nombreConcepto;
		$this->valorConcepto	= $valorConcepto;
		$this->referencia		= $referencia;
		$this->operadores		= $operadores;
		$this->conceptos		= array();
	}

	/**
	*	Funcion para modificar el valor del concepto con base a los conceptos que esten en el objeto $conceptos
	*/
	function evaluarConcepto($referencia){
            if($this->valorConcepto == null){
                if($this->referencia == null){
                    foreach ($this->conceptos as $concepto){
                        $concepto->evaluarConcepto($referencia);
                    }
                    switch($this->operadores){
                        case '+':
                            $this->valorConcepto = $this->conceptos[1] + $this->conceptos[0];
                            break;
                        case '-':
                            $this->valorConcepto = $this->conceptos[1] - $this->conceptos[0];
                            break;
                        case '*':
                            $this->valorConcepto = $this->conceptos[1] * $this->conceptos[0];
                            break;
                        case '/':
                            $this->valorConcepto = $this->conceptos[1] / $this->conceptos[0];
                            break;
                        case '^':
                            $this->valorConcepto = pow($this->conceptos[1], $this->conceptos[0]);
                            break;
                    }
                }else{
                    $this->valorConcepto = $referencia[$this->nombreConcepto];
                }
            }
	}

	/**
	*	Funcion para retornar el valor del concepto
	*	@return	double
	*/
	function getValor(){
		return $this->valorConcepto;
	}

	/**
	*	Funcion para retornar el nombre del concepto
	*	@return string
	*/
	function getNombre(){
		return $this->nombreConcepto;
	}

	function setConceptos($conceptos){
		$this->conceptos = $conceptos;
	}

	function agregarConcepto($concepto){
		$this->conceptos[count($this->conceptos)] = $concepto;
	}

	function setOperador($operador){
		$this->operadores = $operador;
	}

	function __toString(){
		return "$this->nombreConcepto  $this->valorConcepto";
	}
        
        function clonar(){
            return clone $this;
        }
        
        function getListaReferencias(){
            $referencias = array();
            if($this->referencia != null){
                $referencias[$this->nombreConcepto] = $this->referencia;
            }
            foreach($this->conceptos as $concepto){
                $referencias = array_merge($referencias, $concepto->getListaReferencia);
            }
            return $referencias;
        }

}

?>