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
	
	// Crear modelo
    $modelo = new DatosRegistro();

    // Si NO se ha enviado el formulario, mostrar formulario vacío
    if (!isset($_POST["DatosRegistro"])) {
        $this->dibujaVista("pedirDatosRegistro", ["modelo" => $modelo], "Formulario de registro");
        return;
    }

    // Cargar datos del POST
    $modelo->setValores($_POST["DatosRegistro"]);

    // Validar
    if (!$modelo->validar()) {
        // Hay errores ,volver a mostrar formulario
        $this->dibujaVista("pedirDatosRegistro", ["modelo" => $modelo], "Formulario de registro");
        return;
    }

    // Si todo está correcto, mostrar vista de descarga
    $this->dibujaVista("descargarRegistro", ["modelo" => $modelo], "Descarga de datos");
}


public function accionLogin()
{
    // Menú y ubicación (opcional)
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
   			 ["texto" => "Login", "enlace" => ""]
		];
	

    // Crear modelo
    $modelo = new Login();

    // Si no se ha enviado el formulario ,mostrarlo
    if (!isset($_POST["Login"])) {
        $this->dibujaVista("login", ["modelo" => $modelo], "Login");
        return;
    }

    // Cargar datos
    $modelo->setValores($_POST["Login"]);

    // Validar
    if (!$modelo->validar()) {
        // Mostrar errores
        $this->dibujaVista("login", ["modelo" => $modelo], "Login");
        return;
    }

    // Si es correcto, guardar usuario en sesión
    $_SESSION["usuario"] = [
        "nick" => $modelo->nick
    ];


	$this->dibujaVista("login", ["modelo" => $modelo], "Iniciar Sesión");

}

public function accionLogout()
{
   // si la session esta cerrada la abre
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION["login"]=false;
        unset($_SESSION["nick"]);
    // Redirigir a la página inicial
    Sistema::app()->irAPagina(["inicial"]);
}


		
}

	

    
	

