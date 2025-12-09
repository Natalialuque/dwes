<?php


//inicialización de las cookies
if (!isset($_COOKIE["color_texto"])) {
    setcookie("color_texto", "black", time() + 24 * 60 * 60);
}
if (!isset($_COOKIE["color_fondo"])) {
    setcookie("color_fondo", "white", time() + 24 * 60 * 60);
}


function pedirLogin()
{
    if (isset($_SESSION)) //Si hay una sesión, guardamos en la sesión la dirección en la que estaba el usuario
        $_SESSION["dir_previa"] = $_SERVER["REQUEST_URI"]; //para que cuando haga el login, vuelva a la página en la que estaba
    //Redirecciona a la página de login
    header("location: /aplicacion/acceso/login.php");
}

function paginaError($mensaje)
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
function inicioCabecera($titulo)
{
?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $titulo ?></title>
        <meta name="description" content="">
        <meta name="author" content="Administrador">
        <meta name="viewport" content="width=device-width, initialscale=1.0">
        <!-- Replace favicon.ico & apple-touch-icon.png in the root
of your domain and delete these references -->
        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="stylesheet" type="text/css" href="/estilos/base.css">
    <?php
}
function finCabecera()
{
    ?>
    </head>
<?php
}
function inicioCuerpo($cabecera, array $barraLogica = [])
{
    global $acceso;
?>

    <body>
        <div id="documento">

        <header>
            <h1 id="titulo"><?php echo $cabecera; ?></h1>
        </header>

        <div id="barraLogica">
            <?php
            if ($barraLogica) {
                foreach ($barraLogica as $index => $elemento) {
                    if (isset($elemento["posicion"])) //Si existe inicio(1ªvuelta)/Practica (2ºVuelta)/Ejercicio(3º vuelta) 
                    { //Comprueba si hay direccion
                        if (isset($elemento["direccion"]))
                            echo "<a href='{$elemento["direccion"]}'>"; //Si la hay pone un enlace con la url

                        echo " <span>" . $elemento["posicion"] . "</span>"; //con su texto asociado
                        //Comprueba si tiene dirección y cierra la etiqueta, sino pone la flecha a la siguiente dirección
                        if (isset($elemento["direccion"]))
                            echo "</a> ";
                        //Solo si no es el último elemento, se añade la barra separadora
                        if ($index < count($barraLogica) - 1) { //count() devuelve el número de elementos del array. -1 devuelve el índice del último elemento del array
                            echo " | ";
                        }
                    }
                }
                /*Corregido en clase
                    $cont = 0;
                    foreach ($barraLogica as $elemento) {
                        if ($cont > 0)
                            echo " | ";
                        $cont++;

                        if (!isset($elemento["LINK"]))
                            echo $elemento["Texto"];
                        else echo "<a href = '{$elemento["LINK"]}'>{$elemento["TEXTO"]}></a>";
                    }*/
            }
            ?>
        </div>
        <?php
        if ($acceso->hayUsuario()) {
        ?><div id="barraLogin"><?php
                                        echo "Nombre de usuario: " . $acceso->getNombre() . " &emsp; <a href='/aplicacion/acceso/cerrar_sesion.php'>Cerrar Sesion</a>";
                                        ?></div><?php
                }
                    ?>
        <!-- <br> -->
        <div id="barraMenu">
            <ul>
                <li><a href="/index.php">Inicio</a></li>

            </ul>
        </div>

        <div id="relaciones">
        <?php
    }
    function finCuerpo()
    {
        ?>
            <br />
            <br />
        </div>
        <footer>
            <hr width="90%" />
            <div>
                Realizado por Elsa Reca Castellón
            </div>
        </footer>
        </div>
    </body>

    </html>
<?php
    }
