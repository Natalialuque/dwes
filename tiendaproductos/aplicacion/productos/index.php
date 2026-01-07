<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// si no hay sesion iniciada le manda a login
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

// si le da al boton de cerrar sesion quita el usuario
if (isset($_POST["cerrarSesion"])) $acceso->quitarRegistroUsuario();

// no tiene el permiso nueve no puede entrar a la pagina (CRUD productos)
if (!$acceso->puedePermiso(9)) {
    paginaError("No tienes permiso para acceder a esta página");
    exit;
}

// controlador (ubicación para la barra)
$ubicacion = [
    "area personal" => "../../index.php",
    "indice principal Productos" => "",
];

// conectar a la base de datos 
$bd = @new mysqli($servidor, $usuario, $contraseña, $baseDatos);

// compruebo si se ha conectado bien
if ($bd->connect_error) {
    paginaError("Fallo al conectar en mySql:" . $bd->connect_error);
    exit;
}

// establece la codificación
$bd->set_charset("utf8");

// para recoger todos los productos (usamos la vista cons_productos)
@$sentencia = "SELECT * FROM cons_productos";
@$consulta = $bd->query($sentencia);

if (!$consulta) {
    paginaError("Fallo al hacer la consulta: " . $bd->connect_error);
    exit;
}

$filas = [];
while ($fila = $consulta->fetch_assoc()) {
    $filas[] = $fila;
}

// controlador: filtrado
$resultado = [];

if (isset($_POST["filtrar"])) {
    $sentencia = "SELECT * FROM cons_productos";
    $condiciones = [];

    if (!empty($_POST["nombre"])) {
        $condiciones[] = "nombre = '" . $_POST["nombre"] . "'";
    }

    if (!empty($_POST["fabricante"])) {
        $condiciones[] = "fabricante = '" . $_POST["fabricante"] . "'";
    }

    if (isset($_POST["iva"]) && $_POST["iva"] !== "") {
        $condiciones[] = "iva = '" . $_POST["iva"] . "'";
    }

    if (!empty($_POST["precio"])) {
        $condiciones[] = "precio_venta = '" . $_POST["precio"] . "'";
    }

    if (count($condiciones) > 0) {
        $sentencia .= " WHERE " . implode(" AND ", $condiciones);
    }

    if (!empty($_POST["ordenar"])) {
        $sentencia .= " ORDER BY " . $_POST["ordenar"];
    }

    $consulta = $bd->query($sentencia);
    if ($consulta) {
        while ($fila = $consulta->fetch_assoc()) {
            $resultado[] = $fila;
        }
    }
}

///////////////////////////////////////////////////////////////////////

// dibuja la plantilla de la vista
inicioCabecera("Tienda");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($filas);  // llamo a la vista
finCuerpo();

// **********************************************************

// vista cabecera (vacía para mantener la estructura)
function cabecera() {}

// vista principal
function cuerpo($filas)
{
    tablaProductos($filas);
    filtrar($filas);
}

function tablaProductos($filas)
{
?>
    <h1>PRODUCTOS</h1>
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
            <th>Operaciones</th>
        </tr>

        <?php foreach ($filas as $fila) {
            echo "<tr>";
            echo "<td>" . (isset($fila["nombre"]) ? $fila["nombre"] : '') . "</td>";
            echo "<td>" . (isset($fila["categoria_nombre"]) ? $fila["categoria_nombre"] : '') . "</td>";
            echo "<td>" . (isset($fila["fabricante"]) ? $fila["fabricante"] : '') . "</td>";
            echo "<td>" . (isset($fila["fecha_alta"]) ? $fila["fecha_alta"] : '') . "</td>";
            echo "<td>" . (isset($fila["unidades"]) ? $fila["unidades"] : '') . "</td>";
            echo "<td>" . (isset($fila["precio_base"]) ? $fila["precio_base"] : '') . "</td>";
            echo "<td>" . (isset($fila["iva"]) ? $fila["iva"] : '') . "</td>";
            echo "<td>" . (isset($fila["precio_iva"]) ? $fila["precio_iva"] : '') . "</td>";
            echo "<td>" . (isset($fila["precio_venta"]) ? $fila["precio_venta"] : '') . "</td>";
            echo "<td>" . (isset($fila["borrado"]) && $fila["borrado"] ? 'Si' : 'No') . "</td>";
            echo "<td>" . (isset($fila["foto"]) ? $fila["foto"] : '') . "</td>";
            $id = isset($fila["cod_producto"]) ? $fila["cod_producto"] : 0;
            echo "<td>
                    <a href='verproducto.php?id={$id}'>Ver</a>
                    <a href='modificarproducto.php?id={$id}'>Editar</a>
                    <a href='borrarproducto.php?id={$id}'>Borrar</a>
                </td>";
            echo "</tr>";
        }
        ?>
    </table>
    <td>
        <a href="nuevoProducto.php">añadir producto</a>
    </td>

<?php
}

/** Se debe poder filtrar por Nombre, Fabricante, IVA y Precio y establecer un criterio de ordenación. */
function filtrar($filas){
    ?>
    <h3>FILTAR</h3>
        <form action="" method="post">
        
        <label>Nombre:</label>
        <input type="text" name="nombre" id="nombre">
        <br>
        <label>Fabricante:</label>
        <input type="text" name="fabricante" id="fabricante">
        <br>
        <label>IVA:</label>
        <input type="text" name="iva" id="iva">
        <br>
        <label>Precio:</label>
        <input type="text" name="precio" id="precio">
        <br>
        <label>Ordenar:</label>
        <select name="ordenar" id="ordenar">
            <?php  
            if (!empty($filas)) {
                foreach (array_keys($filas[0]) as $col) {
                    echo "<option value=\"$col\">";
                    echo $col;
                    echo "</option>";
                }
            }
            ?>
        </select>
        <br>
        <input type="submit" value="filtrar" name="filtrar"></input>

    </form>
    <?php
}
?>
