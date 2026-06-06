<?php

	$config=array("CONTROLADOR"=> array("pueblos","index"),
				  "RUTAS_INCLUDE"=>array("aplicacion/modelos","aplicacion/otros_elementos"),
				  "URL_AMIGABLES"=>true,
				  "VARIABLES"=>array("autor"=>"Jaime Vargas",
				  					"direccion"=>" C/ Carrera - 12",
									"grupo"=>"2daw"
								),
				  "BD"=>array("hay"=>false,
								"servidor"=>"localhost",
								"usuario"=>"root",
								"contra"=>"2daw",
								"basedatos"=>"practica10"),
					// para que la sesion se cree automaticamente
					"sesion"=>array("controlAutomatico"=>true)			
				  );
					

