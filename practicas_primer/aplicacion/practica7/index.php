<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once("/web/sitios/dwes/practicas_primer/scripts/librerias/validacion.php");


//controlador
$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 7"=> "./index.php",

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;


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
$mostrar=false;

// Determinar fichero del cliente
$ip = str_replace(".", "_", $_SERVER['REMOTE_ADDR']);
$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
$navegador = "desconocido";
if (strpos($userAgent, "chrome") !== false) $navegador = "chrome";
elseif (strpos($userAgent, "firefox") !== false) $navegador = "firefox";
elseif (strpos($userAgent, "safari") !== false && strpos($userAgent, "chrome") === false) $navegador = "safari";
elseif (strpos($userAgent, "edge") !== false) $navegador = "edge";
elseif (strpos($userAgent, "msie") !== false || strpos($userAgent, "trident") !== false) $navegador = "ie";

$nombreFichero = "puntos_{$ip}_{$navegador}.dat";
$rutaFichero = RUTABASE . "/practica7/datos" . $nombreFichero;

// Cargar puntos desde fichero
if (file_exists($rutaFichero)) {
    $lineas = file($rutaFichero, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lineas as $linea) {
        list($x, $y, $color, $grosor) = array_map("trim", explode(";", $linea));
        try {
            $puntos[] = new Punto((int)$x, (int)$y, $color, (int)$grosor);
        } catch (Exception $e) {
            // Ignorar líneas corruptas
        }
    }
}

//imagenes 
$rutaweb = "/imagenes/puntos/";
$rutaphp = RUTABASE . $rutaweb;


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



   // Si no hay errores, instanciar el objeto Punto y guardar
    if (empty($errores)) {
        try {
            $punto = new Punto((int)$x, (int)$y, $color, (int)$grosor);
            $puntos[] = $punto;

            // Guardar también en fichero .dat
            if (!is_dir(RUTABASE . "/practica7/datos")) {
                mkdir(RUTABASE . "/practica7/datos", 0777, true);
            }
            $linea = $punto->getX() . " ; " . $punto->getY() . " ; " . $punto->getColor() . " ; " . $punto->getGrosor() . PHP_EOL;
            file_put_contents($rutaFichero, $linea, FILE_APPEND);

        } catch (Exception $e) {
            echo "<p>Error al crear el punto: " . $e->getMessage() . "</p>";
        }
    }

    
            //para cuando le demos a guardar se cree
            $imagenCliente = crearImagenCliente($rutaphp, $puntos);

}

/**
 * 
 * 
 * EJERCICIO 4
 * 
 * 
 */
if (isset($_POST["borrar"]) && isset($_POST["puntoBorrar"])) {
    $indice = (int)$_POST["puntoBorrar"];
    if (isset($puntos[$indice])) {
        // Eliminar del array
        unset($puntos[$indice]);
        $puntos = array_values($puntos); // reindexar

        // Reescribir fichero .dat
        $contenido = "";
        foreach ($puntos as $p) {
            $contenido .= $p->getX() . " ; " . $p->getY() . " ; " . $p->getColor() . " ; " . $p->getGrosor() . PHP_EOL;
        }
        file_put_contents($rutaFichero, $contenido);

        // Regenerar imagen
        $imagenCliente = crearImagenCliente($rutaphp, $puntos);
    }
}



// Si no se ha pulsado guardar ni borrar, generar imagen con los puntos cargados
if (!isset($_POST["guardar"]) && !isset($_POST["borrar"])) {
    $imagenCliente = crearImagenCliente($rutaphp, $puntos);
}


/**
 * 
 * EJERCICIO 5 - Descargar imagen
 * 
 */
if (isset($_POST["descargar"])) {
    // Cabeceras para forzar descarga
    header('Content-Type: image/jpeg');
    header('Content-Disposition: attachment; filename="' . nombreArch() . '"');

    // Generar y devolver la imagen al vuelo
    devuelveImagen($puntos);
    exit;
}
/**
 * 
 * EJERCICIO 6
 * 
 */
