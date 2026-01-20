<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Recuperar colecciones desde sesión
$COL = $_SESSION["COL"] ?? [];

$ubicacion = [
    "Index Principal" => "/index.php",
    "Añadir Libro" => "/aplicacion/colecciones/nuevo.php"
];

// Validar índice recibido
if (!isset($_GET["id"]) || $_GET["id"] === "") {
    throw new Exception("No se ha proporcionado un índice válido");
}
$indice = $_GET["id"];

if (!isset($COL[$indice])) {
    throw new Exception("No existe la colección indicada");
}

$coleccion = $COL[$indice];

$errores = [];
$mensaje = "";

// -----------------------------
// PROCESAR FORMULARIO
// -----------------------------
if (isset($_POST["anadir"])) {

    $nombreLibro = trim($_POST["nombreLibro"]);
    $autorLibro = trim($_POST["autorLibro"]);

    // VALIDACIONES
    if ($nombreLibro === "" || strlen($nombreLibro) > 10)
        $errores["nombreLibro"][] = "El nombre es obligatorio y debe tener ≤ 10 caracteres";

    if ($autorLibro === "" || strlen($autorLibro) > 10)
        $errores["autorLibro"][] = "El autor es obligatorio y debe tener ≤ 10 caracteres";

    // SI TODO ES CORRECTO → CREAR LIBRO Y AÑADIRLO
    if (empty($errores)) {

        $libro = new Libro($nombreLibro, $autorLibro);

        $coleccion->aniadirLibro($libro);

        // Guardar cambios en sesión
        $COL[$indice] = $coleccion;
        $_SESSION["COL"] = $COL;

        header("Location: ../../index.php");
        exit;
    }
}

// -----------------------------
// DIBUJAR PLANTILLA
// -----------------------------
inicioCabecera("Añadir Libro");
cabecera();
finCabecera();

inicioCuerpo("Añadir Libro", $ubicacion);
cuerpo($coleccion, $errores);
finCuerpo();


// **********************************************************

function formulario($coleccion, $errores) {

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

        <label>Colección seleccionada:</label>
        <input type="text" disabled value="<?= $coleccion->getNombre() ?>"><br><br>

        <label>Nombre del libro:</label>
        <input type="text" name="nombreLibro"
               value="<?= $_POST['nombreLibro'] ?? '' ?>"><br>

        <label>Autor del libro:</label>
        <input type="text" name="autorLibro"
               value="<?= $_POST['autorLibro'] ?? '' ?>"><br>

        <input type="submit" value="Añadir" name="anadir">
    </form>

<?php
}

function cabecera() {}

function cuerpo($coleccion, $errores) {
    formulario($coleccion, $errores);
}
