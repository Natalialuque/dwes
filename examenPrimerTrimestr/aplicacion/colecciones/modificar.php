<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Recuperar proyectos desde sesión
$COL = $_SESSION["COL"] ?? [];

$ubicacion = [
    "Index Principal" => "/index.php",
    "Modificar Coleecion" => "/aplicacion/colecciones/modificar.php"
];

// Validar índice recibido
if (!isset($_GET["id"]) || $_GET["id"] === "") {
    throw new Exception("No se ha proporcionado un índice válido");
}
$indice = $_GET["id"];

if (!isset($COL[$indice])) {
    throw new Exception("No existe el número dado");
}

$objeto = $COL[$indice];

$datos = ["nombre"=>"","fechaAlta"=>"","tematica"=>"","tematicaDescripcion"=>""];
$errores = [];
$mensaje = ""; // Aquí guardaremos el mensaje de éxito

if (isset($_POST["modificar"])) {
    if ($objeto->setNombre($_POST["nombre"]) < 0) $errores["nombre"][] = "Error en el nombre";
    if ($objeto->setFecha($_POST["fechaAlta"]) < 0) $errores["fechaAlta"][] = "Error en la empresa";
    if ($objeto->setFechaInicio($_POST["tematica"]) < 0) $errores["tematica"][] = "Error en la fecha de inicio";
    if ($objeto->setFechaInicio($_POST["tematicaDescripcion"]) < 0) $errores["tematicaDescripcion"][] = "Error en la fecha de inicio";

    if (empty($errores)) {
        $PRO[$indice] = new Coleccion(
            $_POST["nombre"],
            $_POST["fechaAlta"],
            $_POST["tematica"],
            $_POST["fetematicaDescripcion"],
        );
        $_SESSION["COL"] = $COL;
        $mensaje = "coleecion modificado correctamente"; // ← Guardamos el mensaje
    }
}

// Dibuja la plantilla de la vista
inicioCabecera("Repaso primer trimestre");
cabecera();
finCabecera();

inicioCuerpo("Repaso primer trimestre", $ubicacion);
cuerpo($objeto, $errores, $mensaje);
finCuerpo();


// **********************************************************

function formulario($objeto, $errores, $mensaje) {
    if ($errores) {
        echo "<div class='error'>";
        foreach ($errores as $clave => $valor) {
            foreach ($valor as $error) {
                echo "$clave => $error<br>" . PHP_EOL;
            }
        }
        echo "</div>";
    }
    ?>
    <form action="" method="post">
        <label for="">Nombre: </label>
        <input type="text" name="nombre" value="<?= $objeto->getNombre() ?>"><br>

        <label for="">fecha : </label>
        <input type="text" name="fecha" value="<?= $objeto->getFecha() ?>"><br>

     
        <label for="">Tematica: </label>
        <input type="text" name="fechaFin" value="<?= $objeto->getTematica() ?>"><br>

        <label for="">Tematica DEscripcion: </label>
        <input type="text" name="tipo" value="<?= $objeto->getTematicaDescripcion() ?>"><br>

        <input type="submit" value="Modificar" name="modificar">
    </form>

    <?php if ($mensaje !== ""): ?>
        <br><br>
        <div style="color:green"><strong><?= $mensaje ?></strong></div>
        <a href="../../index.php">Volver al inicio</a>
    <?php endif;
}

function cabecera() {}

function cuerpo($objeto, $errores, $mensaje)
{
    formulario($objeto, $errores, $mensaje);
}