// Procesar subida de fichero TXT
if (isset($_POST["subida"])) {
    $mostrar = true;
    if (isset($_FILES["archivo"])) {
        if ($_FILES["archivo"]["error"] !== 0) {
            $errores[] = "Errores en la subida del archivo";
        }
        if ($_FILES["archivo"]["size"] == 0) {
            $errores[] = "El fichero está vacío";
        }
        if ($_FILES["archivo"]["type"] !== "text/plain") {
            $errores[] = "Solo se permiten ficheros TXT";
        }

        if (!$errores) {
            $lineas = file($_FILES["archivo"]["tmp_name"], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lineas as $linea) {
                $partes = array_map("trim", explode(";", $linea));
                if (count($partes) == 4) {
                    list($x, $y, $color, $grosor) = $partes;
                    $xInt = (int)$x;
                    $yInt = (int)$y;
                    $grosorInt = (int)$grosor;

                    // Validaciones
                    if (validaEntero($xInt, 0, 500, 0) && validaEntero($yInt, 0, 500, 0)
                        && array_key_exists($color, Punto::COLORES)
                        && array_key_exists($grosorInt, Punto::GROSORES)) {
                        try {
                            $punto = new Punto($xInt, $yInt, $color, $grosorInt);
                            $puntos[] = $punto;
                        } catch (Exception $e) {}
                    }
                }
            }

            // Reescribir fichero .dat
            $contenido = "";
            foreach ($puntos as $p) {
                $contenido .= $p->getX() . " ; " . $p->getY() . " ; " . $p->getColor() . " ; " . $p->getGrosor() . PHP_EOL;
            }
            if (!is_dir(RUTABASE . "/practica7/datos")) {
                mkdir(RUTABASE . "/practica7/datos", 0777, true);
            }
            file_put_contents($rutaFichero, $contenido);

            // Regenerar imagen
            $imagenCliente = crearImagenCliente(RUTABASE . "/imagenes/puntos/", $puntos);
        }
    }
}

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
    formularioBorrado($puntos);
    descarga();
    subirArchivo($errores);

    
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
 * EJERCICIO 4
 * 
 *
 */
function formularioBorrado($puntos) {
    if (count($puntos) === 0) {
        echo "<p>No hay puntos para borrar.</p>";
        return;
    }
    ?>
    <form method="post" action="">
        <label for="puntoBorrar">Selecciona un punto:</label>
        <select name="puntoBorrar" id="puntoBorrar">
            <?php foreach ($puntos as $indice => $punto): ?>
                <option value="<?php echo $indice; ?>">
                    <?php echo "X:" . $punto->getX() . ", Y:" . $punto->getY() . "Color: " . $punto->getColor() . ", Grosor:" . $punto->getGrosor(); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="borrar" value="Borrar">
    </form>
    <?php
}


/***
 * 
 * EJERCICIO 5
 * 
 */
function descarga(){
?>
    <form action="" method="post">
        <input type="submit" value="Descargar" name="descargar">
    </form>
<?php
}

function nombreArch() {
    $ip = str_replace(".", "_", $_SERVER['REMOTE_ADDR']);
    $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
    $navegador = "desconocido";
    if (strpos($userAgent, "chrome") !== false) $navegador = "chrome";
    elseif (strpos($userAgent, "firefox") !== false) $navegador = "firefox";
    elseif (strpos($userAgent, "safari") !== false && strpos($userAgent, "chrome") === false) $navegador = "safari";
    elseif (strpos($userAgent, "edge") !== false) $navegador = "edge";
    elseif (strpos($userAgent, "msie") !== false || strpos($userAgent, "trident") !== false) $navegador = "ie";

    return "imagen_{$ip}_{$navegador}.jpg";
}

function devuelveImagen(array $puntos) {
    $gd = imagecreatetruecolor(500, 500);
    $fondo = imagecolorallocate($gd, 255, 255, 255);
    imagefilledrectangle($gd, 0, 0, 500, 500, $fondo);

    $borde = imagecolorallocate($gd, 0, 0, 0);
    imagerectangle($gd, 0, 0, 499, 499, $borde);

    foreach ($puntos as $punto) {
        $colorInfo = Punto::COLORES[$punto->getColor()];
        $rgb = $colorInfo["rgb"];
        $color = imagecolorallocate($gd, $rgb[0], $rgb[1], $rgb[2]);
        $grosor = $punto->getGrosor() * 3;
        imagefilledellipse($gd, $punto->getX(), $punto->getY(), $grosor, $grosor, $color);
    }

    imagejpeg($gd); // enviar directamente al navegador
    imagedestroy($gd);
}



/**
 * 
 * EJERCICI 6
 * 
 */
function subirArchivo($errores) {
    ?>
    <h2>Subir archivo puntos</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="archivo" id="archivo">
        <input type="submit" value="Subir Archivo" name="subirArch">
    </form>
    <?php if (!empty($errores["subirArch"])) { ?>
            <?php foreach ($errores["subirArch"] as $mensaje) { ?>
                <p style="color: red;"><?= $mensaje ?></p>
            <?php } ?>
        <?php } ?>
    <?php 
}
?>

<?php
