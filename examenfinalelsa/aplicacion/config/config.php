<?php

$config = array(
	"CONTROLADOR" => array("trayectos"),
	"RUTAS_INCLUDE" => array("aplicacion/modelos", "aplicacion/clases", "aplicacion/utilidades"),
	"URL_AMIGABLES" => true,
	"VARIABLES" => array(
		"autor" => "Elsa Reca",
		"direccion" => "C/ Carrera - Madre Carmen, 12",
		"grupo" => "2º Daw",
		"curso" => "2024/2025",
		"N_Paradas"=>0,
	),
	//   "BD"=>array("hay"=>true,
	// 				"servidor"=>"localhost",
	// 				"usuario"=>"2daw14",
	// 				"contra"=>"2daw",
	// 				"basedatos"=>"BD2DAW14"), 			
	"BD" => array(
		"hay" => false,
		"servidor" => "localhost",
		"usuario" => "usuario12",
		"contra" => "2daw",
		"basedatos" => "relacion12"
	),
	"sesion" => array("controlAutomatico" => true),
	"ACL" => array("controlAutomatico" => FALSE),
);
