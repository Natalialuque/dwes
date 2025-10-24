<?php
function paginaError(string $mensaje)
{
    header("HTTP/1.0 404 $mensaje");
    inicioCabecera("PRACTICA");
    finCabecera();
    inicioCuerpo("ERROR");
    echo "<br />\n";
    echo $mensaje;
    echo "<br />\n";
    echo "<br />\n";
    echo "<br />\n";
    echo "<a href='/index.php'>Ir a la pagina principal</a>\n";

    finCuerpo();
}
function inicioCabecera(string $titulo)
{
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8">
        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible"
            content="IE=edge,chrome=1">
        <title><?php echo $titulo ?></title>
        <meta name="description" content="">
        <meta name="author" content="Administrador">
        <meta name="viewport" content="width=device-width; initialscale=1.0">
        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="stylesheet" type="text/css" href="/../../estilos/base.css">
    <?php
}
function finCabecera()
{
    ?>
    </head>
<?php
}
function inicioCuerpo(string $cabecera)
{
    global $acceso;
?>

    <body>
        <div id="documento">

            <header>
                <h1 id="titulo"><?php echo $cabecera; ?></h1>

                <div id="menuPrincipal">
                    <ul>
                        <li><a href="/index.php">Inicio</a></li>
                        <li><a href="/aplicacion/practica1/index.php">Práctica 1</a></li>
                        <li><a href="/aplicacion/practica2/index.php">Práctica 2</a></li>
                        <li><a href="/aplicacion/practica3/index.php">Práctica 3</a></li>
                        <li><a href="/aplicacion/practica4/index.php">Práctica 4</a></li>
                        <li><a href="/aplicacion/practica5/index.php">Práctica 5</a></li>
                        <li><a href="/aplicacion/pruebas/index.php">Pruebas</a></li>

                    </ul>
                </div>
            </header>

            <div id="barraLogin">

            </div>
            <div id="barraMenu">
                <ul>
                    <?php
                    if (isset($GLOBALS['ubicacion'])) {
                        mostrarBarraUbicacion($GLOBALS['ubicacion']);
                    }
                    ?>
                </ul>
            </div>
        <?php
    }
    function finCuerpo()
    {
        ?>
            <br />
            <br />

            <footer>
                <hr width="90%" />
                <div>
                    &copy; Copyright by natalia cabello luque
                </div>
            </footer>
        </div>
    </body>

    </html>
<?php
    }
    function mostrarBarraUbicacion(array $ubicacion)
    {
        echo "<nav class='barraModdle'>";
        $total = count($ubicacion);
        $contador = 0;

        foreach ($ubicacion as $nombre => $url) {
            $contador++;
            if ($contador < $total) {
                echo "<a href='{$url}'>{$nombre}</a> &raquo; ";
            } else {
                echo "<span>{$nombre}</span>";
            }
        }

        echo "</nav><br>";
    }
