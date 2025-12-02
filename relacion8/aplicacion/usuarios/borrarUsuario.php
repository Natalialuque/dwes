<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");


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
} //else {
   // echo "conecta adecuadamente";
//}

// si le da al boton de cerrar sesion quita el usuario
if(isset($_POST["cerrarSesion"])) $acceso->quitarRegistroUsuario();

//recoger el id mandado 
if (!isset($_GET["nick"])) {
    paginaError("No se ha proporcionado ningún nick");
    exit;
}

$nick = $_GET["nick"];


// Comprobar si el usuario existe
$consulta = $bd->query("SELECT * FROM usuarios WHERE nick = '{$nick}'");

if (!$consulta || $consulta->num_rows === 0) {
    paginaError("No existe el usuario introducido");
    exit;
}

// Obtener los datos del usuario
$usuario = $consulta->fetch_assoc();

// Procesar la decisión del usuario
if (isset($_POST["si"])) {

    $sql = "UPDATE usuarios SET borrado = 1 WHERE nick = '{$nick}'";
    $resultado = $bd->query($sql);

    if ($resultado === TRUE) {
        echo "Usuario marcado como borrado correctamente.";
        header("Location: /aplicacion/usuarios/index.php");
        exit;
    } else {
        echo "Error al marcar como borrado: " . $bd->error;
        echo "<br>Consulta ejecutada: $sql";
        exit;
    }
}

if (isset($_POST["no"])) {
    header("Location: index.php");
    exit;
}



///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($usuario);  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo($usuario) {
    formularioUsua($usuario);
}


function formularioUsua ($usuario){
?>    

    <div class="tablaUsuario">
        <table>
            <tr>
                <th>Nick</th>
                <th>Nombre</th>
                <th>NIF</th>
                <th>Direccion</th>
                <th>Poblacion</th>
                <th>Provincia</th>
                <th>CP</th>
                <th>Fecha_nacimiento</th>
                <th>Borrado</th>
                <th>Foto</th>
            </tr>
            <tr>
                <td><?= $usuario["nick"] ?></td>
                <td><?= $usuario["nombre"] ?></td>
                <td><?= $usuario["nif"] ?></td>
                <td><?= $usuario["direccion"] ?></td>
                <td><?= $usuario["poblacion"] ?></td>
                <td><?= $usuario["provincia"] ?></td>
                <td><?= $usuario["CP"] ?></td>
                <td><?= $usuario["fecha_nacimiento"] ?></td>
                <td><?= ($usuario["borrado"]==1 ? "no" : "si") ?></td>
                <td><?= $usuario["foto"] ?></td>
            </tr>
        </table>
    </div>
      <a href="index.php">Volver a la tabla</a>

    <form action="" method="post">
        <label for="">Seguro de querer eliminar este usuario?</label>
        <input type="submit" value="Si" name="si">
        <input type="submit" value="No" name="no">
    </form>

<?php
 
}

?>