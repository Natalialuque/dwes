<?php

	$config=array("CONTROLADOR"=> array("Paradas","ver"),
				  "RUTAS_INCLUDE"=>array("aplicacion/modelos","aplicacion/varios"),
				  "URL_AMIGABLES"=>true,
				  "VARIABLES"=>array("autor"=>"Natalia Cabello",
				  					"direccion"=>" C/ Carrera - 12",
									"grupo"=>"2daw",
									"N_Paradas" => 0
								),
				  "BD"=>array("hay"=>false,
								"servidor"=>"localhost",
								"usuario"=>"root",
								"contra"=>"root",
								"basedatos"=>"practica10"),
					"sesion"=>array("controlAutomatico"=>true),
					"ACL"=>array("controlAutomatico"=>false) 			
 			
				  );

