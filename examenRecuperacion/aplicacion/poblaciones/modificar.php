<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Recuperar poblaciones desde sesión
$POB = $_SESSION["POB"] ?? [];

$ubicacion = [
    "Index Principal" => "/index.php",
    "Modificar poblacion" => "/aplicacion/poblaciones/modificar.php"
];

// Validar índice recibido
if (!isset($_GET["id"]) || $_GET["id"] === "") {
    throw new Exception("No se ha proporcionado un índice válido");
}
$indice = $_GET["id"];

if (!isset($POB[$indice])) {
    throw new Exception("No existe la poblacion indicada");
}

$objeto = $POB[$indice];

$errores = [];
$mensaje = "";

// -----------------------------
// PROCESAR FORMULARIO
// -----------------------------
if (isset($_POST["modificar"])) {

    // VALIDAR NOMBRE
    if ($objeto->setNombre($_POST["nombre"]) < 0)
        $errores["nombre"][] = "Nombre no válido";

    // VALIDAR ORIGGEN
    if ($objeto->setOrigen($_POST["origen"]) < 0 || $objeto->setOrigen($_POST["origen"]) > 2500000 )
        $errores["origen"][] = "Origen no válida";

    
    // SI TODO ES CORRECTO → ACTUALIZAR Y VOLVER A INDEX
    if (empty($errores)) {

        $POB[$indice] = new Poblacion(
            $_POST["nombre"],
            $_POST["origen"],
        );

        $_SESSION["POB"] = $POB;

        header("Location: ../../index.php");
        exit;
    }
}

// -----------------------------
// DIBUJAR PLANTILLA
// -----------------------------
inicioCabecera("Modificar poablacion");
cabecera();
finCabecera();

inicioCuerpo("Modificar poblacion", $ubicacion);
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

        <label>Origen: </label>
        <input type="text" name="origen" value="<?= $objeto->getOrigen() ?>"><br>

        <label>Epocas: </label>
        <select name="epoca">
            <?php foreach (Poblacion::EPOCAS as $desc => $valor): ?>
                <option value="<?= $valor ?>"
                    <?= ($valor == $objeto->getEpoca()) ? "selected" : "" ?>>
                    <?= ucfirst($desc) ?>
                </option>
            <?php endforeach; ?>
        </select><br>


        <input type="submit" value="Modificar" name="modificar">
    </form>

<?php
}

function cabecera() {}

function cuerpo($objeto, $errores) {
    formulario($objeto, $errores);
}
