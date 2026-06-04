<?php

	$config=array("CONTROLADOR"=> array("inicial"),
				  "RUTAS_INCLUDE"=>array("aplicacion/modelos","aplicacion/auxiliares"),
				  "URL_AMIGABLES"=>true,
				  "VARIABLES"=>array("autor"=>"Vicente Tejero",
				  					"direccion"=>" C/ Carrera - 12",
									"grupo"=>"2daw"
								),
				  "BD"=>array("hay"=>false,
								"servidor"=>"localhost",
								"usuario"=>"root",
								"contra"=>"root",
								"basedatos"=>"practica9"),
					"sesion"=>array("controlAutomatico"=>true),
					"ACL"=>array("controlAutomatico"=>true) 			
 			
				  );

