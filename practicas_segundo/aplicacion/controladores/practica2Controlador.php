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
			]
		];

		$this->barraUbi = [

			["texto"=>"Inicio", "enlace"=>"inicial"],
			["texto"=>"Practica 2", "enlace"=>""]

		];

		
		$this->dibujaVista("index",[],"Practica 2");
	}

	


	
}