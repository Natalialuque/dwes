<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Modificar Producto" => "/aplicacion/productos/modificarproducto.php"
];

// permiso: CRUD productos (9)
if(!$acceso->puedePermiso(9)){
     paginaError("No tienes permiso ");
     exit;
}

// conectar a la base de datos 
$bd = @new mysqli($servidor, $usuario, $contraseña, $baseDatos);

// compruebo si se ha conectado bien
if ($bd->connect_error) {
    paginaError("Fallo al conectar en mySql:" . $bd->connect_error);
    exit;
}

// si le da al boton de cerrar sesion quita el usuario
if(isset($_POST["cerrarSesion"])) $acceso->quitarRegistroUsuario();

// recoger el id mandado en la url
if (!isset($_GET["id"])) {
    paginaError("No se ha proporcionado ningún producto");
    exit;
}

$cod_producto = (int)$_GET["id"];

// compruebo que el id que nos ha llegado existe (uso la vista cons_productos para datos legibles)
$sentencia = "SELECT * FROM cons_productos WHERE cod_producto = {$cod_producto}";
$consulta  = $bd->query($sentencia);

if (!$consulta || $consulta->num_rows === 0) {
    paginaError("No existe el id introducido");
    exit;
}

// Guardar directamente la fila en $producto
$producto = $consulta->fetch_assoc();

$datos = [
    "nombre"       => $producto["nombre"] ?? '',
    "fabricante"   => $producto["fabricante"] ?? '',
    "fecha_alta"   => $producto["fecha_alta"] ?? '',
    "unidades"     => $producto["unidades"] ?? 0,
    "precio_base"  => $producto["precio_base"] ?? 0,
    "iva"          => $producto["iva"] ?? 0,
    "precio_iva"   => $producto["precio_iva"] ?? 0,
    "precio_venta" => $producto["precio_venta"] ?? 0,
    "borrado"      => $producto["borrado"] ?? 0,
    "foto"         => $producto["foto"] ?? '',
    "categoria"    => $producto["cod_categoria"] ?? null,
    "categoria_desc" => $producto["categoria_nombre"] ?? ''
];

$errores = [];

if (isset($_POST["subir"])) {
    $errores = [];

    // nombre
    $nombre = trim($_POST["nombre"] ?? '');
    if ($nombre === "") {
        $errores["nombre"][] = "El nombre no puede estar vacío";
    } elseif (!validaCadena($nombre, 150, "")) {
        $errores["nombre"][] = "El nombre no puede tener más de 150 caracteres";
    }
    $datos["nombre"] = $nombre;

    // fabricante
    $fabricante = trim($_POST["fabricante"] ?? '');
    if ($fabricante === "") {
        $errores["fabricante"][] = "El fabricante no puede estar vacío";
    } elseif (!validaCadena($fabricante, 100, "")) {
        $errores["fabricante"][] = "El fabricante no puede tener más de 100 caracteres";
    }
    $datos["fabricante"] = $fabricante;

    // fecha alta (esperamos formato Y-m-d desde input date)
    $fecha_alta = trim($_POST["fecha_alta"] ?? '');
    if ($fecha_alta === "") {
        $errores["fecha_alta"][] = "La fecha de alta no puede estar vacía";
    } elseif (!validaFecha($fecha_alta, "")) {
        $errores["fecha_alta"][] = "La fecha de alta no tiene el formato adecuado";
    } else {
        // validar rango: mayor que 28/02/2010 y <= hoy
        $fechaObj = DateTime::createFromFormat("Y-m-d", $fecha_alta);
        if (!$fechaObj) {
            $errores["fecha_alta"][] = "Fecha no válida";
        } else {
            $hoy = new DateTime();
            $minima = new DateTime("2010-02-28");
            if ($fechaObj > $hoy) $errores["fecha_alta"][] = "La fecha alta debe ser menor o igual a hoy";
            if ($fechaObj <= $minima) $errores["fecha_alta"][] = "La fecha minima es 28/02/2010";
            $datos["fecha_alta"] = $fechaObj->format("Y-m-d");
        }
    }

    // unidades
    $unidades = isset($_POST["unidades"]) ? (int)$_POST["unidades"] : 0;
    if ($unidades < 0) $errores["unidades"][] = "Las unidades deben ser un número positivo";
    $datos["unidades"] = $unidades;

    // precios
    $precio_base  = isset($_POST["precio_base"]) ? (float)$_POST["precio_base"] : 0.0;
    $precio_iva   = isset($_POST["precio_iva"]) ? (float)$_POST["precio_iva"] : 0.0;
    $precio_venta = isset($_POST["precio_venta"]) ? (float)$_POST["precio_venta"] : 0.0;
    if ($precio_base < 0 || $precio_iva < 0 || $precio_venta < 0) {
        $errores["precio"][] = "Los precios deben ser positivos";
    }
    $datos["precio_base"] = $precio_base;
    $datos["precio_iva"] = $precio_iva;
    $datos["precio_venta"] = $precio_venta;

    // iva
    $iva = isset($_POST["iva"]) ? (int)$_POST["iva"] : 0;
    $datos["iva"] = $iva;

    // borrado
    $borrado = trim($_POST["borrado"] ?? '');
    if ($borrado === "") {
        $errores["borrado"][] = "El campo 'borrado' no puede estar vacío";
    } elseif ($borrado != 0 && $borrado != 1) {
        $errores["borrado"][] = "El campo 'borrado' debe ser 0 o 1";
    }
    $datos["borrado"] = $borrado;

    // foto
    $foto = trim($_POST["foto"] ?? '');
    if ($foto !== "" && !validaCadena($foto, 255, "")) {
        $errores["foto"][] = "La foto debe tener como máximo 255 caracteres";
    }
    $datos["foto"] = ($foto === "") ? "defecto.png" : $foto;

    // categoría: recibimos la descripción en el select, buscamos su cod_categoria
    $categoriaDesc = trim($_POST["categoria"] ?? '');
    if ($categoriaDesc === '') {
        $errores["categoria"][] = "Debe seleccionar una categoría";
    } else {
        $sentenciaCat = "SELECT cod_categoria FROM categorias WHERE descripcion = '" . $bd->real_escape_string($categoriaDesc) . "' LIMIT 1";
        $consultaCat = $bd->query($sentenciaCat);
        if (!$consultaCat || $consultaCat->num_rows === 0) {
            $errores["categoria"][] = "Categoría no válida";
        } else {
            $filaCat = $consultaCat->fetch_assoc();
            $datos["categoria"] = (int)$filaCat["cod_categoria"];
            $datos["categoria_desc"] = $categoriaDesc;
        }
    }

    // ejecutar UPDATE si no hay errores
    if (empty($errores)) {

        $sentenciaUpd = "UPDATE productos SET
            nombre = '" . $bd->real_escape_string($datos["nombre"]) . "',
            cod_categoria = " . (int)$datos["categoria"] . ",
            fabricante = '" . $bd->real_escape_string($datos["fabricante"]) . "',
            fecha_alta = '" . $bd->real_escape_string($datos["fecha_alta"]) . "',
            unidades = " . (int)$datos["unidades"] . ",
            precio_base = " . (float)$datos["precio_base"] . ",
            iva = " . (int)$datos["iva"] . ",
            precio_iva = " . (float)$datos["precio_iva"] . ",
            precio_venta = " . (float)$datos["precio_venta"] . ",
            foto = '" . $bd->real_escape_string($datos["foto"]) . "'
            WHERE cod_producto = " . (int)$cod_producto;

        if ($bd->query($sentenciaUpd)) {
            header("Location: verProducto.php?id=" . $cod_producto);
            exit;
        } else {
            paginaError("Error al modificar producto: " . $bd->error);
            exit;
        }
    }
}

