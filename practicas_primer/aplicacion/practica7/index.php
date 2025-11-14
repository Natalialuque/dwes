<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once("/web/sitios/dwes/practicas_primer/scripts/librerias/validacion.php");

//controlador
$datos = [
    "x" => "",
    "y" => "",
    "color" => "",
    "grosor" => ""
];
$errores = [];
//para almacenar los puntos
// Array inicial con 3 puntos
// $punto1 = new Punto(55, 88, "red", 1);
// $punto2 = new Punto(100, 180, "purple", 2);
// $punto3 = new Punto(450, 200, "orange", 3);

$puntos = [];




/**
 * 
 * 
 * EJERCICIO 1
 * 
 * 
 */
if (isset($_POST["guardar"])) {
    // Coordenada X
    $x = "";

    if (isset($_POST["x"])) {
        $x = trim($_POST["x"]);
    }
        $xInt = (int)$x;

        if (!validaEntero($xInt, 0, 500, 0)) {
            $errores["x"][] = "La coordenada X debe estar entre 0 y 500.";
        } elseif ($x === "") {
            $errores["x"][] = "La coordenada X no puede estar vacía.";
        }
    
    $datos["x"] = $x;

    // Coordenada Y
    $y = "";

    if (isset($_POST["y"])) {
        $y = trim($_POST["y"]);
    }
        $yInt = (int)$y;

        if (!validaEntero($yInt, 0, 500, 0)) {
            $errores["y"][] = "La coordenada Y debe estar entre 0 y 500.";
        } elseif ($y === "") {
            $errores["y"][] = "La coordenada Y no puede estar vacía.";
        }
    
    $datos["y"] = $y;

    // Color
    $color = "";

    if (isset($_POST["color"])) {
        $color = $_POST["color"];
    }
        if (!array_key_exists($color, Punto::COLORES)) {
            $errores["color"][] = "Selecciona un color válido.";
        }
    
    $datos["color"] = $color;

    // Grosor
    $grosor = "";

    if (isset($_POST["grosor"])) {
        $grosor = $_POST["grosor"];
    }
        $grosorInt = (int)$grosor;

        if (!array_key_exists($grosorInt, Punto::GROSORES)) {
            $errores["grosor"][] = "Selecciona un grosor válido.";
        }
    
    $datos["grosor"] = $grosor;


    // Si no hay errores, podrías instanciar el objeto Punto
  if (empty($errores)) {
    try {
        $punto = new Punto((int)$x, (int)$y, $color, (int)$grosor);
        $puntos[] = $punto; // Aquí guardas el objeto en el array
    } catch (Exception $e) {
        echo "<p>Error al crear el punto: " . $e->getMessage() . "</p>";
    }
}

}
//imagenes 
$rutaweb = "/imagenes/puntos/";
$rutaphp = RUTABASE . $rutaweb;
$imagenCliente = crearImagenCliente($rutaphp, $puntos);


///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($rutaweb, $imagenCliente, $puntos, $datos, $errores);
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() {}

//vista
function cuerpo($rutaweb, $nombreArchivo,$puntos,$datos, $errores)
{
    echo "<br><br><br>";

    formulario($datos, $errores);
    MuestraPuntos($puntos);
    mostrarImagenCliente($rutaweb, $nombreArchivo);
    
}
function formulario($datos, $errores)
{

    //ejercicio1
?>
    <form method="post" action="">
        <label for="x">Coordenada X:</label>
        <input type="number" name="x" id="x" value="<?php echo $datos["x"]; ?>">
        <?php if (isset($errores["x"])) echo "<span style='color:red;'> " . implode(", ", $errores["x"]) . "</span>"; ?>
        <br>

        <label for="y">Coordenada Y:</label>
        <input type="number" name="y" id="y" value="<?php echo $datos["y"]; ?>">
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


/**
 * 
 * 
 * EJERCICIO 2
 * 
 * 
 */

function MuestraPuntos($puntos){

   ?>

        <h3>ALMACEN DE PUNTOS</h3>
         <!-- Creamos el textArea donde vamos a meter los puntos -->
         <textarea style="margin-left:20px ;width:80%; height:250px; text-align:left;font-size:0.8em"><?php
             $contador = 1;
                foreach ($puntos as $valor) {
               $grosorTexto = Punto::GROSORES[$valor->getGrosor()];
                  echo "Punto{ $contador}: valor X = " . $valor->getX() . ", valor Y = " . $valor->getY() . ", Color = " . $valor->getColor() .
                    ", Grosor = " . $grosorTexto . "\n";
                $contador++;
            }
            ?>
            
    </textarea>
   
   <?php

}

//Para crear la imagen en gd y las IP de los navegadores 
function crearImagenCliente(string $rutaBase, array $puntos): string {
    $ip = str_replace(".", "_", $_SERVER['REMOTE_ADDR']);
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $navegador = "desconocido";
    if (strpos($userAgent, "chrome") !== false) $navegador = "chrome";
    elseif (strpos($userAgent, "firefox") !== false) $navegador = "firefox";
    elseif (strpos($userAgent, "safari") !== false && strpos($userAgent, "chrome") === false) $navegador = "safari";
    elseif (strpos($userAgent, "edge") !== false) $navegador = "edge";
    elseif (strpos($userAgent, "msie") !== false || strpos($userAgent, "trident") !== false) $navegador = "ie";

    $nombreArchivo = "imagen_{$ip}_{$navegador}.jpg";
    $rutaImagen = $rutaBase . $nombreArchivo;


    // Crear carpeta si no existe
    if (!is_dir($rutaBase)) {
        mkdir($rutaBase, 0777, true);
    }

    // Crear imagen
    $gd = imagecreatetruecolor(500, 500); // tamaño más grande para tus coordenadas
    $fondo = imagecolorallocate($gd, 255, 255, 255);
    imagefilledrectangle($gd, 0, 0, 500, 500, $fondo);

    $borde = imagecolorallocate($gd, 0, 0, 0);
    imagerectangle($gd, 0, 0, 499, 499, $borde);

    // Dibujar puntos
    dibujarPuntos($gd, $puntos);

    // Guardar y liberar
    imagejpeg($gd, $rutaImagen);
    imagedestroy($gd);

    return $nombreArchivo;
}

function mostrarImagenCliente(string $rutaweb, string $nombreArchivo) {
    echo '<img src="' . $rutaweb . $nombreArchivo . '" alt="Imagen personalizada">';
}


   function dibujarPuntos($gd, array $puntos) {
    foreach ($puntos as $punto) {
        $colorInfo = Punto::COLORES[$punto->getColor()];
        $rgb = $colorInfo["rgb"];
        $color = imagecolorallocate($gd, $rgb[0], $rgb[1], $rgb[2]);

        $grosor = $punto->getGrosor() * 3; // escala grosor a diámetro
        imagefilledellipse($gd, $punto->getX(), $punto->getY(), $grosor, $grosor, $color);

}
   }





/**
 * 
 * 
 * EJERCICIO 3
 * 
 * 
 */

