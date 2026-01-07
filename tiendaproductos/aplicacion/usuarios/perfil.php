<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Modificar Usuario" => "/aplicacion/usuarios/modificarUsuario.php"
];
$GLOBALS["ubicacion"] = $ubicacion;

// cerrar sesión
if(isset($_POST["cerrarSesion"])) $acceso->quitarRegistroUsuario();


// comprobar conexión
if ($bd->connect_errno) {
    paginaError("Fallo al conectar a la base de datos: " . $bd->connect_error);
    exit;
}

// recoger nick
$nick = $_GET["nick"];

// comprobar que existe
$sentencia = "SELECT * FROM usuarios WHERE nick = '{$nick}'";
$consulta = $bd->query($sentencia);

if ($consulta->num_rows === 0) {
    paginaError("No existe el usuario indicado");
    exit;
}

$usuario = $consulta->fetch_assoc();

// preparar datos
$datos = [
    "nick"      => $usuario["nick"],
    "nombre"    => $usuario["nombre"],
    "direccion" => $usuario["direccion"]
];

$errores = [];

// procesar formulario
if (isset($_POST["modificar"])) {

    // validar nombre
    $datos["nombre"] = $_POST["nombre"];
    if (empty($_POST["nombre"])) {
        $errores["nombre"][] = "Nombre no puede estar vacío";
    } elseif (!validaCadena($_POST["nombre"], 50, "")) {
        $errores["nombre"][] = "Nombre debe ser de 50 caracteres máximo";
    }

    // validar dirección
    $datos["direccion"] = $_POST["direccion"];
    if (empty($_POST["direccion"])) {
        $errores["direccion"][] = "Dirección no puede estar vacía";
    } elseif (!validaCadena($_POST["direccion"], 50, "")) {
        $errores["direccion"][] = "Dirección debe ser de 50 caracteres máximo";
    }

    // actualizar usuario
    if (empty($errores)) {

        // actualizar contraseña si se ha enviado
        if (!empty($_POST["contrasena"])) {
            $aclbd->setContrasenia(
                $aclbd->getCodUsuario($datos["nick"]),
                $_POST["contrasena"]
            );
        }

        $sentencia = "
            UPDATE usuarios SET 
            nombre = '{$datos["nombre"]}',
            direccion = '{$datos["direccion"]}'
            WHERE nick = '{$nick}'
        ";

        $bd->query($sentencia);

        header("Location: /aplicacion/usuarios/verUsuario.php?id=" . $usuario["cod_usuario"]);
        exit;
    }
}


//////////////////////////////////////////////////////////////////////
inicioCabecera("Tienda");
cabecera();
finCabecera();

inicioCuerpo("Tienda");
cuerpo($datos, $errores, $acceso);
finCuerpo();

//////////////////////////////////////////////////////////////////////

function cabecera() {}

function cuerpo($datos, $errores, $acceso)
{
    formulario($datos, $errores, $acceso);
}


//fprumulario
function formulario($datos, $errores, $acceso)
{
    if (!empty($errores)) {
        ?>
        <div class="error">
            <?php foreach ($errores as $campo => $lista) {
                foreach ($lista as $error) { ?>
                    <?= $campo ?> => <?= $error ?><br>
                <?php }
            } ?>
        </div>
        <?php
    }
    ?>

    <h2>MODIFICAR USUARIO</h2>

    <form action="" method="post">

        <label>Nick:</label>
        <label><?= $datos["nick"] ?></label>
        <input type="hidden" name="nick" disabled value="<?= $datos["nick"] ?>">
        <br>

        <label>Contraseña:</label>
        <input type="password" name="contrasena"><br>

        <label>Introduce Nombre:</label>
        <input type="text" name="nombre" value="<?= $datos["nombre"] ?>"><br>

        <label>Introduce Dirección:</label>
        <input type="text" name="direccion" value="<?= $datos["direccion"] ?>"><br>

        <input type="submit" value="Modificar usuario" name="modificar"><br>

        <?php if ($acceso->puedePermiso(10)) { ?>
            <a href="./index.php" style="margin-left: 10px;">Volver a usuarios</a>
        <?php } ?>

    </form>

    <?php
}
?>
