
 <?php
include_once(dirname(__FILE__) . "/cabecera.php");

$ubicacion = [
    "Inicio" => "/index.php",
];
$GLOBALS['ubicacion'] = $ubicacion;

// cerrar sesión
if(isset($_POST["cerrarSesion"])) $acceso->quitarRegistroUsuario();


// obtener productos
$sentencia = "SELECT * FROM productos";
$consulta = $bd->query($sentencia);

// añadir producto a la cesta
if (isset($_POST["compra"])) {

    if (!isset($_SESSION["cesta"])) {
        $_SESSION["cesta"] = [];
    }

    $_SESSION["cesta"][] = $_POST["producto_id"];

    header("Location: /aplicacion/productos/cesta.php");
    exit;
}

/////////////////////////////////
inicioCabecera("TIENDA");
cabecera();
finCabecera();

inicioCuerpo("2DAW TIENDA");
cuerpo($consulta, $acceso);
finCuerpo();


///////////////////////////////////////////
function cabecera() {}

function cuerpo($consulta, $acceso)
{
    ?>
    <div class="productosAll">
        <?php while ($fila = $consulta->fetch_assoc()) { ?>
            <div class="producto">

                <p><?= $fila["nombre"] ?></p>
                <p><?= $fila["fabricante"] ?></p>
                <p id="precio"><?= $fila["precio_venta"] ?></p>

                <?php if ($acceso->puedePermiso(8)) { ?>
                    <form method="POST">
                        <input type="hidden" name="producto_id" value="<?= $fila["cod_producto"] ?>">
                        <button name="compra" class="compra">Comprar</button>
                    </form>
                <?php } ?>

            </div>
        <?php } ?>
    </div>
    <?php
}
?>
