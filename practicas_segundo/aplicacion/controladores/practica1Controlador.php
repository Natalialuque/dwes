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
			]
		];
		$this->barraUbi = [
			["texto"=>"Inicio", "enlace"=>"inicial"],
			 ["texto"=>"Practica 1", "enlace"=>""]
		];

		

		$this->dibujaVista("miindice",[],"Practica 1");
	}

	


	
}