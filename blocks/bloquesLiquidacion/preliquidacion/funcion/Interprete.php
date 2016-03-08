<?php
namespace bloquesConcepto\contenidoConcepto\funcion;
//include 'InterpreteInterfaz.php';
include "NodoConcepto.php";

/**
*	Interprete
*	@package 	Interprete
*	@subpackage	Interprete
*	@author 	Fabio Parra
*/
class Interprete{//] implements InterpreteInterfaz{
        
    
        var $miSql;
        var $lenguaje;
        var $primerRecursoDB;
        
	/**
	*	Constructor de la clase Interprete
	*/
	function __construct($lenguaje, $sql, $primerRecurso){
            $this->miSql = $sql;
            $this->lenguaje = $lenguaje;
            $this->primerRecursoDB = $primerRecurso;
	}

	/**
	*	Verifica la validez de una sentencia
	*	@param  string $sentencia cadena de texto con la sentencia a evaluar
	*	@return	boolean
	*/
	function evaluarSentencia($sentencia){
		$long_variable = 5;
		$chars = str_split($sentencia);
		$flag_numero = false;
		$flag_variable = 0;
		$flag_parentesis = 0;
		$flag_signo = false;
		$pos = 0;
		foreach ($chars as $caracter) {
			if($caracter == "("){
				try{
					$caracTemp = $chars[$pos+1];
					if($caracTemp == "+" ||$caracTemp == "*" ||$caracTemp == "/" ||$caracTemp == "^"){
						return "No puede haber signos despues de un parentesis";
					}
				}catch(Exceptio $e){

				}
				$flag_parentesis++;
			}
			if($caracter == ")"){
				if($flag_signo){
					return "Hay un error en la ubicacion del parentesis en la posicion $pos";
				}
				$flag_parentesis--;
			}
			if($caracter == "+" || $caracter == "-" ||$caracter == "*" ||$caracter == "/" ||$caracter == "^"){
				if($flag_signo){
					return "Hay dos signos seguidos en la posicion $pos";
				}else{
					$flag_signo=true;
				}
			}
			if($caracter != "+" && $caracter != "-" &&$caracter != "*" &&$caracter != "/" &&$caracter != "^"){
				$flag_signo=false;
			}
			if(preg_match("/[A-Z]|_/", $caracter)){
				$flag_variable++;
			}
			if(!preg_match("/[A-Z]|_/", $caracter)){
				if($flag_variable<$long_variable && $flag_variable>0){
					return "La variable no existe en la posicion $pos";
				}else if($flag_variable==$long_variable){
					$flag_variable=0;
				}
			}
			if($flag_parentesis<0){
				return "Parentesis fuera de sitio en la posicion $pos";
			}
			if($flag_variable>$long_variable){
				return "La variable no existe en la posicion $pos";
			}
			$pos++;
		}
		if($flag_parentesis>0){
			return "Todos los parentesis deben cerrarse";
		}
		return "true";
	}

	/**
	*	Devuelve un valor que representa la importancia jerarquica del operador
	*	@param  string $operador signo de la operacion que se quiere consultar 
	*	@return	int
	*/
	function jerarquiaOperador($operador){
    	switch($operador){
    		case "+":
    			return 1;
    		break;
    		case "-":
    			return 1;
    		break;
    		case "*":
    			return 2;
    		break;
    		case "/":
    			return 2;
    		break;
    		case "^":
    			return 3;
                    break;
    		case "(":
    			return 4;
                    break;
    		case ")":
    			return 4;
    		break;
    	}
    }
    
