<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Resumen Compra" => "/aplicacion/productos/cesta.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

// cerrar sesión
if (isset($_POST["cerrarSesion"])) {
    $acceso->quitarRegistroUsuario();
    header("Location: /index.php");
    exit;
}

////////////////////////////////////////////////////
inicioCabecera("TIENDA");
cabecera();
finCabecera();

inicioCuerpo("TIENDA");
cuerpo($bd);
finCuerpo();


///////////////////////////////////////////////////////////////////
function cabecera() {}

function cuerpo($bd)
{
    if (isset($_GET["resumen_compra"])) {
        $codCompra = (int)$_GET["resumen_compra"];
        mostrarResumenCompra($codCompra, $bd);
    }
}


function mostrarResumenCompra($codCompra, $bd)
{
    // obtener datos de la compra
    $sqlCompra = "
        SELECT c.fecha, c.importe_base, c.importe_iva, c.importe_total,
               c.modo_pago, c.datos_pago, u.nick
        FROM compras c
        JOIN usuarios u ON u.cod_usuario = c.cod_usuario
        WHERE c.cod_compra = $codCompra
    ";
    $resCompra = $bd->query($sqlCompra);

    if ($resCompra && $compra = $resCompra->fetch_assoc()) {
        ?>
        <div class="resumen-compra">

            <h2>Resumen de la compra</h2>

            <p>Usuario: <?= $compra["nick"] ?></p>
            <p>Fecha: <?= $compra["fecha"] ?></p>
            <p>Forma de pago: <?= $compra["modo_pago"] ?></p>
            <p>Importe base: <?= $compra["importe_base"] ?></p>
            <p>Importe IVA: <?= $compra["importe_iva"] ?></p>
            <p>Importe total: <?= $compra["importe_total"] ?></p>

            <h3>Productos</h3>

            <?php
            // obtener líneas de compra
            $sqlLineas = "
                SELECT cl.orden, cl.unidades, cl.precio_unidad, cl.importe_total, p.nombre
                FROM compras_lineas cl
                JOIN productos p ON p.cod_producto = cl.cod_producto
                WHERE cl.cod_compra = $codCompra
                ORDER BY cl.orden
            ";
            $resLineas = $bd->query($sqlLineas);

            if ($resLineas) {
                while ($l = $resLineas->fetch_assoc()) {
                    ?>
                    <div class="linea-compra">
                        <p><?= $l["nombre"] ?></p>
                        <p>Unidades: <?= $l["unidades"] ?></p>
                        <p>Precio unidad: <?= $l["precio_unidad"] ?></p>
                        <p>Importe línea: <?= $l["importe_total"] ?></p>
                    </div>
                    <?php
                }
            }
            ?>

        </div>
        <?php
    }
}
?>
