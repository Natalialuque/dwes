<?php

/**Esto seria otro contrlador para el tema de usuarios, cambiando el nombre de la clase ya podriamos acceder */
class practica2Controlador extends CControlador
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
                "texto" => "Mi error",
                "enlace" => ["practica2", "mierror"]
            ],
            [
                "texto" => "Descarga 1",
                "enlace" => ["practica2", "descarga1"]
            ],
            [
                "texto" => "Descarga 2",
                "enlace" => ["practica2", "descarga2"]
            ],
            [
                "texto" => "Ajax",
                "enlace" => ["practica2", "peticionAjax"]
            ],
		];

		$this->barraUbi = [

			["texto"=>"Inicio", "enlace"=>"inicialñ"],
			["texto"=>"Practica 2", "enlace"=>""]

		];

		
		$this->dibujaVista("index",[],"Practica 2");
	}

	//funcion miError
	public function accionMierror()
	{
		Sistema::app()->paginaError(001, "no seas malo y no accedas a esta pagina");

	}
	
	
	public function accionDescarga1()
	{
		$this->dibujaVistaParcial("descarga1", [], false);
	}


	public function accionDescarga2()
	{

		$archivo = "descarga2.txt";
		$texto = "hemos realizado la descarga2";

		// Cabeceras para forzar la descarga
		header("Content-Type: text/plain");
		header("Content-Disposition: attachment; filename=\"{$archivo}\"");
		header("Content-Length: " . strlen($texto));

		// Salida del contenido
		echo $texto;
		exit;
	}

public function accionPedirDatos()
{
    
    // SI ES PETICIÓN AJAX → DEVOLVER JSON
    if (isset($_GET["min"]) && isset($_GET["max"]) && isset($_GET["cadena"])) {

        $min = intval($_GET["min"]);
        $max = intval($_GET["max"]);
        $cadena = trim($_GET["cadena"]);

        // generar números
        $numeros = [];
        for ($i = 1; $i <= 10; $i++) {
            $numeros[] = mt_rand($min, $max);
        }

        // generar palabras
        $palabras = [];
        $longitud = mb_strlen($cadena);
        $primera = mb_substr($cadena, 0, 1);
        $ultima = mb_substr($cadena, -1, 1);
        $patron = "abcdefghijklmnopkrstuvwxyz";

        for ($i = 1; $i <= 10; $i++) {
            $palabra = $primera;
            for ($y = 0; $y < $longitud - 2; $y++) {
                $letra = $patron[mt_rand(0, strlen($patron) - 1)];
                $palabra .= $letra;
            }
            $palabra .= $ultima;
            $palabras[] = $palabra;
        }

        // respuesta JSON
        $respuesta = [
            "numeros" => $numeros,
            "palabras" => $palabras
        ];

        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($respuesta);
        exit;
    }
}

public function accionPeticionAjax()
{
   $this->menuizq = [
        [	
			"texto" => "Inicio", 
			"enlace" => ["inicial"]
		],
        [	"texto" => "Mi error",
		 "enlace" => ["practica2", "mierror"]
		],
        [
			"texto" => "Descarga 1", 
			"enlace" => ["practica2", "descarga1"]
		],
        [
			"texto" => "Descarga 2", 
			"enlace" => ["practica2", "descarga2"]
		],
    ];


    $this->barraUbi = [
        ["texto" => "Inicio", "enlace" => Sistema::app()->generaURL(["inicial"])],
        ["texto" => "Practica 2", "enlace" => Sistema::app()->generaURL(["practica2"])],
        ["texto" => "AJAX", "enlace" => ""]
    ];

    // Mostrar la vista pedirDatos
    $this->dibujaVista("pedirDatos", [], "AJAX");
}




}