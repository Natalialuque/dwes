<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Mis compras" => "/aplicacion/usuarios/compras.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

// cerrar sesión
if(isset($_POST["cerrarSesion"])) $acceso->quitarRegistroUsuario();

// recoger nick
$nick = $_GET["nick"];

// comprobar si existe el usuario
$sentencia = "SELECT * FROM usuarios WHERE nick = '{$nick}'";
$consulta = $bd->query($sentencia);

if ($consulta->num_rows === 0) {
    paginaError("No existe el usuario introducido");
    exit;
}

$usuario = $consulta->fetch_assoc();


///////////////////////////////////////////////////////
inicioCabecera("2DAW TIENDA");
cabecera();
finCabecera();

inicioCuerpo("2DAW TIENDA");
cuerpo($usuario, $bd);
finCuerpo();


//////////////////////////////////////////////////////////////
function cabecera() {}

function cuerpo($usuario, $bd)
{
    $codUsuario = (int)$usuario["cod_usuario"];

    ?>
    <h2>Mis compras</h2>

    <div class="compras-lista">
        <h3>Listado de compras</h3>

        <?php
        // listar compras del usuario
        $sqlCompras = "
            SELECT cod_compra, fecha, importe_total
            FROM compras
            WHERE cod_usuario = $codUsuario
            ORDER BY fecha DESC
        ";
        $resCompras = $bd->query($sqlCompras);

        if ($resCompras->num_rows == 0) {
            ?>
            <p>No has realizado ninguna compra.</p>
            <?php
        } else {
            ?>
            <ul>
                <?php while ($c = $resCompras->fetch_assoc()) { ?>
                    <li>
                        <a href="?nick=<?= $usuario["nick"] ?>&compra=<?= $c["cod_compra"] ?>">
                            Compra <?= $c["fecha"] ?>, Total: <?= $c["importe_total"] ?> €
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php
        }
        ?>
    </div>

    <?php
    // mostrar detalle de compra si se ha seleccionado una
    if (isset($_GET["compra"])) {
        mostrarDetalleCompra((int)$_GET["compra"], $codUsuario, $bd);
    }
}


function mostrarDetalleCompra($codCompra, $codUsuario, $bd)
{
    // datos de la compra
    $sqlCompra = "
        SELECT *
        FROM compras
        WHERE cod_compra = $codCompra
        AND cod_usuario = $codUsuario
    ";
    $resCompra = $bd->query($sqlCompra);

    if ($resCompra->num_rows == 0) {
        ?>
        <p>No existe esa compra o no pertenece al usuario.</p>
        <?php
        return;
    }

    $compra = $resCompra->fetch_assoc();
    ?>

    <div class="detalle-compra">
        <h3>Detalle de la compra #<?= $codCompra ?></h3>

        <p>Fecha: <?= $compra["fecha"] ?></p>
        <p>Forma de pago: <?= $compra["modo_pago"] ?></p>
        <p>Total: <?= $compra["importe_total"] ?> €</p>

        <h4>Productos</h4>

        <?php
        // líneas de la compra
        $sqlLineas = "
            SELECT cl.*, p.nombre
            FROM compras_lineas cl
            JOIN productos p ON p.cod_producto = cl.cod_producto
            WHERE cl.cod_compra = $codCompra
            ORDER BY cl.orden
        ";
        $resLineas = $bd->query($sqlLineas);

        if ($resLineas->num_rows == 0) {
            ?>
            <p>No hay líneas en esta compra.</p>
            <?php
        } else {
            ?>
            <ul>
                <?php while ($l = $resLineas->fetch_assoc()) { ?>
                    <li>
                        <?= $l["nombre"] ?><br>
                        <?= $l["unidades"] ?> ud<br>
                        <?= $l["precio_unidad"] ?> €<br>
                        Total línea: <?= $l["importe_total"] ?> €
                    </li>
                <?php } ?>
            </ul>
            <?php
        }
        ?>
    </div>

    <?php
}
?>
