<?php
include_once(dirname(__FILE__) . "/cabecera.php");

$BENEFI = $_SESSION["BENEFI"] ?? [];
$mensaje = "";

$ubicacion = [
    "pagina principal" => "/index.php",
];

if (isset($_POST["loguearse"])) {
    $contador = isset($_COOKIE["contadorLogin"]) ? intval($_COOKIE["contadorLogin"]) : 1;
    $contador++;
    setcookie("contadorLogin", (string)$contador, time() + 3600 * 24 * 30, "/");

    if ($contador % 2 == 0) {
        $acceso->registrarUsuario("PAR", "Usuario PAR", [1 => true, 2 => false]);
    } else {
        $acceso->registrarUsuario("IMPAR", "Usuario IMPAR", [1 => false, 2 => true]);
    }
}

if (isset($_POST["salir"])) {
    $acceso->quitarRegistroUsuario();
}

if (isset($_POST["cargaFichero"])) {
    $fichero = RUTABASE . "/imagenes/a_incorporar.txt";

    if (cargarBeneficiariosDesdeFichero($fichero, $BENEFI)) {
        $_SESSION["BENEFI"] = $BENEFI;
        $mensaje = "Fichero cargado correctamente.";
    } else {
        $mensaje = "No se ha podido cargar ningun beneficiario desde el fichero.";
    }
}

inicioCabecera("Bonos Navidenos");
cabecera();
finCabecera();
inicioCuerpo("Bonos Navidenos");
cuerpo($BENEFI, $acceso, $mensaje);
finCuerpo();

function cabecera(): void
{
}

function cuerpo(array $BENEFI, Acceso $acceso, string $mensaje): void
{
    formularioLogin($acceso);

    if ($mensaje !== "") {
        echo "<p><strong>" . htmlspecialchars($mensaje) . "</strong></p>";
    }

    mostrarBeneficiarios($BENEFI, $acceso);
    formularioCarga();
    botonNuevoBeneficiario();
    formularioExportar($BENEFI);
}

function formularioLogin(Acceso $acceso): void
{
?>
    <form method="post">
        <?php if ($acceso->hayUsuario()) { ?>
            <span>Usuario registrado: <?= htmlspecialchars($acceso->getNombre()) ?></span>
            <input type="submit" name="salir" value="Cerrar sesion">
        <?php } else { ?>
            <span>No hay usuario registrado</span>
        <?php } ?>
        <input type="submit" name="loguearse" value="Loguearse">
    </form>
    <hr>
<?php
}

function mostrarBeneficiarios(array $BENEFI, Acceso $acceso): void
{
    echo "<h2>Mostrar Beneficiarios</h2>";

    if (!$acceso->hayUsuario() || !$acceso->puedePermiso(2)) {
        echo "<p>sin permiso para consultar los datos</p>";
        return;
    }

    echo "<textarea rows='16' cols='100'>";
    foreach ($BENEFI as $beneficiario) {
        echo $beneficiario . PHP_EOL;

        foreach ($beneficiario->getBonos() as $clave => $valor) {
            echo "  " . $clave . ": " . $valor . PHP_EOL;
        }

        echo PHP_EOL;
    }
    echo "</textarea>";
}

function formularioCarga(): void
{
?>
    <hr>
    <form method="post">
        <input type="submit" name="cargaFichero" value="Cargar Fichero">
    </form>
<?php
}

function botonNuevoBeneficiario(): void
{
?>
    <form method="get" action="/aplicacion/beneficiarios/nuevo.php">
        <input type="submit" value="Nuevo beneficiario">
    </form>
<?php
}

function formularioExportar(array $BENEFI): void
{
?>
    <hr>
    <form method="get" action="/aplicacion/beneficiarios/descarga.php">
        <label for="id">Exportar beneficiario:</label>
        <select name="id" id="id">
            <?php foreach ($BENEFI as $indice => $beneficiario) { ?>
                <option value="<?= $indice ?>">
                    <?= htmlspecialchars($beneficiario->getNombre() . " - " . $beneficiario->getFechaNacimiento()) ?>
                </option>
            <?php } ?>
            <option value="noExiste">Beneficiario inexistente</option>
        </select>
        <input type="submit" name="exportar" value="Exportar">
    </form>
<?php
}

function cargarBeneficiariosDesdeFichero(string $nombreFichero, array &$datos): bool
{
    if (!is_file($nombreFichero)) {
        return false;
    }

    $lineas = file($nombreFichero, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $insertados = 0;

    foreach ($lineas as $linea) {
        $partes = preg_split("/[;|,]/", trim($linea));

        if ($partes === false || count($partes) < 4) {
            continue;
        }

        try {
            $beneficiario = new Beneficiario(
                trim($partes[0]),
                trim($partes[1]),
                intval($partes[2]),
                trim($partes[3])
            );

            $bonos = array_slice($partes, 4);
            if (count($bonos) >= 2) {
                $nbonos = 0;
                $beneficiario->aniadeBonos($nbonos, trim($bonos[0]), trim($bonos[1]), ...array_map("trim", array_slice($bonos, 2)));
            }

            $datos[] = $beneficiario;
            $insertados++;
        } catch (Exception $e) {
        }
    }

    return $insertados > 0;
}
