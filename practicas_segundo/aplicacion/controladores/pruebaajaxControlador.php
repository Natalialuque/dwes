<?php
	 
class pruebaajaxControlador extends CControlador
{
	public array $menuizq=[];
	public array $barraUbi=[];

	public function accionIndex()
	{
		

		$this->dibujaVista("index",[],"prueba ajax");

		
	}

	

	
	public function accionDatosajax(){
		echo"nueva pagina";
	}

	
}
