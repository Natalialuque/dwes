<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Recuperar colecciones desde sesión
$COL = $_SESSION["COL"] ?? [];

$ubicacion = [
    "Index Principal" => "/index.php",
    "Modificar Colección" => "/aplicacion/colecciones/modificar.php"
];

// Validar índice recibido
if (!isset($_GET["id"]) || $_GET["id"] === "") {
    throw new Exception("No se ha proporcionado un índice válido");
}
$indice = $_GET["id"];

if (!isset($COL[$indice])) {
    throw new Exception("No existe la colección indicada");
}

$objeto = $COL[$indice];

$errores = [];
$mensaje = "";

// -----------------------------
// PROCESAR FORMULARIO
// -----------------------------
if (isset($_POST["modificar"])) {

    // VALIDAR NOMBRE
    if ($objeto->setNombre($_POST["nombre"]) < 0)
        $errores["nombre"][] = "Nombre no válido";

    // VALIDAR FECHA
    if ($objeto->setFechaAlta($_POST["fechaAlta"]) < 0)
        $errores["fechaAlta"][] = "Fecha no válida";

    // VALIDAR TEMÁTICA
    if ($objeto->setTematica($_POST["tematica"]) < 0)
        $errores["tematica"][] = "Temática no válida";

    // SI TODO ES CORRECTO → ACTUALIZAR Y VOLVER A INDEX
    if (empty($errores)) {

        $COL[$indice] = new Coleccion(
            $_POST["nombre"],
            $_POST["fechaAlta"],
            $_POST["tematica"]
        );

        $_SESSION["COL"] = $COL;

        header("Location: ../../index.php");
        exit;
    }
}

// -----------------------------
// DIBUJAR PLANTILLA
// -----------------------------
inicioCabecera("Modificar Colección");
cabecera();
finCabecera();

inicioCuerpo("Modificar Colección", $ubicacion);
cuerpo($objeto, $errores);
finCuerpo();


// **********************************************************

function formulario($objeto, $errores) {

    if ($errores) {
        echo "<div class='error'>";
        foreach ($errores as $campo => $lista) {
            foreach ($lista as $error) {
                echo "$campo → $error<br>";
            }
        }
        echo "</div>";
    }
    ?>

    <form action="" method="post">

        <label>Nombre: </label>
        <input type="text" name="nombre" value="<?= $objeto->getNombre() ?>"><br>

        <label>Fecha Alta: </label>
        <input type="text" name="fechaAlta" value="<?= $objeto->getFechaAlta() ?>"><br>

        <label>Temática: </label>
        <select name="tematica">
            <?php foreach (Coleccion::TEMATICAS as $desc => $valor): ?>
                <option value="<?= $valor ?>"
                    <?= ($valor == $objeto->getTematica()) ? "selected" : "" ?>>
                    <?= ucfirst($desc) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Descripción temática: </label>
        <input type="text" disabled value="<?= $objeto->getTematicaDescripcion() ?>"><br>

        <input type="submit" value="Modificar" name="modificar">
    </form>

<?php
}

function cabecera() {}

function cuerpo($objeto, $errores) {
    formulario($objeto, $errores);
}
