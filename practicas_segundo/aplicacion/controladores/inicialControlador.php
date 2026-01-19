<?php
	 
class inicialControlador extends CControlador
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
				"texto" => "usuario", 
				"enlace" => ["usuario"]
			],
			[
				"texto" => "modelos", 
				"enlace" => ["ejemmodelos"]
			],

		];

		$this->barraUbi = [
			["texto"=>"Inicio", "enlace"=>""]
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
