<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");


// si le da al boton de cerrar sesion quita el usuario
if(isset($_POST["cerrarSesion"])) $acceso->quitarRegistroUsuario();

// no tiene el permiso uno no puede entrar a la pagina
if(!$acceso->puedePermiso(2)){
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
//     echo "conecta adecuadamente";
// }

//recoger el id mandado 
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


///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($usuario,$acceso);  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo($usuario,$acceso) {
     fomrularioVer($usuario,$acceso);
}

function fomrularioVer($usuario,$acceso){
     ?>
      <table class="tablaUsuario">
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
            <?php if($acceso->puedePermiso(3)) echo "<th>Operaciones</th>"?>
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
          <td><?= ($usuario["borrado"]==0 ? "NO" : "SI") ?></td>
          <td><?= $usuario["foto"] ?></td>
          <?php if($acceso->puedePermiso(3)) echo "<td>
               <a href='modificarUsuario.php?id={$usuario["cod_usuario"]}'>Editar</a>
               <a href='borrarUsuario.php?nick={$usuario["nick"]}'>Borrar</a>
          </td>";?>
        </tr>
     </table>
      <a href="index.php">Volver a la tabla</a>
     <?php
}

?>