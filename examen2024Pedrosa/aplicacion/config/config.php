<?php

	$config=array("CONTROLADOR"=> array("partida"),
				//para que lea los putos archivos 
				"RUTAS_INCLUDE"=>array(
  				  "aplicacion/modelos",
   				  "aplicacion/auxiliares",
   				 "aplicacion/mislibrerias"
),

				  "URL_AMIGABLES"=>true,
				  "VARIABLES"=>array("autor"=>"Natalia Cabello",
				  					"direccion"=>" C/ Carrera - 12",
									"grupo"=>"2daw"
								),
				 	//Dejar a false base de datos y los controles a true
						"BD"=>array("hay"=>false,
								"servidor"=>"localhost",
								"usuario"=>"root",
								"contra"=>"root",
								"basedatos"=>"practica9"),
					"sesion"=>array("controlAutomatico"=>true),
					"ACL"=>array("controlAutomatico"=>true) 			
 			
				  );

