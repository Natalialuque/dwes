<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Cesta"  => "/aplicacion/productos/cesta.php"
];
$GLOBALS["ubicacion"] = $ubicacion;

// cerrar sesión
if (isset($_POST["cerrarSesion"])) {
    $acceso->quitarRegistroUsuario();
    header("Location: /index.php");
    exit;
}

// recoger ids de la cesta
$ids = $_SESSION["cesta"] ?? [];

// quitar producto
if (isset($_POST["quitar"])) {
    $idProducto = $_POST["producto_id"];
    if (($clave = array_search($idProducto, $_SESSION["cesta"])) !== false) {
        unset($_SESSION["cesta"][$clave]);
    }
    header("Location: cesta.php");
    exit;
}

// FINALIZAR COMPRA
if (isset($_POST["finalizar"])) {

    if (empty($_SESSION["cesta"])) {
        header("Location: cesta.php");
        exit;
    }

    $formaPago = $_POST["pago"];
    $datosPago = $_POST["datos_pago"];

    // obtener cod_usuario
    $nick = $acceso->getNick();
    $nickEsc = $bd->real_escape_string($nick);

    $sqlUsuario = "SELECT cod_usuario FROM usuarios WHERE nick = '$nickEsc'";
    $resUsuario = $bd->query($sqlUsuario);
    $filaUsuario = $resUsuario->fetch_assoc();
    $codUsuario = (int)$filaUsuario["cod_usuario"];

    // calcular importes
    $importe_base = 0;
    $importe_iva = 0;
    $importe_total = 0;

    foreach ($ids as $idProd) {
        $idProd = (int)$idProd;

        $sqlProd = "SELECT unidades, precio_base, precio_iva, precio_venta 
                    FROM productos WHERE cod_producto = $idProd";
        $resProd = $bd->query($sqlProd);
        $filaProd = $resProd->fetch_assoc();

        if ($filaProd["unidades"] < 1) {
            ?>
            <h2>Error: no hay unidades suficientes del producto <?= $idProd ?></h2>
            <?php
            exit;
        }

        $importe_base  += $filaProd["precio_base"];
        $importe_iva   += $filaProd["precio_iva"];
        $importe_total += $filaProd["precio_venta"];
    }

    // crear compra
    $formaPagoEsc = $bd->real_escape_string($formaPago);
    $datosPagoEsc = $bd->real_escape_string($datosPago);

    $sqlCompra = "
        INSERT INTO compras (cod_usuario, fecha, modo_pago, datos_pago, importe_base, importe_iva, importe_total)
        VALUES ($codUsuario, NOW(), '$formaPagoEsc', '$datosPagoEsc', $importe_base, $importe_iva, $importe_total)
    ";
    $bd->query($sqlCompra);
    $codCompra = $bd->insert_id;

    // insertar líneas y actualizar stock
    $orden = 1;
    foreach ($ids as $idProd) {
        $idProd = (int)$idProd;

        $sqlProd = "SELECT precio_base, precio_iva, precio_venta, iva 
                    FROM productos WHERE cod_producto = $idProd";
        $resProd = $bd->query($sqlProd);
        $filaProd = $resProd->fetch_assoc();

        $sqlLinea = "
            INSERT INTO compras_lineas 
            (cod_compra, cod_producto, orden, unidades, precio_unidad, iva, importe_base, importe_iva, importe_total)
            VALUES (
                $codCompra, $idProd, $orden, 1,
                {$filaProd["precio_venta"]},
                {$filaProd["iva"]},
                {$filaProd["precio_base"]},
                {$filaProd["precio_iva"]},
                {$filaProd["precio_venta"]}
            )
        ";
        $bd->query($sqlLinea);

        $sqlUpdate = "
            UPDATE productos SET unidades = unidades - 1
            WHERE cod_producto = $idProd
        ";
        $bd->query($sqlUpdate);

        $orden++;
    }

    $_SESSION["cesta"] = [];

    header("Location: cesta.php?resumen_compra=$codCompra");
    exit;
}


////////////////////////////////////////////////////
inicioCabecera("TIENDA");
cabecera();
finCabecera();

inicioCuerpo("TIENDA");
cuerpo($ids, $bd);
finCuerpo();

//////////////////////////////////////////////////////////////
function cabecera() {}

function cuerpo($ids, $bd)
{
    mostrarCesta($ids, $bd);

    if (isset($_GET["resumen_compra"])) {
        mostrarResumenCompra((int)$_GET["resumen_compra"], $bd);
    }
}


function mostrarCesta($ids, $bd)
{
    ?>
    <div class="productosAll">
    <?php
    if (!empty($ids)) {

        foreach ($ids as $id) {

            $sentencia = "SELECT * FROM productos WHERE cod_producto = $id";
            $consulta = $bd->query($sentencia);

            if ($consulta && $fila = $consulta->fetch_assoc()) {
                ?>
                <div class="producto">

                    <p><?= $fila["nombre"] ?></p>

                    <label id="carac">Precio:</label>
                    <p><?= $fila["precio_venta"] ?></p>

                    <label id="carac">Unidades disponibles:</label>
                    <p><?= $fila["unidades"] ?></p>

                    <form method="POST">
                        <input type="hidden" name="producto_id" value="<?= $fila["cod_producto"] ?>">
                        <button name="quitar" class="quitar">Quitar producto</button>
                    </form>

                </div>
                <?php
            }
        }

        mostrarFormularioPago();
    }
    ?>
    </div>
    <?php
}


function mostrarFormularioPago()
{
    ?>
    <div class="pago">
        <h3>Forma de pago</h3>

        <form method="POST">

            <label>
                <input type="radio" name="pago" value="tarjeta" required> Tarjeta
            </label><br>

            <label>
                <input type="radio" name="pago" value="transferencia" required> Transferencia
            </label><br><br>

            <label>Número de tarjeta / cuenta:</label><br>
            <input type="text" name="datos_pago" required><br><br>

            <button name="finalizar" class="finalizar">Finalizar compra</button>

        </form>
    </div>
    <?php
}


function mostrarResumenCompra($codCompra, $bd)
{
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
            <p>Importe total: <?= $compra["importe_total"] ?></p>

            <h3>Productos</h3>

            <?php
            $sqlLineas = "
                SELECT *
                FROM compras_lineas cl
                JOIN productos p ON p.cod_producto = cl.cod_producto
                WHERE cl.cod_compra = $codCompra
                ORDER BY cl.orden
            ";
            $resLineas = $bd->query($sqlLineas);

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
            ?>

        </div>
        <?php
    }
}
?>
