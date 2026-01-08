<?php
	 
class inicialControlador extends CControlador
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

		$direccion = Sistema::app()->generaURL(["usuarios","borrado"],["id"=>12,"nombre"=>"Natalia"]);

		$cadena ="Mi nombre";
		$entero = 12;

		 $this->dibujaVista("index",["c"=>$cadena,"n"=>$entero],
		 					"Pagina principal");

		//dibuja sin la plantilla
		// $contenido=$this->dibujaVistaParcial("index",["c"=>$cadena,"n"=>$entero]);
		// echo $contenido;
	}

	/**Podemos tener tantas paginas como queramos creando diferentes funciones con el accion */
	public function accionNuevo(){
		echo"nueva pagina";
	}

	
}