    /**
	*	Genera el arbol de operaciones del concepto
	*	@param  string $nomina cadena de texto con la formula de calculo de la nomina 
	*	@return	NodoConcepto
	*/
    function generarArbol($nomina, $concepto = false){
        if($concepto != false){
            $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarFormulaConcepto",$nomina );
            $temp = $this->primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
            if($temp != false){
                $nombre = $nomina;
                $nomina = $temp[0]['formula'];
            }else{
                $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarValorParametro",$nomina );
                $temp = $this->primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
                if($temp != false){
                    return new NodoConcepto($nomina,null,null,null,$temp[0]['valor']);
                }else{
                    $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarReferenciaVariable",$nomina );
                    $temp = $this->primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
                    return new NodoConcepto($nomina,$temp[0]['valor'],null,null);
                }
            }
            
        }
    	preg_match_all("/[A-Z|_]{5}|[0-9]+|[^A-Z|^_]|[^0-9]/", $nomina, $chars);
    	$chars = $chars[0];
    	$stack = array();
    	$nivelSigno = array();
    	$nivelActual = 0;
    	$vaciar = false;
    	$nivelParentesis=0;
    	// echo "<pre>";
    	// print_r($chars);
    	// echo "</pre>";
    	
    	foreach ($chars as $caracter) {
    		if(preg_match("/[A-Z|_]{5}|[0-9]+/", $caracter)){
    			array_push($stack, $caracter);
    		}else{
    			if($caracter=="("){
    				$nivelParentesis++;
    				array_push($stack, $caracter);
    			}else if($caracter==")"){
					$vaciar = true;
    				while($vaciar){
    					$caracterPop = array_pop($stack);
    					if($caracterPop  == "("){
    						$vaciar = false;
    					}else{
    							if(get_class($caracterPop)=="NodoConcepto"){
    								$obj1 = $caracterPop;
    							}
    						
	    						else if(preg_match("/[A-Z|_]{5}/", $caracterPop)){
	    							//$obj1 = new NodoConcepto($caracterPop,$caracterPop,null,null,null);
                                                                $obj1 = $this->generarArbol($caracterPop, true);
	    						}else if(preg_match("/[0-9]+/", $caracterPop)){
	    							$obj1 = new NodoConcepto("*",null,null,null,$caracterPop);
	    						}
	    						$caracterPop= array_pop($stack);
	    						$obj2 = new NodoConcepto("*",null,$caracterPop,null,null);
	    						array_pop($nivelSigno[$nivelParentesis]);
	    						$caracterPop= array_pop($stack);
	    						if(get_class($caracterPop)=="NodoConcepto"){
	    							$obj3 = $caracterPop;
	    						}else if(preg_match("/[A-Z|_]{5}/", $caracterPop)){
	    							//$obj3 = new NodoConcepto($caracterPop,$caracterPop,null,null,null);
                                                            $obj3 = $this->generarArbol($caracterPop, true);
	    						}else if(preg_match("/[0-9]+/", $caracterPop)){
	    							$obj3 = new NodoConcepto("*",null,null,null,$caracterPop);
	    						}
	    						$obj2->agregarConcepto($obj1);
	    						$obj2->agregarConcepto($obj3);
	    						$caracterPop= array_pop($stack);
	    						if($caracterPop=="("){
	    							$vaciar = false;
	    							array_push($stack, $obj2);
	    						}else{
	    							array_push($stack, $caracterPop);
	    							array_push($stack, $obj2);
	    						}
	    						
	    					
	    				}
    				}
    				$nivelParentesis--;
    			}else{
	    			$nivelActual = $this->jerarquiaOperador($caracter);
	    			if(count($nivelSigno[$nivelParentesis])==0){
	    				array_push($stack, $caracter);
	    				array_push($nivelSigno[$nivelParentesis], $nivelActual);
	    			}else{
	    				if($nivelActual>$nivelSigno[$nivelParentesis][count($nivelSigno[$nivelParentesis])-1]){
	    					array_push($stack, $caracter);
	    					array_push($nivelSigno[$nivelParentesis], $nivelActual);
	    				}else{
	    					$vaciar = true;
	    					while($vaciar){
		    					$caracterPop = array_pop($stack);
		    					if($nivelActual<=$nivelSigno[$nivelParentesis][count($nivelSigno[$nivelParentesis])-1]){
		    						$vaciar = false;
		    					}else{
		    						if(get_class($caracterPop)=="NodoConcepto"){
		    							$obj1 = $caracterPop;
		    						}else if(preg_match("/[A-Z|_]{5}/", $caracterPop)){
		    							//$obj1 = new NodoConcepto($caracterPop,$caracterPop,null,null,null);
                                                                        $obj1 = $this->generarArbol($caracterPop, true);
		    						}else if(preg_match("/[0-9]+/", $caracterPop)){
		    							$obj1 = new NodoConcepto("*",null,null,null,$caracterPop);
		    						}
		    						$caracterPop= array_pop($stack);
		    						$obj2 = new NodoConcepto("*",null,$caracterPop,null,null);
		    						array_pop($nivelSigno[$nivelParentesis]);
		    						$caracterPop= array_pop($stack);
		    						if(get_class($caracterPop)=="NodoConcepto"){
		    							$obj3 = $caracterPop;
		    						}else if(preg_match("/[A-Z|_]{5}/", $caracterPop)){
		    							//$obj3 = new NodoConcepto($caracterPop,$caracterPop,null,null,null);
                                                                        $obj3 = $this->generarArbol($caracterPop, true);
		    						}else if(preg_match("/[0-9]+/", $caracterPop)){
		    							$obj3 = new NodoConcepto("*",null,null,null,$caracterPop);
		    						}
		    						$obj2->agregarConcepto($obj1);
		    						$obj2->agregarConcepto($obj3);
		    						array_push($stack, $obj2);
		    					}

		    				}
	    				}
	    			}
	    		}
    		}
    		// echo "<pre>";
	    	// print_r($stack);
	    	// echo "</pre>";

	    	// echo "<pre>";
	    	// print_r($nivelSigno[$nivelParentesis]);
	    	// echo "</pre>";
	    	
    	}
    	if(count($stack)>1){
    		$vaciar = true;
    	}
    	while($vaciar){
			$caracterPop = array_pop($stack);
			if(count($stack)==0){//$nivelActual<=$nivelSigno[$nivelParentesis][count($nivelSigno[$nivelParentesis])-1]){
				$vaciar = false;
				array_push($stack, $caracterPop);
			}else{
				if(get_class($caracterPop)=="NodoConcepto"){
					$obj1 = $caracterPop;
				}else if(preg_match("/[A-Z|_]{5}/", $caracterPop)){
					//$obj1 = new NodoConcepto($caracterPop,$caracterPop,null,null,null);
                                        $obj1 = $this->generarArbol($caracterPop, true);
				}else if(preg_match("/[0-9]+/", $caracterPop)){
					$obj1 = new NodoConcepto("*",null,null,null,$caracterPop);
				}
				$caracterPop= array_pop($stack);
				$obj2 = new NodoConcepto("*",null,$caracterPop,null,null);
				$caracterPop= array_pop($stack);
				if(get_class($caracterPop)=="NodoConcepto"){
					$obj3 = $caracterPop;
				}else if(preg_match("/[A-Z|_]{5}/", $caracterPop)){
					//$obj3 = new NodoConcepto($caracterPop,$caracterPop,null,null,null);
                                        $obj3 = $this->generarArbol($caracterPop, true);
				}else if(preg_match("/[0-9]+/", $caracterPop)){
					$obj3 = new NodoConcepto("*",null,null,null,$caracterPop);
				}
				$obj2->agregarConcepto($obj1);
				$obj2->agregarConcepto($obj3);
				array_push($stack, $obj2);
			}

		}
                if($concepto != false){
                    $stack[0]->nombreConcepto = $nombre;
                }
		return $stack[0];
    }
    

