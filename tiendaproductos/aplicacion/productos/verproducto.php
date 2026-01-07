<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// si le da al boton de cerrar sesion quita el usuario
if(isset($_POST["cerrarSesion"])) $acceso->quitarRegistroUsuario();

// no tiene el permiso nueve no puede entrar a la pagina
if(!$acceso->puedePermiso(9)){
     paginaError("No tienes permiso");
     exit;
}

//conectar a la base de datos 
$bd = @new mysqli($servidor, $usuario, $contraseña, $baseDatos);

//compruebo si se ha conectado bien
if ($bd->connect_error) {
    paginaError("Fallo al conectar en mySql:" . $bd->connect_error);
    exit;
}

//recoger el id mandado 
if (!isset($_GET["id"])) {
    paginaError("No se ha proporcionado ningún producto");
    exit;
}

$cod_producto = (int)$_GET["id"];

// compruebo que el id que nos ha llegado existe
$sentencia = "SELECT * FROM cons_productos WHERE cod_producto = {$cod_producto}";
$consulta  = $bd->query($sentencia);

if (!$consulta || $consulta->num_rows === 0) {
    paginaError("No existe el id introducido");
    exit;
}

// Guardar directamente la fila en $producto
$producto = $consulta->fetch_assoc();

///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Tienda");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($producto,$acceso);  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo($producto,$acceso) {
     formularioVerProducto($producto,$acceso);
}

function formularioVerProducto($producto,$acceso){
     ?>
      <table class="tablaUsuario">
        <tr>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Fabricante</th>
            <th>Fecha Alta</th>
            <th>Unidades</th>
            <th>Precio Base</th>
            <th>IVA</th>
            <th>Precio IVA</th>
            <th>Precio Venta</th>
            <th>Borrado</th>
            <th>Foto</th>
            <?php if($acceso->puedePermiso(9)) echo "<th>Operaciones</th>"?>
         </tr>

        <tr>
          <td><?= $producto["nombre_producto"] ?></td>
          <td><?= $producto["nombre_categoria"] ?></td>
          <td><?= $producto["fabricante"] ?></td>
          <td><?= $producto["fecha_alta"] ?></td>
          <td><?= $producto["unidades"] ?></td>
          <td><?= $producto["precio_base"] ?></td>
          <td><?= $producto["iva"] ?></td>
          <td><?= $producto["precio_iva"] ?></td>
          <td><?= $producto["precio_venta"] ?></td>
          <td><?= ($producto["borrado"]==0 ? "NO" : "SI") ?></td>
          <td><?= $producto["foto"] ?></td>

          <?php if($acceso->puedePermiso(9)) echo "<td>
               <a href='modificarproducto.php?id={$producto["cod_producto"]}'>Editar</a>
               <a href='borrarproducto.php?id={$producto["cod_producto"]}'>Borrar</a>
          </td>";?>
        </tr>
     </table>

      <a href="index.php">Volver a la tabla</a>
     <?php
}

?>
