<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $titulo; ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/estilos/principal.css" />

	<link rel="icon" type="image/png" href="/imagenes/php_pequeña.png" />
	<?php
	if (isset($this->textoHead))
		echo $this->textoHead;
	?>
</head>

<body>
	<div id="todo">
		<header>
			<div class="logo">
				<a href="/index.php"><img src="/imagenes/php.png" width="50px" height="50px" /></a>
			</div>
			<div class="titulo">
				<a href="/index.php">
					<h1>EXAMEN 2 EVA</h1>
				</a>
			</div>
		</header>

		<div id="barraLogin">
			<?php
			if (Sistema::app()->Acceso()->hayUsuario()) {
				echo CHTML::campoLabel(Sistema::app()->Acceso()->getNick(), "login");
			?>
				<div id="botones">
					<?php
					echo CHTML::dibujaEtiqueta("button", ["id" => "bCerrarSesion"], CHTML::link("Cerrar sesión", Sistema::app()->generaURL(["trayectos", "desconectar"])));
					?>
				</div>

			<?php
			} else {
				echo CHTML::dibujaEtiqueta("label", ["id" => "labelRegistro"], "Usuario no conectado");
			?>
				<div id="botones">
					<?php
					echo CHTML::dibujaEtiqueta("button", ["id" => "bLogin"], CHTML::link("Iniciar sesión", Sistema::app()->generaURL(["trayectos", "conectar"])));
					?>
				</div>
			<?php
			}
			?>


		</div>


		<div class="contenido">
			<div id="barraLogica">
				<?php
				if (isset($this->barraLogica)) {
					foreach ($this->barraLogica as $index => $elemento) {
						if (isset($elemento["posicion"])) //Si existe inicio(1ªvuelta)/Practica (2ºVuelta)/Ejercicio(3º vuelta) 
						{
							if (isset($elemento["direccion"])) {
								if (is_array($elemento["direccion"])) {
									// Si es un array, generar la URL compuesta
									$href = Sistema::app()->generaURL($elemento["direccion"]);
								} else {
									// Si es un string, usarlo directamente como href
									$href = $elemento["direccion"];
								}
							}

							// Generar el enlace
							echo CHTML::dibujaEtiqueta("a", ["href" => $href], $elemento["posicion"], false);
							echo CHTML::dibujaEtiquetaCierre("a");
						}
					}
				}
				?>
			</div>
			<div class="barraMenu">
				<?php
				echo CHTML::dibujaEtiqueta("ul", [], "", false);
				echo CHTML::dibujaEtiqueta("li", [], "", false);
				echo CHTML::link("Trayectos", Sistema::app()->generaURL(["trayectos", "origen"]));
				echo CHTML::dibujaEtiquetaCierre("li");


				?>
			</div>

			<aside <?php if (!(isset($this->menuizq) && $this->menuizq != "")) echo 'style="display: none;"'; ?>>
				<ul>
					<?php
					if (isset($this->menuizq) && $this->menuizq != "") { //Es el que hace que aparezca el cuadro morado del lateral izquierdo que es como una barra lógica
						foreach ($this->menuizq as $opcion) {
							echo CHTML::dibujaEtiqueta(
								"li",
								array(),
								"",
								false
							);
							echo CHTML::link(
								$opcion["texto"],
								$opcion["enlace"]
							);
							echo CHTML::dibujaEtiquetaCierre("li");
							echo CHTML::dibujaEtiqueta("br") . "\r\n";
						}
					}

					?>
				</ul>
			</aside>

			<article>
				<?php echo $contenido; ?>
			</article><!-- #content -->

		</div>
		<div id="barrafinal">
			<?php
			echo CHTML::dibujaEtiqueta("p", [], "Paradas: ".Sistema::app()->N_Paradas
			.", Paradas origen: ".$this->N_ParadasOrigen);
			?>
		</div>
		<footer>
			<h2><span>Copyright:</span> <?php echo Sistema::app()->autor ?> </h2>
			<h2><?php echo Sistema::app()->grupo ?> (<?php echo Sistema::app()->curso ?>)</h2>
		</footer><!-- #footer -->

	</div><!-- #wrapper -->
</body>

</html>