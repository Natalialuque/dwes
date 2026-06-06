<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $titulo; ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/estilos/principal.css" />

	<link rel="icon" type="image/png" href="/imagenes/favicon.png" />
	<?php
	if (isset($this->textoHead))
		echo $this->textoHead;
	?>
</head>

<body>
	<div id="todo">
		<header>
			<div class="logo">
				<a href="/index.php"><img src="/imagenes/logo.png" width="50px" height="50px" /></a>
			</div>
			<div class="titulo">
				<a href="/index.php">
					<h1>PROYECTO FRAMEWORK PEDROSA</h1>
				</a>
			</div>
			<div class="sesion">
				<?php

				if (session_status() === PHP_SESSION_NONE) {
					session_start();
				}
				if (isset($_SESSION["usuario"])) {
					echo CHTML::dibujaEtiqueta(
						"div",
						[
							"style" =>
							"background-color:green;
                     		color:white;
							padding:10px;
							font-weight:bold;
							text-align:center;
							margin-top:10px;"
						],
							"Pueblos: " . $this->N_Pueblos .
							" | Reconocidos Unesco: " . $this->N_PueblosUnesco . 
							" | Bienvenido, " . $_SESSION["usuario"]["nombre"] . " | " .
							 CHTML::link("Iniciar sesión", ["Pueblos", "conectar"]).
							 CHTML::link("Cerrar sesión", ["Pueblos", "desconectar"])
					);
				} else {
					echo CHTML::dibujaEtiqueta(
						"div",
						[
							"style" =>
							"background-color:green;
                     		color:white;
							padding:10px;
							font-weight:bold;
							text-align:center;
							margin-top:10px;"
						],
							"Pueblos: " . $this->N_Pueblos .
							" | Reconocidos Unesco: " . $this->N_PueblosUnesco . 
							" | Sin usuario | "  .
							 CHTML::link("Iniciar sesión", ["Pueblos", "conectar"]).
							 CHTML::link("Cerrar sesión", ["Pueblos", "desconectar"])
					);
				}

				?>
			</div>
		</header>
		<?php

		if (isset($this->barraUbi)) {
			echo CHTML::dibujaEtiqueta("nav", ["class" => "barraModdle"], null, false);
			$total = count($this->barraUbi);
			$i = 0;

			foreach ($this->barraUbi as $valor) {
				$i++;

				if ($i < $total) {
					echo CHTML::link($valor["texto"], $valor["enlace"], []);
					echo CHTML::dibujaEtiqueta("label", [], "&raquo;", true);
				} else echo CHTML::dibujaEtiqueta("label", [], $valor["texto"], true);
			}
			echo CHTML::dibujaEtiquetaCierre("nav");
		}
		?>

		<div class="contenido">
			<aside>
				<ul>
					<?php
					if (isset($this->menuizq)) {
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
		<footer>
			<h2><span>Copyright:</span> <?php echo Sistema::app()->autor ?>
			</h2>
		</footer><!-- #footer -->

	</div><!-- #wrapper -->
</body>

</html>