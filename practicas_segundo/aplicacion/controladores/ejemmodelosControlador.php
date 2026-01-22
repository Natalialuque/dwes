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
			],
			[
				"texto"=>"nuevo",
				"enlace"=>["nuevo"]
			],
			[
				"texto"=>"tablas",
				"enlace"=>["tablas"]
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

	 public function accionTablas()
	{
		$filas = [
			[
				"nombre" => "Alex",
				"edad" => 20,
				"direccion" => "casa"
			],
			[
				"nombre" => "Vicente",
				"edad" => 25,
				"direccion" => "Su casa en Archidona"
			],
			[
				"nombre" => "Rigu",
				"edad" => 19,
				"direccion" => "Rigulan"
			],
			[
				"nombre" => "Alex2",
				"edad" => 20,
				"direccion" => "casa"
			],
			[
				"nombre" => "Vicente2",
				"edad" => 25,
				"direccion" => "Su casa en Archidona"
			],
			[
				"nombre" => "Rigu2",
				"edad" => 19,
				"direccion" => "Rigulan"
			],
			[
				"nombre" => "Alex3",
				"edad" => 20,
				"direccion" => "casa"
			],
			[
				"nombre" => "Vicente3",
				"edad" => 25,
				"direccion" => "Su casa en Archidona"
			],
			[
				"nombre" => "Rigu3",
				"edad" => 19,
				"direccion" => "Rigulan"
			],
			[
				"nombre" => "Chule",
				"edad" => 20,
				"direccion" => "casa"
			],
			[
				"nombre" => "Imartacho",
				"edad" => 25,
				"direccion" => "Su casa en Archidona"
			],
			[
				"nombre" => "Martillon",
				"edad" => 19,
				"direccion" => "Rigulan"
			],
		];
		$cabecera = [
			[
				"ETIQUETA" => "el nombre",
				"CAMPO" => "nombre"
			],
			[
				"ETIQUETA" => "la edad",
				"CAMPO" => "edad"
			],
			[
				"ETIQUETA" => "la direccion",
				"CAMPO" => "direccion"
			],
		];

	$totalRegistros=count($filas);
	//Registro que muestra paginas de 5 en 5
	$regPag=5;
	if(isset($_GET["reg_pag"]))
		$regPag=intval($_GET["reg_pag"]);

	//Numero de paginas q tenemos
	$nPaginas=$totalRegistros/$regPag;

	//pagina en la q estamos
	$pag = 1;
	if(isset($_GET["pag"]))
		$pag=intval($_GET["pag"]);

	$salida = [];

	for ($cont=($pag-1)*$regPag; $cont < $pag*$regPag && $cont<$totalRegistros; $cont++) { 
			$salida[$cont]=$filas[$cont];
	}

		//Paginador para controlar las tablas q se muestran
		$opcPaginador = array(
			"URL" => Sistema::app()->generaURL(array("ejemmodelos", "tablas")),
			"TOTAL_REGISTROS" => $totalRegistros,
			"PAGINA_ACTUAL" => $pag,
			"REGISTROS_PAGINA" => $regPag,
			"TAMANIOS_PAGINA" => array(
				5 => "5",
				10 => "10",
				20 => "20",
				30 => "30",
				40 => "40",
				50 => "50"
			),
			"MOSTRAR_TAMANIOS" => true,
			"PAGINAS_MOSTRADAS" => $nPaginas,
		);

		$this->dibujaVista("tablas", ["cab" => $cabecera, "fil" => $salida,"cabpag"=>$opcPaginador], "Muestra tablas de ejemplo");
	}
	
	// //PARTE DE BASE DE DATOS 
	// public function accionBd(){
	// 	$sentencia ="select * from cons_equipos";

	// 	$consulta = Sistema::app()->BD()->crearConsulta($sentencia);

	// 	while ($fila=$consulta->fila()){
	// 		$filas[]=$fila;
	// 	}
	// }
	
}
