<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Recuperar proyectos desde sesión
$PRO = $_SESSION["PRO"] ?? [];

$ubicacion = [
    "Index Principal" => "/index.php",
    "Modificar Proyecto" => "/aplicacion/proyecto/modificar.php"
];

// Validar índice recibido
if (!isset($_GET["id"]) || $_GET["id"] === "") {
    throw new Exception("No se ha proporcionado un índice válido");
}
$indice = $_GET["id"];

if (!isset($PRO[$indice])) {
    throw new Exception("No existe el número dado");
}

$objeto = $PRO[$indice];

$datos = ["nombre"=>"","empresa"=>"","fechainicio"=>"","fechafin"=>"","tipo"=>""];
$errores = [];
$mensaje = ""; // ← Aquí guardaremos el mensaje de éxito

if (isset($_POST["modificar"])) {
    if ($objeto->setNombre($_POST["nombre"]) < 0) $errores["nombre"][] = "Error en el nombre";
    if ($objeto->setEmpresa($_POST["empresa"]) < 0) $errores["empresa"][] = "Error en la empresa";
    if ($objeto->setFechaInicio($_POST["fechaInicio"]) < 0) $errores["fechaInicio"][] = "Error en la fecha de inicio";
    if ($objeto->setFechaFin($_POST["fechaFin"]) < 0) $errores["fechaFin"][] = "Error en la fecha de fin";
    if ($objeto->setTipo($_POST["tipo"]) < 0) $errores["tipo"][] = "Error en el tipo";

    if (empty($errores)) {
        $PRO[$indice] = new Proyecto(
            $_POST["nombre"],
            $_POST["empresa"],
            $_POST["fechaInicio"],
            $_POST["fechaFin"],
            $_POST["tipo"]
        );
        $_SESSION["PRO"] = $PRO;
        $mensaje = "Proyecto modificado correctamente"; // ← Guardamos el mensaje
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

        <label for="">Empresa: </label>
        <input type="text" name="empresa" value="<?= $objeto->getEmpresa() ?>"><br>

        <label for="">Fecha Inicio: </label>
        <input type="text" name="fechaInicio" value="<?= $objeto->getFechaInicio() ?>"><br>

        <label for="">Fecha Fin: </label>
        <input type="text" name="fechaFin" value="<?= $objeto->getFechaFin() ?>"><br>

        <label for="">Tipo: </label>
        <input type="text" name="tipo" value="<?= $objeto->getTipo() ?>"><br>

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
