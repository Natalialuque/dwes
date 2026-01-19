<?php
	 
class ejemmodelosControlador extends CControlador
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
				"texto" => "usuario", 
				"enlace" => ["usuario"]
			]

		];

		$this->barraUbi = [
			["texto"=>"Inicio", "enlace"=>""]
		];

		$art = new articulos();

		$nombre=$art->getNombre();
 			if (isset($_POST[$nombre]))
 		{
 				//asigno un codigo de articulo por defecto
 				$art->cod_articulo=5;
				//asigno los valores al articulo a partir de lo recogidodel formulario
				$art->setValores($_POST[$nombre]);

				//compruebo si son validos los datos del articulo
				if ($art->validar())
 				{ 
					//son validos los datos del articulo
					echo "todo correcto";
					return;

				}
			}

		$art->nombre ="hp i5";

		//echo $art ->nombre;

		$this-> dibujaVista("nuevo",["modelo"=>$art]);

	}

	
	
}
