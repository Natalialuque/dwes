<?php

function paginaError(string $mensaje)
{
    header("HTTP/1.0 404 $mensaje");
    inicioCabecera("PRACTICA");
    finCabecera();
    inicioCuerpo("ERROR");
    echo "<br><br>";
    echo $mensaje;
    echo "<br><br><br>";
    echo "<a href='/index.php'>Ir a la página principal</a>";
    finCuerpo();
}

function inicioCabecera(string $titulo)
{
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?= $titulo ?></title>
    <meta name="description" content="">
    <meta name="author" content="Administrador">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="/estilos/base.css">
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
            <h1 id="titulo"><?= $cabecera ?></h1>

            <?php 
            // Si hay usuario logueado, mostrar perfil y cerrar sesión
            if ($acceso->hayUsuario()) {
                $nick = $acceso->getNick();
                ?>
                <div class="perfil">
                    <h4>Bienvenido <?= $nick ?></h4>
                    <a href="/aplicacion/usuarios/perfil.php?nick=<?= $nick ?>">
                        <img src="/imagenes/perfil.png" alt="Perfil">
                    </a>
                </div>

                <form action="" method="post">
                    <button name="cerrarSesion">Cerrar sesión</button>
                </form>
                <?php
            } else {
                ?>
                <a href="/aplicacion/acceso/login.php">Iniciar Sesión</a>
                <?php
            }
            ?>

            <!-- MENÚ SUPERIOR -->
            <div class="menuSuperior">
                <a href="/index.php">Inicio</a>

                <?php
                if ($acceso->hayUsuario()) {

                    // Permiso 10 → Gestión de usuarios
                    if ($acceso->puedePermiso(10)) {
                        echo "<a href='/aplicacion/usuarios/index.php'>Usuarios</a>";
                    }

                    // Permiso 9 → Gestión de productos
                    if ($acceso->puedePermiso(9)) {
                        echo "<a href='/aplicacion/productos/index.php'>Productos</a>";
                    }

                    echo "<a href='/aplicacion/usuarios/perfil.php?nick=$nick'>Mi Perfil</a>";
                    echo "<a href='/aplicacion/usuarios/compras.php?nick=$nick'>Mis compras</a>";
                    echo "<a href='/aplicacion/productos/cesta.php'>Cesta</a>";
                }
                ?>
            </div>
        </header>

        <!-- BARRA DE UBICACIÓN -->
        <div id="barraMenu">
            <ul>
                <?php
                if (isset($GLOBALS['ubicacion'])) {
                    mostrarBarraUbicacion($GLOBALS['ubicacion']);
                }
                ?>
            </ul>
        </div>

        <div id="barraLogin">
<?php
}

function finCuerpo()
{
?>
        </div>

        <footer>
            <hr width="90%">
            <div>
                &copy; Copyright 
                <?= date("Y") ?> 
                by Natalia Cabello Luque
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
?>
