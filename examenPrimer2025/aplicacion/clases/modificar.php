<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Recuperar colecciones desde sesión
$COL = $_SESSION["COL"] ?? [];

// Validar índice recibido
if (!isset($_GET["id"]) || $_GET["id"] === "") {
    throw new Exception("No se ha proporcionado un índice válido");
}

$indice = $_GET["id"];

// Verificar que la colección existe
if (!isset($COL[$indice])) {
    throw new Exception("No existe la colección indicada");
}

// Objeto colección a modificar
$objeto = $COL[$indice];

$errores = [];

/**
 * CONTROL DEL BOTÓN MODIFICAR
 */
if (isset($_POST["modificar"])) {

    // VALIDAR NOMBRE (NO modificar aún el objeto)
    if ($objeto->setNombre($_POST["nombre"]) < 0) {
        $errores["nombre"][] = "Nombre no válido";
    }

    // VALIDAR FECHA
    if ($objeto->setFechaAlta($_POST["fechaAlta"]) < 0) {
        $errores["fechaAlta"][] = "Fecha no válida";
    }

    // VALIDAR TEMÁTICA (OJO: método correcto es setTematicas)
    if ($objeto->setTematicas($_POST["tematica"]) < 0) {
        $errores["tematica"][] = "Temática no válida";
    }

    // SI NO HAY ERRORES → MODIFICAR DEFINITIVAMENTE
    if (empty($errores)) {

        // Aplicar cambios al objeto real
        $objeto->setNombre($_POST["nombre"]);
        $objeto->setFechaAlta($_POST["fechaAlta"]);
        $objeto->setTematicas($_POST["tematica"]);

        // Guardar en sesión
        $COL[$indice] = $objeto;
        $_SESSION["COL"] = $COL;

        // Volver a index
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

inicioCuerpo("Modificar Colección");
cuerpo($objeto, $errores);
finCuerpo();


// **********************************************************

function formulario($objeto, $errores) {

    // Mostrar errores si existen
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

        <!-- Nombre -->
        <label>Nombre: </label>
        <input type="text" name="nombre" value="<?= $objeto->getNombre() ?>"><br>

        <!-- Fecha -->
        <label>Fecha Alta: </label>
        <input type="text" name="fechaAlta" value="<?= $objeto->getFechaAlta() ?>"><br>

        <!-- Temática -->
        <label>Temática: </label>
        <select name="tematica">
            <?php foreach (Coleccion::TEMATICAS as $desc => $valor): ?>
                <option value="<?= $valor ?>"
                    <?= ($valor == $objeto->getTematica()) ? "selected" : "" ?>>
                    <?= ucfirst($desc) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <!-- Descripción temática -->
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
