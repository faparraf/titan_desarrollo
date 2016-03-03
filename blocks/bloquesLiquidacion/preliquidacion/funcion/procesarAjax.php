<?php


$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);



if ($_REQUEST ['funcion'] == 'consultarNominaAjax') {

	$cadenaSql = $this->sql->getCadenaSql ( 'buscarNomina', $_REQUEST['valor'] );
	$resultado = $esteRecursoDB->ejecutarAcceso ( $cadenaSql, "busqueda" );

        
	$resultado = json_encode ( $resultado);

	echo $resultado;
}

?>

