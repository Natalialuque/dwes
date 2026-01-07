<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// no tiene el permiso nueve no puede entrar a la pagina (CRUD productos)
if(!$acceso->puedePermiso(9)){
     paginaError("No tienes permiso ");
     exit;
}

//conectar a la base de datos 
$bd = @new mysqli($servidor, $usuario, $contraseña, $baseDatos);

//compruebo si se ha conectado bien
if ($bd->connect_error) {
    paginaError("Fallo al conectar en mySql:" . $bd->connect_error);
    exit;
}

// si le da al boton de cerrar sesion quita el usuario
if(isset($_POST["cerrarSesion"])) $acceso->quitarRegistroUsuario();

//recoger el id mandado 
if (!isset($_GET["id"])) {
    paginaError("No se ha proporcionado ningún id de producto");
    exit;
}

$id = $bd->real_escape_string($_GET["id"]);

// Comprobar si el producto existe (usamos la vista cons_productos para mostrar datos legibles)
$consulta = $bd->query("SELECT * FROM cons_productos WHERE cod_producto = '{$id}'");

if (!$consulta || $consulta->num_rows === 0) {
    paginaError("No existe el producto introducido");
    exit;
}

// Obtener los datos del producto
$producto = $consulta->fetch_assoc();

// Procesar la decisión del usuario
if (isset($_POST["si"])) {

    $sql = "UPDATE productos SET borrado = 1 WHERE cod_producto = '{$id}'";
    $resultado = $bd->query($sql);

    if ($resultado === TRUE) {
        header("Location: /aplicacion/productos/index.php");
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
inicioCabecera("Tienda");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($producto);  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo($producto) {
    formularioProducto($producto);
}

function formularioProducto($producto){
?>    

    <div class="tablaProducto">
        <table>
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Fabricante</th>
                <th>Fecha alta</th>
                <th>Unidades</th>
                <th>Precio Base</th>
                <th>IVA</th>
                <th>Precio IVA</th>
                <th>Precio Venta</th>
                <th>Borrado</th>
                <th>Foto</th>
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
                <td><?= ($producto["borrado"]==1 ? "SI" : "NO") ?></td>
                <td><?= $producto["foto"] ?></td>
            </tr>
        </table>
    </div>

    <a href="index.php">Volver a la tabla</a>

    <form action="" method="post">
        <label for="">Seguro de querer eliminar este producto?</label>
        <input type="submit" value="Si" name="si">
        <input type="submit" value="No" name="no">
    </form>

<?php
}
