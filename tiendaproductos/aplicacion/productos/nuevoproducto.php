<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");


// no tiene el permiso nueve no puede entrar a la pagina
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


// datos del formulario
$datos = [];
$errores =[];


// -----------------------------
// PROCESAR FORMULARIO
// -----------------------------
if(isset($_POST["crear"])) {

    // nombre del producto
    $datos["nombreProducto"] = $bd->escape_string($_POST["nombre"]);
    if(empty($_POST["nombre"])) 
        $errores["nombre"][] = "Nombre no puede estar vacío";

    // fabricante
    $datos["fabricante"] = $bd->escape_string($_POST["fabricante"]);
    if(empty($_POST["fabricante"]))
        $errores["fabricante"][] = "Fabricante no puede estar vacío";

    // comprobar que el nombre no existe
    $sentencia = "SELECT * FROM productos WHERE nombre='".$datos["nombreProducto"]."'";
    $consulta = $bd->query($sentencia);
    if($consulta->num_rows > 0) 
        $errores["existe"][] = "Este producto ya existe";

    // fecha alta
    $fechaInput = $_POST["fecha"];
    $partes = explode("-", $fechaInput);
    $fechaStr = $partes[2]."/".$partes[1]."/".$partes[0];

    if(!validaFecha($fechaStr, "")) 
        $errores["fecha_alta"][] = "No has introducido un valor correcto";

    $fecha = DateTime::createFromFormat("Y-m-d", $fechaInput);
    $datos["fecha_alta"] = $fecha->format("Y-m-d");

    $hoy = new DateTime();
    $minima = new DateTime("2010-02-28");

    if($fecha > $hoy) 
        $errores["fecha_alta"][] = "La fecha alta debe ser menor o igual a hoy";

    if($fecha <= $minima) 
        $errores["fecha_alta"][] = "La fecha mínima es 28/02/2010";

    // unidades
    $datos["unidades"] = $_POST["unidades"];
    if($datos["unidades"] < 0) 
        $errores["unidades"][] = "Las unidades deben ser un número positivo";

    // precios
    $datos["precio_base"]  = (float)$_POST["precio_base"];
    $datos["precio_iva"]   = (float)$_POST["precio_iva"];
    $datos["precio_venta"] = (float)$_POST["precio_venta"];

    if($datos["precio_base"] < 0 || $datos["precio_iva"] < 0 || $datos["precio_venta"] < 0)
        $errores["precio"][] = "Los precios deben ser positivos";

    // IVA
    $datos["iva"] = (int)$_POST["iva"];

    // foto
    $datos["foto"] = $bd->escape_string($_POST["foto"]);

    // categoría
    $sentencia = "SELECT cod_categoria FROM categorias WHERE descripcion='" . $bd->escape_string($_POST["categoria"]) . "'";
    $consulta = $bd->query($sentencia);
    $fila = $consulta->fetch_assoc();
    $datos["categoria"] = $fila["cod_categoria"];


    // -----------------------------
    // INSERTAR PRODUCTO
    // -----------------------------
    if (empty($errores)) {

        $sentencia = "INSERT INTO productos 
        (nombre, cod_categoria, fabricante, fecha_alta, unidades, precio_base, iva, precio_iva, precio_venta, foto, borrado)
        VALUES (
            '{$datos["nombreProducto"]}',
            {$datos["categoria"]},
            '{$datos["fabricante"]}',
            '{$datos["fecha_alta"]}',
            {$datos["unidades"]},
            {$datos["precio_base"]},
            {$datos["iva"]},
            {$datos["precio_iva"]},
            {$datos["precio_venta"]},
            '{$datos["foto"]}',
            0
        )";

        $consulta = $bd->query($sentencia);

        if (!$consulta) { 
            echo "ERROR SQL: " . $bd->error; 
            exit; 
        }

        header("Location: /aplicacion/productos/index.php");
        exit;
    }
}


// -----------------------------
// DIBUJAR PLANTILLA
// -----------------------------
inicioCabecera("Tienda");
cabecera();
finCabecera();

inicioCuerpo("2 DAW - Tienda");
cuerpo($datos, $errores, $bd);
finCuerpo();


// -----------------------------
// VISTAS
// -----------------------------
function cabecera() {}

function cuerpo($datos, $errores, $bd)
{
    formulario($datos, $errores, $bd);
}

function formulario($datos, $errores, $bd) {

    if ($errores) {
        echo "<div class='error'>";
        foreach ($errores as $clave => $valor) {
            foreach ($valor as $error)
                echo "$clave => $error<br>";
        }
        echo "</div>";
    }
    ?>

    <h2>NUEVO PRODUCTO</h2>

    <form action="" method="post">

        <label>Nombre</label>
        <input type="text" name="nombre"><br>

        <label>Fabricante</label>
        <input type="text" name="fabricante"><br>

        <label>Fecha Alta</label>
        <input type="date" name="fecha"><br>

        <label>Unidades</label>
        <input type="text" name="unidades"><br>

        <label>Precio Base</label>
        <input type="text" name="precio_base"><br>

        <label>IVA</label>
        <input type="text" name="iva"><br>

        <label>Precio IVA</label>
        <input type="text" name="precio_iva"><br>

        <label>Precio Venta</label>
        <input type="text" name="precio_venta"><br>

        <label>Foto</label>
        <input type="text" name="foto"><br>

        <label>Categoría</label>
        <select name="categoria">
            <?php 
            $sentencia = "SELECT descripcion FROM categorias";
            $consulta = $bd->query($sentencia);
            while($fila = $consulta->fetch_assoc()) {
                echo "<option value='{$fila["descripcion"]}'>{$fila["descripcion"]}</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Crear producto" name="crear"><br>

        <a href="./index.php">Volver a productos</a>

    </form>

    <?php
}
?>
