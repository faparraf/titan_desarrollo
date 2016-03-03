<?php

// URL base
$url = $this->miConfigurador->getVariableConfiguracion ( "host" );
$url .= $this->miConfigurador->getVariableConfiguracion ( "site" );
$url .= "/index.php?";
//Variables
$cadenaACodificar17 = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( "pagina" );
$cadenaACodificar17 .= "&procesarAjax=true";
$cadenaACodificar17 .= "&action=index.php";
$cadenaACodificar17 .= "&bloqueNombre=" . $esteBloque ["nombre"];
$cadenaACodificar17 .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$cadenaACodificar17 .= $cadenaACodificar17 . "&funcion=consultarNominaAjax";
$cadenaACodificar17 .= "&tiempo=" . $_REQUEST ['tiempo'];
// Codificar las variables
$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
$cadena17 = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $cadenaACodificar17, $enlace );
// URL definitiva
$urlFinal17 = $url . $cadena17;
?>

<script>
    $('#<?php echo $this->campoSeguro('tipo_vinculacion')?>').width(250);
$("#<?php echo $this->campoSeguro('tipo_vinculacion')?>").select2();
$('#<?php echo $this->campoSeguro('tipo_nomina')?>').width(250);
$("#<?php echo $this->campoSeguro('tipo_nomina')?>").select2();

    function consultarCiudad(elem, request, response){
		  $.ajax({
		    url: "<?php echo $urlFinal17?>",
		    dataType: "json",
		    data: { valor:$("#<?php echo $this->campoSeguro('tipo_vinculacion')?>").val()},
		    success: function(data){ 
		        if(data[0]!=" "){
		            $("#<?php echo $this->campoSeguro('tipo_nomina')?>").html('');
		            $("<option value=''>Seleccione  ....</option>").appendTo("#<?php echo $this->campoSeguro('tipo_nomina')?>");
		            $.each(data , function(indice,valor){
		            	$("<option value='"+data[ indice ].id+"'>"+data[ indice ].nombre+"</option>").appendTo("#<?php echo $this->campoSeguro('tipo_nomina')?>");
		            	
		            });
		            
		            $("#<?php echo $this->campoSeguro('tipo_nomina')?>").removeAttr('disabled');
		            
		            $('#<?php echo $this->campoSeguro('tipo_nomina')?>').width(250);
		            $("#<?php echo $this->campoSeguro('tipo_nomina')?>").select2();
		            
		           
		            
			        }
		    			
		    }
			                    
		   });
		};

                
          $(function () {
	        
	        $("#<?php echo $this->campoSeguro('tipo_vinculacion')?>").change(function(){
	        	if($("#<?php echo $this->campoSeguro('tipo_vinculacion')?>").val()!=''){
	            	consultarCiudad();
	    		}else{
	    			$("#<?php echo $this->campoSeguro('tipo_nomina')?>").attr('disabled','');
	    			}
	    	      });
	        
		
                
	    });
</script>