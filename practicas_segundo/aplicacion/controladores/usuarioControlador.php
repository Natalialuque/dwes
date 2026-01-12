<?php

/**Esto seria otro contrlador para el tema de usuarios, cambiando el nombre de la clase ya podriamos acceder */
class usuarioControlador extends CControlador
{
	public array $menuizq=[];
	public function accionIndex()
	{
		

		$this->menuizq = [
			[
				"texto" => "Inicio", 
				"enlace" => ["inicial"]
			]
		];

		

		// $this->dibujaVista("index",[],
		// 					"Pagina principal");

		// echo"listado de todos los usuarios existentes";

		$this->dibujaVista("prueba",[]);
	}

	/**Podemos tener tantas paginas como queramos creando diferentes funciones con el accion */
	// public function accionNuevo(){
	// 	echo"nueva usuario";
	// }

	// public function accionModificar(){
	// 	echo"Modificar usuaio";
	// }

	// public function accionBorrar(){
	// 	$this->dibujaVista("prueba",[],
	// 						"borrar vista");

	// }


	
}