    /**
	*	Evalua el arbol de operac9iones con una referencia especifica o una lista de ellas
	*	@param NodoConcepto $nodoConcepto Arbol de operaciones
	*	@param Referencias $referencias Referencias especificas para el calculo de los valores del arbol
	*/
    function evaluarArbol($nodoConcepto, $parametros){
        
        $listaReferencias = $nodoConcepto->getListaReferencias();
        $datosReferencias = $this->obtenerDatosReferencias($listaReferencias);
        $estadisticasReferencias = $this->obtenerEstadisticas($listaReferencias);
        
        $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarPersonasxVinculacion", $parametros['tipo_vinculacion'] );
        $personas = $this->primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
        
        foreach($personas as $persona){
            $nodo = $nodoConcepto->clonar();
            $nodo->evaluarConcepto($referencias[$persona['id']]);
            foreach ($nodo->conceptos as $concepto){
                $atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "insertarCalculoConceptos",
                        array('preliquidacion'=>$parametros['preliquidacion'],
                            'persona'=>$persona['id'],
                            'concepto'=>$concepto->nombreConcepto,
                            'valor'=>$concepto->valorConcepto) );
                $resultado = $this->primerRecursoDB->ejecutarAcceso ( $atributos ['cadena_sql'], "acceso" );
            }
        }   
    }
    
    
    function obtenerEstadisticas($listaReferencias){
        $query = "";
        $queryFrom = "";
        $queryGruop = "";
        $start = 0;
        $cont = $start;
        if(count($listaReferencias) == 1){
            $nombre = key($listaReferencias);
            $query .= "SELECT count(*), valor as \"$nombre\" from (";
            $query .= $listaReferencias[$nombre];
            $query .= ") ref$start";
        }else{
            $query .= "SELECT count(*)";
            
            foreach($listaReferencias as $nombre => $valor){
                
                $query      .= ", ref$cont.\"$nombre\" as \"$nombre\"";
                
                if($cont != $start){
                    $queryFrom .= " FULL JOIN ";
                }
                
                $queryFrom  .= "(".$listaReferencias[$nombre].") ref$cont";
                
                if($cont != $start){
                    $queryFrom .= " ON ref".($cont-1).".id = ref$cont.id ";
                }
                
                $queryGruop .= "\"$nombre\", ";
            }
            
            $query .= " FROM ".$queryFrom." GROUP BY ".$queryGruop;
        }
        $resultado = $this->primerRecursoDB->ejecutarAcceso ( $query, "busqueda" );
        return $resultado;
    }
    
    function obtenerDatosReferencias($referencias){
        $referenciasFinales = null;
        foreach($referencias as $nombre => $referencia){
            $resultado = $this->primerRecursoDB->ejecutarAcceso ( $referencia, "busqueda" );
            $resultado = $this->transformarResultado($resultado, $nombre);
            if($referenciasFinales == null){
                $referenciasFinales = $resultado;
            }else{
                $referenciasFinales = array_merge_recursive($referenciasFinales, $resultado);
            }
        }
        return $referenciasFinales;
    }
    
    function transformarResultado($array, $nombre){
        $new_array = array();
        foreach($array as $registro){
            $new_array[$registro['id'].''][$nombre.''] = $registro['valor'];
        }
        return $new_array;
    }
    
    function filtro_array($array, $filtro){
        $new_array = array();
        $save = true;
        foreach ($array as $key => $value) {
            $save = true;
            foreach ($filtro as $keyFiltro => $valueFiltro){
                if($value[$keyFiltro]!=$valueFiltro){
                    $save = false;
                }
            }
            if($save){
                $new_array[$key] = $value;
            }
        }
        return $new_array;
    }
}



?>