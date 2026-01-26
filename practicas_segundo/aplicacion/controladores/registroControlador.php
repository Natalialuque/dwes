<?php
	 
class registroControlador extends CControlador
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
				"texto" => "practica1", 
				"enlace" => ["practica1"]
			],
			[
				"texto" => "practica2", 
				"enlace" => ["practica2"]
			],
			[
				"texto" => "Productos",
				"enlace"=> ["productos"]
			]

		];

		$this->barraUbi = [
   			 ["texto" => "Inicio", "enlace" => ["inicial"]],
   			 ["texto" => "Resgistro", "enlace" => ""]
		];
	
	
}


public function accionPedirDatosRegistro() { 
	$this->menuizq = [ 
		[
			"texto" => "Inicio", 
			"enlace" => ["inicial"]
		],
		[
			"texto" => "practica1", 
			"enlace" => ["practica1"]
		],
		[
			"texto" => "practica2", 
			"enlace" => ["practica2"]
		],
		[
			"texto" => "Productos", 
			"enlace" => ["productos"]
		],
	
	]; 
	
	$this->barraUbi = [
		[	
			"texto" => "Inicio", 
			"enlace" => ["inicial"]
		], 
		[
			"texto" => "Registro", 
			"enlace" => ""
		] 
	];
	
	$modelo = new DatosRegistro(); 
	
	if (!isset($_POST["datosRegistro"])) { 
		$this->dibujaVista("pedirDatosRegistro", ["modelo" => $modelo], "Formulario de registro");
		 return; 
	} 
	$modelo->setValores($_POST["datosRegistro"]); 
	
	if (!$modelo->validar()) { 
		$this->dibujaVista("pedirDatosRegistro", ["modelo" => $modelo], "Formulario de registro");
		 return; 
	} 
	$this->dibujaVista("descargarRegistro", ["modelo" => $modelo], "Descarga de datos"); 
}


public function accionLogin()
{
    $this->menuizq = [
        ["texto" => "Inicio", "enlace" => ["inicial"]],
        ["texto" => "practica1", "enlace" => ["practica1"]],
        ["texto" => "practica2", "enlace" => ["practica2"]],
        ["texto" => "Productos", "enlace" => ["productos"]],
    ];

    $this->barraUbi = [
        ["texto" => "Inicio", "enlace" => ["inicial"]],
        ["texto" => "Login", "enlace" => ""]
    ];

    $modelo = new Login();

    // FORMULARIO NO ENVIADO
    if (!isset($_POST["login"])) {
        $this->dibujaVista("login", ["modelo" => $modelo], "login");
        return;
    }

    // CARGAR DATOS
    $modelo->setValores($_POST["login"]);

    // VALIDAR
    if ($modelo->validar()) {
		 session_start();
        $_SESSION["usuario"] = ["nick" => $modelo->nick];
		$_SESSION["login"] = true;
		Sistema::app()->irAPagina(["inicial"]);
    }

     $this->dibujaVista("login", ["modelo" => $modelo], "Iniciar Sesión");

    
}


public function accionLogout()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // BORRAR EL USUARIO CORRECTO
    unset($_SESSION["usuario"]);

    // REDIRIGIR
    Sistema::app()->irAPagina(["inicial"]);
}



		
}

	

    
	