///////////////////////////////////////////////////////////////////////

// dibuja la plantilla de la vista
inicioCabecera("Tienda");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($datos, $errores, $bd);  // llamo a la vista
finCuerpo();

// **********************************************************

// vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

// vista
function cuerpo($datos, $errores, $bd) {
  formularioModificarProducto($datos, $errores, $bd);
}

function formularioModificarProducto($datos, $errores, $bd) {

    // Mostrar errores si los hay (igual que en usuarios)
    if (!empty($errores)) {
        echo "<div style='color:red'><ul>";
        foreach ($errores as $campo => $lista) {
            foreach ($lista as $error) {
                echo "<li>$error</li>";
            }
        }
        echo "</ul></div>";
    }

    // obtener lista de categorias
    $sentencia = "SELECT descripcion FROM categorias ORDER BY descripcion";
    $consulta = $bd->query($sentencia);
    $categorias = [];
    while($fila = $consulta->fetch_assoc()) {
        $categorias[] = $fila["descripcion"];
    }
    ?>

    <form action="" method="post">

        <label>Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?= $datos["nombre"] ?>">
        <br>

        <label>Fabricante:</label>
        <input type="text" name="fabricante" id="fabricante" value="<?= $datos["fabricante"] ?>">
        <br>

        <label>Fecha Alta:</label>
        <input type="date" name="fecha_alta" id="fecha_alta" value="<?= $datos["fecha_alta"] ?>">
        <br>

        <label>Unidades:</label>
        <input type="text" name="unidades" id="unidades" value="<?= $datos["unidades"] ?>">
        <br>

        <label>Precio Base:</label>
        <input type="text" name="precio_base" id="precio_base" value="<?= $datos["precio_base"] ?>">
        <br>

        <label>IVA:</label>
        <input type="text" name="iva" id="iva" value="<?= $datos["iva"] ?>">
        <br>

        <label>Precio IVA:</label>
        <input type="text" name="precio_iva" id="precio_iva" value="<?= $datos["precio_iva"] ?>">
        <br>

        <label>Precio Venta:</label>
        <input type="text" name="precio_venta" id="precio_venta" value="<?= $datos["precio_venta"] ?>">
        <br>

        <label>Foto:</label>
        <input type="text" name="foto" id="foto" value="<?= $datos["foto"] ?>">
        <br>

        <label>Categoría:</label>
        <select name="categoria">
            <?php 
            foreach($categorias as $cat) {
                $selected = ($cat == $datos["descripcion"]) ? "selected" : "";
                echo "<option value='$cat' $selected>$cat</option>";
            }
            ?>
        </select>
        <br>

        <label>Borrado (0-no // 1-sí):</label>
        <input type="text" name="borrado" id="borrado" value="<?= $datos["borrado"] ?>">
        <br>

        <input type="submit" value="Guardar cambios" name="subir">
        <br>

        <a href="index.php">Volver al inicio</a>

    </form>

    <?php
}
