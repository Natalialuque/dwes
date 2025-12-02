<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/../../librerias/validacion.php");


// no tiene el permiso uno no puede entrar a la pagina
if(!$acceso->puedePermiso(2)){
     paginaError("No tienes permiso ");
     exit;
}


if(!$acceso->puedePermiso(3)){
     paginaError("No tienes permiso");
     exit;
}
//conectar a la base de datos 
$bd = @new mysqli($servidor, $usuario, $contraseña, $baseDatos);

//compruebo si se ha conectado bien
if ($bd->connect_error) {
    paginaError("Fallo al conectar en mySql:" . $bd->connect_error);
    exit;
 }// else {
//     echo "conecta adecuadamente";
// }

// si le da al boton de cerrar sesion quita el usuario
if(isset($_POST["cerrarSesion"])) $acceso->quitarRegistroUsuario();


//recoger el id mandado en la url
if (!isset($_GET["id"])) {
    paginaError("No se ha proporcionado ningún usuario");
    exit;
}

$cod_usuario = $_GET["id"];

// compruebo que el id que nos ha llegado existe
$sentencia = "SELECT * FROM usuarios WHERE cod_usuario = {$cod_usuario}";
$consulta  = $bd->query($sentencia);

if (!$consulta || $consulta->num_rows === 0) {
    paginaError("No existe el id introducido");
    exit;
}

//  Guardar directamente la fila en $usuario
$usuario = $consulta->fetch_assoc();



$datos = [
    "nick"=>$usuario["nick"],
    "nombre"=>$usuario["nombre"],
    "nif"=>$usuario["nif"],
    "direccion"=>$usuario["direccion"],
    "poblacion"=>$usuario["poblacion"],
    "provincia"=>$usuario["provincia"],
    "cp"=>$usuario["CP"],
    "fecha_nacimiento"=>$usuario["fecha_nacimiento"],
    "borrado"=>$usuario["borrado"],
    "foto"=>$usuario["foto"]
];

$errores =[];

if (isset($_POST["subir"])) {
    $errores = [];

    // nombre
    $nombre = trim($_POST["nombre"]);
    if ($nombre === "") {
        $errores["nombre"][] = "El nombre no puede estar vacío";
    } elseif (!validaCadena($nombre, 50, "")) {
        $errores["nombre"][] = "El nombre no puede tener más de 50 caracteres";
    }
    $datos["nombre"] = $nombre;

    // nif
    $nif = trim($_POST["nif"]);
    if ($nif === "") {
        $errores["nif"][] = "El NIF no puede estar vacío";
    } elseif (!validaCadena($nif, 10, "")) {
        $errores["nif"][] = "El NIF no puede tener más de 10 caracteres";
    }
    $datos["nif"] = $nif;

    // dirección
    $direccion = trim($_POST["direccion"]);
    if ($direccion === "") {
        $errores["direccion"][] = "La dirección no puede estar vacía";
    } elseif (!validaCadena($direccion, 50, "")) {
        $errores["direccion"][] = "La dirección no puede tener más de 50 caracteres";
    }
    $datos["direccion"] = $direccion;

    // población
    $poblacion = trim($_POST["poblacion"]);
    if ($poblacion === "") {
        $errores["poblacion"][] = "La población no puede estar vacía";
    } elseif (!validaCadena($poblacion, 50, "")) {
        $errores["poblacion"][] = "La población no puede tener más de 50 caracteres";
    }
    $datos["poblacion"] = $poblacion;

    // provincia
    $provincia = trim($_POST["provincia"]);
    if ($provincia === "") {
        $errores["provincia"][] = "La provincia no puede estar vacía";
    } elseif (!validaCadena($provincia, 30, "")) {
        $errores["provincia"][] = "La provincia no puede tener más de 30 caracteres";
    }
    $datos["provincia"] = $provincia;

    // CP
    $cp = trim($_POST["cp"]);
    if ($cp === "") {
        $errores["cp"][] = "El código postal no puede estar vacío";
    } elseif (!validaCadena($cp, 5, "")) {
        $errores["cp"][] = "El código postal no puede tener más de 5 caracteres";
    }
    $datos["cp"] = $cp;

    // fecha nacimiento
    $fecha_nacimiento = trim($_POST["fecha_nacimiento"]);
    if ($fecha_nacimiento === "") {
        $errores["fecha_nacimiento"][] = "La fecha de nacimiento no puede estar vacía";
    } elseif (!validaFecha($fecha_nacimiento, "")) {
        $errores["fecha_nacimiento"][] = "La fecha de nacimiento no tiene el formato adecuado";
    }
    $datos["fecha_nacimiento"] = $fecha_nacimiento;

    // borrado
    $borrado = trim($_POST["borrado"]);
    if ($borrado === "") {
        $errores["borrado"][] = "El campo 'borrado' no puede estar vacío";
    } elseif ($borrado != 0 && $borrado != 1) {
        $errores["borrado"][] = "El campo 'borrado' debe ser 0 o 1";
    }
    $datos["borrado"] = $borrado;

    // foto
    $foto = trim($_POST["foto"]);
    if ($foto !== "" && !validaCadena($foto, 50, "")) {
        $errores["foto"][] = "La foto debe tener como máximo 50 caracteres";
    }
    $datos["foto"] = ($foto === "") ? "defecto.png" : $foto;

    // ejecutar UPDATE si no hay errores
    // ejecutar UPDATE si no hay errores
if (empty($errores)) {

    // Actualizar los datos principales del usuario
    $sentencia = "UPDATE usuarios SET 
        nombre = '{$datos["nombre"]}', 
        nif = '{$datos["nif"]}', 
        direccion = '{$datos["direccion"]}', 
        poblacion = '{$datos["poblacion"]}', 
        provincia = '{$datos["provincia"]}', 
        CP = '{$datos["cp"]}', 
        fecha_nacimiento = '{$datos["fecha_nacimiento"]}', 
        borrado = '{$datos["borrado"]}', 
        foto = '{$datos["foto"]}' 
        WHERE cod_usuario = {$cod_usuario}";

    if ($bd->query($sentencia)) {

        // Actualizar contraseña si se ha enviado
        if (!empty($_POST["contrasena"])) {
            $aclbd->setContrasenia($cod_usuario, $_POST["contrasena"]);
        }

        // Actualizar rol del usuario
        $rol = $aclbd->getCodRole($_POST["rol"]);
        $aclbd->setUsuarioRole($cod_usuario, $rol);

        // Redirigir a la vista del usuario
        header("Location: verUsuario.php?id=" . $cod_usuario);
        exit;

    } else {
        paginaError("Error al modificar usuario: " . $bd->error);
        exit;
    }
}

}

