<?php

/**Esto seria otro contrlador para el tema de usuarios, cambiando el nombre de la clase ya podriamos acceder */
class practica1Controlador extends CControlador
{
	public array $menuizq=[];
	public array $barraUbi=[];

	public function accionIndex()
	{
		
		$this->menuizq = [
			[
				"texto" => "Inicio", 
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Ejercicio1", 
				"enlace" => ["practica1", "ejercicio1"]
			],
			[
				"texto" => "Ejercicio2", 
				"enlace" => ["practica1","ejercicio2"]
			],
			[
				"texto" => "Ejercicio3", 
				"enlace" => ["practica1","ejercicio3"]
			],
			[
				"texto" => "Ejercicio5", 
				"enlace" => ["practica1","ejercicio5"]
			],[
				"texto" => "Ejercicio7", 
				"enlace" => ["practica1","ejercicio7"]
			]
		];
		$this->barraUbi = [
   			 ["texto" => "Inicio", "enlace" => ["inicial"]],
   			 ["texto" => "Practica 1", "enlace" => ["practica1", "index"]]
		];


		
		$this->dibujaVista("miindice",[],"Practica 1");
	}
	

public function accionEjercicio1()
{
    // Menú izquierda
    $this->menuizq = [
        [   "texto" => "Inicio",
             "enlace" => ["practica1"]
        ],
        [   "texto" => "Ejercicio 2",
             "enlace" => ["practica1", "ejercicio2"]
        ],
        [   "texto" => "Ejercicio 3", 
            "enlace" => ["practica1", "ejercicio3"]
        ],
        [   "texto" => "Ejercicio 5", 
            "enlace" => ["practica1", "ejercicio5"]
        ],
        [
            "texto" => "Ejercicio 7", 
            "enlace" => ["practica1", "ejercicio7"]
        ],
    ];

    // Barra de ubicación
    $this->barraUbi = [
        ["texto" => "Inicio", "enlace" => Sistema::app()->generaURL(["inicial"])],
        ["texto" => "Practica 1", "enlace" => Sistema::app()->generaURL(["practica1"])],
        ["texto" => "Ejercicio 1", "enlace" => ""]
    ];

    // FUNCIONES MATEMÁTICAS

    $resultado_round = round(4.7);
    $resultado_floor = floor(5.2);
    $resultado_pow = pow(2, 5);
    $resultado_sqrt = sqrt(49);
    $resultado_dechex = dechex(25);
    $base4_base8 = base_convert(123, 4, 8);
    $resultado_abs = abs(-15);
    $resultado_max = max(3, 7, 2, 9);

    // BINARIO, OCTAL, HEXADECIMAL

    $binario = 0b1010;      // 10
    $octal = 013;           // 11
    $hexadecimal = 0xC;     // 12

    // ENVÍO A LA VISTA

    $this->dibujaVista(
        "ejercicio1",
        [
            "resultado_round" => $resultado_round,
            "resultado_floor" => $resultado_floor,
            "resultado_pow" => $resultado_pow,
            "resultado_sqrt" => $resultado_sqrt,
            "resultado_dechex" => $resultado_dechex,
            "base4_base8" => $base4_base8,
            "resultado_abs" => $resultado_abs,
            "resultado_max" => $resultado_max,

            "binario" => $binario,
            "octal" => $octal,
            "hexadecimal" => $hexadecimal
        ],
        "Ejercicio 1"
    );
}



public function accionEjercicio2()
{
    // Menú izquierda
    $this->menuizq = [
        [   "texto" => "Inicio", 
            "enlace" => ["practica1"]
        ],
        [   "texto" => "Ejercicio 1",
             "enlace" => ["practica1", "ejercicio1"]
        ],
        [   "texto" => "Ejercicio 3", 
            "enlace" => ["practica1", "ejercicio3"]
        ],
        [   "texto" => "Ejercicio 5", 
            "enlace" => ["practica1", "ejercicio5"]
        ],
        [   "texto" => "Ejercicio 7",
             "enlace" => ["practica1", "ejercicio7"]
        ],
    ];

    // Barra de ubicación
    $this->barraUbi = [
        ["texto" => "Inicio", "enlace" => Sistema::app()->generaURL(["inicial"])],
        ["texto" => "Practica 1", "enlace" => Sistema::app()->generaURL(["practica1"])],
        ["texto" => "Ejercicio 2", "enlace" => ""]
    ];


    // FUNCIONES DEL EJERCICIO

    // 6 lanzamientos
    $resultados6 = [];
    for ($i = 1; $i <= 6; $i++) {
        $numero = rand(1, 6);
        $resultados6[] = "Lanzamiento $i del dado: $numero";
    }

    // 1000 lanzamientos
    define("NUM_LANZAMIENTOS", 1000);

    $conteo = array_fill(1, 6, 0);

    for ($i = 0; $i < NUM_LANZAMIENTOS; $i++) {
        $numero = rand(1, 6);
        $conteo[$numero]++;
    }

    $estadisticas = [];
    foreach ($conteo as $cara => $cantidad) {
        $porcentaje = round(($cantidad / NUM_LANZAMIENTOS) * 100, 1);
        $estadisticas[] = "El $cara ha salido $cantidad veces con un porcentaje de $porcentaje%";
    }

    // ENVÍO A LA VISTA

    $this->dibujaVista(
        "ejercicio2",
        [
            "resultados6" => $resultados6,
            "estadisticas" => $estadisticas,
            "numLanzamientos" => NUM_LANZAMIENTOS
        ],
        "Ejercicio 2"
    );
}


public function accionEjercicio3()
{
    // Menú izquierda
    $this->menuizq = [
        [   "texto" => "Inicio",
             "enlace" => ["practica1"]
        ],
        [   "texto" => "Ejercicio 1",
             "enlace" => ["practica1", "ejercicio1"]
        ],
        [   "texto" => "Ejercicio 2", 
            "enlace" => ["practica1", "ejercicio2"]
        ],
        [   "texto" => "Ejercicio 5",
             "enlace" => ["practica1", "ejercicio5"]
        ],
        [   "texto" => "Ejercicio 7", 
            "enlace" => ["practica1", "ejercicio7"]
        ],
    ];

    // Barra de ubicación
    $this->barraUbi = [
        ["texto" => "Inicio", "enlace" => Sistema::app()->generaURL(["inicial"])],
        ["texto" => "Practica 1", "enlace" => Sistema::app()->generaURL(["practica1"])],
        ["texto" => "Ejercicio 3", "enlace" => ""]
    ];

    // ARRAYS DEL EJERCICIO

    // Array 1
    $array1 = [];
    $array1[1] = 2;
    $array1[16] = 17;
    $array1[54] = 55;
    $array1[] = 34;

    // Array 2
    $array2 = [];
    $array2["uno"] = "vaffanculo";
    $array2["dos"] = true;
    $array2["tres"] = 1.345;

    // Array 3
    $array3 = [];
    $array3["última"] = [1, 3, 4, "nueva"];

    // Arrays con una sola sentencia
    $array4 = [1 => "valor1", 16 => "valor16", 54 => "valor54", 34];
    $array5 = ["uno" => "cadena", "dos" => true, "tres" => 1.345];
    $array6 = ["última" => [1, 3, 4, "nueva"]];

    // ENVÍO A LA VISTA

    $this->dibujaVista(
        "ejercicio3",
        [
            "array1" => $array1,
            "array2" => $array2,
            "array3" => $array3,
            "array4" => $array4,
            "array5" => $array5,
            "array6" => $array6
        ],
        "Ejercicio 3"
    );
}


public function accionEjercicio7()
{
    // Menú izquierda
    $this->menuizq = [
        [   "texto" => "Inicio",
             "enlace" => ["practica1"]
        ],
        [   "texto" => "Ejercicio 1",
             "enlace" => ["practica1", "ejercicio1"]
        ],
        [   "texto" => "Ejercicio 2",
             "enlace" => ["practica1", "ejercicio2"]
        ],
        [   "texto" => "Ejercicio 3", 
            "enlace" => ["practica1", "ejercicio3"]
        ],
        [   "texto" => "Ejercicio 5", 
            "enlace" => ["practica1", "ejercicio5"]
        ],
    ];

    // Barra de ubicación
    $this->barraUbi = [
        ["texto" => "Inicio", "enlace" => Sistema::app()->generaURL(["inicial"])],
        ["texto" => "Practica 1", "enlace" => Sistema::app()->generaURL(["practica1"])],
        ["texto" => "Ejercicio 7", "enlace" => ""]
    ];

    // USANDO FUNCIONES DE FECHA

    // Fecha actual
    $fechaActual = date("d/m/Y");
    $fechaActualExtendida = "día " . date("d") . ", mes " . date("F") . ", año " . date("Y") . ", día de la semana " . date("l");
    $horaActual = date("H:i:s");

    // Fecha fija
    $fechaFijaTS = mktime(12, 45, 0, 3, 29, 2024);
    $fechaFija = date("d/m/Y", $fechaFijaTS);
    $fechaFijaExtendida = "día " . date("d", $fechaFijaTS) . ", mes " . date("F", $fechaFijaTS) . ", año " . date("Y", $fechaFijaTS) . ", día de la semana " . date("l", $fechaFijaTS);
    $horaFija = date("H:i:s", $fechaFijaTS);

    // Fecha modificada
    $fechaModificadaTS = strtotime("-12 days -4 hours");
    $fechaModificada = date("d/m/Y", $fechaModificadaTS);
    $fechaModificadaExtendida = "día " . date("d", $fechaModificadaTS) . ", mes " . date("F", $fechaModificadaTS) . ", año " . date("Y", $fechaModificadaTS) . ", día de la semana " . date("l", $fechaModificadaTS);
    $horaModificada = date("H:i:s", $fechaModificadaTS);

    // USANDO CLASE DATETIME

    // Fecha actual
    $ahora = new DateTime();
    $dtActual = $ahora->format("d/m/Y");
    $dtActualExtendida = "día " . $ahora->format("d") . ", mes " . $ahora->format("F") . ", año " . $ahora->format("Y") . ", día de la semana " . $ahora->format("l");
    $dtHoraActual = $ahora->format("H:i:s");

    // Fecha fija
    $fechaFijaDT = new DateTime("2024-03-29 12:45:00");
    $dtFija = $fechaFijaDT->format("d/m/Y");
    $dtFijaExtendida = "día " . $fechaFijaDT->format("d") . ", mes " . $fechaFijaDT->format("F") . ", año " . $fechaFijaDT->format("Y") . ", día de la semana " . $fechaFijaDT->format("l");
    $dtHoraFija = $fechaFijaDT->format("H:i:s");

    // Fecha modificada
    $fechaModificadaDT = new DateTime();
    $fechaModificadaDT->modify("-12 days -4 hours");
    $dtModificada = $fechaModificadaDT->format("d/m/Y");
    $dtModificadaExtendida = "día " . $fechaModificadaDT->format("d") . ", mes " . $fechaModificadaDT->format("F") . ", año " . $fechaModificadaDT->format("Y") . ", día de la semana " . $fechaModificadaDT->format("l");
    $dtHoraModificada = $fechaModificadaDT->format("H:i:s");

    // ENVÍO A LA VISTA

    $this->dibujaVista(
        "ejercicio7",
        compact(
            "fechaActual", "fechaActualExtendida", "horaActual",
            "fechaFija", "fechaFijaExtendida", "horaFija",
            "fechaModificada", "fechaModificadaExtendida", "horaModificada",
            "dtActual", "dtActualExtendida", "dtHoraActual",
            "dtFija", "dtFijaExtendida", "dtHoraFija",
            "dtModificada", "dtModificadaExtendida", "dtHoraModificada"
        ),
        "Ejercicio 7"
    );
}


public function accionEjercicio5()
{
    // Menú izquierda
    $this->menuizq = [
        [   
            "texto" => "Inicio",
             "enlace" => ["practica1"]
        ],
        [
            "texto" => "Ejercicio 1", 
            "enlace" => ["practica1", "ejercicio1"]
        ],
        [   "texto" => "Ejercicio 2",
             "enlace" => ["practica1", "ejercicio2"]
        ],
        [   "texto" => "Ejercicio 3",
             "enlace" => ["practica1", "ejercicio3"]
             ],
        [   "texto" => "Ejercicio 7", 
            "enlace" => ["practica1", "ejercicio7"]
        ],
    ];

    // Barra de ubicación
    $this->barraUbi = [
        ["texto" => "Inicio", "enlace" => Sistema::app()->generaURL(["inicial"])],
        ["texto" => "Practica 1", "enlace" => Sistema::app()->generaURL(["practica1"])],
        ["texto" => "Ejercicio 5", "enlace" => ""]
    ];

    // ARRAY DEL EJERCICIO 5

    $vector = [];
    $vector[1] = "esto es una cadena";
    $vector["posi1"] = 25.67;
    $vector[] = false;
    $vector["ultima"] = [2, 5, 96];
    $vector[56] = 23;

    // ENVÍO A LA VISTA

    $this->dibujaVista(
        "vistaejer5",
        ["vector" => $vector],
        "Ejercicio 5"
    );
}


}