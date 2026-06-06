<?php

	$config=array("CONTROLADOR"=> array("Pueblos","puebloinicial"), //cumplir para que puebloIncial sea por defecto
				  "RUTAS_INCLUDE"=>array("aplicacion/modelos","aplicacion/otrosElementos"),
				  "URL_AMIGABLES"=>true,
				  "VARIABLES"=>array("autor"=>"Natalia Cabello",
				  					"direccion"=>" C/ Carrera - 12",
									"grupo"=>"2daw",
									"N_Pueblos" => 0 //cumplir para que sea variable de aplicacion
								),
				  "BD"=>array("hay"=>false,
								"servidor"=>"localhost",
								"usuario"=>"root",
								"contra"=>"root",
								"basedatos"=>"practica10"),
					"sesion"=>array("controlAutomatico"=>true),
					"ACL"=>array("controlAutomatico"=>true) 			
 			
				  );