///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($datos, $errores,$aclbd);  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo($datos, $errores,$aclbd) {

  formularioModificarUsuario($datos, $errores,$aclbd);
 
}

function formularioModificarUsuario($datos, $errores,$aclbd) {
    // Mostrar errores si los hay
    if (!empty($errores)) {
        echo "<div style='color:red'><ul>";
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul></div>";
    }
    ?>
    <form action="" method="post">
        <label>Nick:</label>
        <!-- Nick solo lectura -->
        <input type="hidden" name="nick" id="nick" disabled  value="<?= $datos["nick"] ?>"> 
        <br>
         <label for=""> Contraseña:</label>
        <input type="password" name="contrasenaConfirm"> <br>
        
        <label for="">Rol:</label>
        <select name="rol" id="">
            <?php 
            foreach($aclbd->dameRoles() as $rol) {
                echo "<option value='$rol'>$rol</option>";
            }
            ?>
        </select> <br><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?= $datos["nombre"] ?>" >
        <input type="submit" value="Genera Nombre" name="generar">
        <br>

        <label>NIF:</label>
        <input type="text" name="nif" id="nif" value="<?= $datos["nif"] ?>">
        <br>

        <label>Dirección:</label>
        <input type="text" name="direccion" id="direccion" value="<?= $datos["direccion"] ?>" >
        <br>

        <label>Población:</label>
        <input type="text" name="poblacion" id="poblacion" value="<?= $datos["poblacion"] ?>">
        <br>

        <label>Provincia:</label>
        <input type="text" name="provincia" id="provincia" value="<?= $datos["provincia"] ?>" >
        <br>

        <label>CP:</label>
        <input type="text" name="cp" id="cp" value="<?= $datos["cp"] ?>">
        <br>

        <label>Fecha Nacimiento:</label>
        <input type="text" name="fecha_nacimiento" id="fecha_nacimiento" value="<?= $datos["fecha_nacimiento"] ?>">
        <br>

        <label>Borrado (0-no // 1-sí):</label>
        <input type="text" name="borrado" id="borrado" value="<?= $datos["borrado"] ?>">
        <br>

        <label>Foto (no obligatorio):</label>
        <input type="text" name="foto" id="foto" value="<?= $datos["foto"] ?>">
        <br>

        <input type="submit" value="Guardar cambios" name="subir">
        <br>
        <a href="index.php">Volver al inicio</a> 
    </form>
    <?php
}


