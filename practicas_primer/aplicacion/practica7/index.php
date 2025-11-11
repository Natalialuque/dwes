<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once("/web/sitios/dwes/practicas_primer/scripts/clases/Punto.php");
include_once("/web/sitios/dwes/practicas_primer/scripts/librerias/validacion.php");

//controlador
$datos = [
    "x" => "",
    "y" => "",
    "color" => "",
    "grosor" => ""
];
$errores = [];

if (isset($_POST["guardar"])) {
    // X
    $x = $_POST["x"] ?? "";
    if (!validaEntero($x, 0, 500, "X_INVALIDA")) {
        $errores["x"][] = "La coordenada X debe estar entre 0 y 500.";
    }
    $datos["x"] = $x;

    // Y
    $y = $_POST["y"] ?? "";
    if (!validaEntero($y, 0, 500, "Y_INVALIDA")) {
        $errores["y"][] = "La coordenada Y debe estar entre 0 y 500.";
    }
    $datos["y"] = $y;

    // Color
    $color = $_POST["color"] ?? "";
    if (!array_key_exists($color, Punto::COLORES)) {
        $errores["color"][] = "Selecciona un color válido.";
    }
    $datos["color"] = $color;

    // Grosor
    $grosor = $_POST["grosor"] ?? "";
    if (!array_key_exists((int)$grosor, Punto::GROSORES)) {
        $errores["grosor"][] = "Selecciona un grosor válido.";
    }
    $datos["grosor"] = $grosor;

    // Si no hay errores, podrías instanciar el objeto Punto
    if (empty($errores)) {
        try {
            $punto = new Punto((int)$x, (int)$y, $color, (int)$grosor);
        } catch (Exception $e) {
            echo "<p>Error al crear el punto: " . $e->getMessage() . "</p>";
        }
    }
}

///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo();  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
 function cuerpo($datos, $errores)
{
    echo "<br><br><br>";

        formulario($datos, $errores);
    
}
function formulario($datos, $errores) {

      if ($errores) { //mostrar los errores
            echo "<div class='error'>";
            foreach ($errores as $clave => $valor) {
                foreach ($valor as $error)
                    echo "$clave => $error<br>" . PHP_EOL;
            }
            echo "</div>";
    }

    ?>
    <form method="post" action="">
        <label for="x">Coordenada X:</label>
        <input type="number" name="x" id="x" value="<?php echo $datos["x"]; ?>" min="0" max="500">
        <?php if (isset($errores["x"])) echo "<span style='color:red;'> " . implode(", ", $errores["x"]) . "</span>"; ?>
        <br>

        <label for="y">Coordenada Y:</label>
        <input type="number" name="y" id="y" value="<?php echo $datos["y"]; ?>" min="0" max="500">
        <?php if (isset($errores["y"])) echo "<span style='color:red;'> " . implode(", ", $errores["y"]) . "</span>"; ?>
        <br>

        <label for="color">Color:</label>
        <select name="color" id="color">
            <option value="">--Selecciona--</option>
            <?php foreach (Punto::COLORES as $clave => $info): ?>
                <option value="<?php echo $clave; ?>" <?php if ($datos["color"] == $clave) echo "selected"; ?>>
                    <?php echo $info["nombre"]; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errores["color"])) echo "<span style='color:red;'> " . implode(", ", $errores["color"]) . "</span>"; ?>
        <br>

        <label>Grosor:</label><br>
        <?php foreach (Punto::GROSORES as $clave => $nombre): ?>
            <input type="radio" name="grosor" value="<?php echo $clave; ?>" id="grosor<?php echo $clave; ?>"
                <?php if ($datos["grosor"] == $clave) echo "checked"; ?>>
            <label for="grosor<?php echo $clave; ?>"><?php echo $nombre; ?></label><br>
        <?php endforeach; ?>
        <?php if (isset($errores["grosor"])) echo "<span style='color:red;'> " . implode(", ", $errores["grosor"]) . "</span>"; ?>
        <br>

        <input type="submit" name="guardar" value="Guardar">
    </form>
    <?php
}