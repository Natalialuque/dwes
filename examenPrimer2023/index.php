<?php
include_once(dirname(__FILE__) . "/cabecera.php");

// CONTROLADOR
// Recuperamos siempre el array de beneficiarios desde sesion para trabajar con los datos actuales.
$BENEFI = $_SESSION["BENEFI"] ?? [];
$mensaje = "";

// Barra de ubicacion que usa la plantilla para indicar donde estamos.
$ubicacion = [
    "pagina principal" => "index.php",
];

/*
 * Boton de logueo.
 * El examen pide una cookie que vaya cambiando el usuario entre PAR e IMPAR.
 */
if (!isset($_COOKIE["contadorLogin"])) {
    setcookie("contadorLogin", 1, time() + 3600, "/");
    $_COOKIE["contadorLogin"] = 1;
}

if (isset($_POST["usuario"])) {
    // Incrementamos la cookie cada vez que se pulsa el boton de inicio de sesion.
    $vecesInicio = intval($_COOKIE["contadorLogin"]) + 1;
    setcookie("contadorLogin", $vecesInicio, time() + 3600, "/");
    $_COOKIE["contadorLogin"] = $vecesInicio;

    // Si el contador es par se registra PAR con permiso 1.
    if ($vecesInicio % 2 == 0) {
        $acceso->registrarUsuario("PAR", "Usuario PAR", [1 => true, 2 => false]);
    } else {
        // Si el contador es impar se registra IMPAR con permiso 2.
        $acceso->registrarUsuario("IMPAR", "Usuario IMPAR", [1 => false, 2 => true]);
    }
}

// Boton para cerrar el usuario actual sin borrar los beneficiarios guardados en sesion.
if (isset($_POST["salir"])) {
    $acceso->quitarRegistroUsuario();
}

/*
 * Boton de carga de fichero.
 * Carga los beneficiarios desde /imagenes/a_incorporar.txt y los anade al array actual.
 */
if (isset($_POST["cargaFichero"])) {
    $beneficiariosCargados = [];

    if (cargarBeneficiariosDesdeFichero("a_incorporar.txt", $beneficiariosCargados)) {
        foreach ($beneficiariosCargados as $beneficiario) {
            array_push($BENEFI, $beneficiario);
        }

        $_SESSION["BENEFI"] = $BENEFI;
        $mensaje = "Fichero cargado correctamente.";
    } else {
        $mensaje = "No se ha podido cargar ningun beneficiario desde el fichero.";
    }
}

/*
 * Boton nuevo.
 * Redirige a la pagina de alta, siguiendo el formato del ejemplo del profesor.
 */
if (isset($_POST["nuevo"])) {
    $_SESSION["BENEFI"] = $BENEFI;
    header("Location: aplicacion/beneficiarios/nuevo.php");
    exit;
}

/*
 * Boton exportar.
 * Comprueba que el beneficiario elegido exista y llama a la pagina de descarga.
 */
if (isset($_POST["exportar"])) {
    $id = $_POST["BeneficiariosDisponibles"] ?? "noExiste";

    if ($id === "noExiste" || !isset($BENEFI[$id])) {
        paginaError("El beneficiario seleccionado no existe");
        exit;
    }

    header("Location: aplicacion/beneficiarios/descarga.php?id=" . $id);
    exit;
}

// DIBUJO DE LA PLANTILLA
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("2DAW APLICACION");
cuerpo($BENEFI, $acceso, $mensaje);
finCuerpo();

// VISTA
function cabecera(): void
{
}

// Funcion principal de la vista. Desde aqui llamamos a todos los formularios.
function cuerpo(array $BENEFI, object $acceso, string $mensaje): void
{
    formularioLogin($acceso);

    if ($mensaje !== "") {
        echo "<p><strong>" . htmlspecialchars($mensaje) . "</strong></p>";
    }

    mostrarBeneficiarios($acceso);
    cargaFichero();
    formularioAcciones($BENEFI);
}

/**
 * Formulario para iniciar y cerrar sesion.
 * Muestra tambien el usuario conectado, como en la plantilla del profesor.
 */
function formularioLogin(object $acceso): void
{
?>
    <form method="post">
        <?php
        if ($acceso->hayUsuario()) {
            echo "<p>Usuario conectado: " . htmlspecialchars($acceso->getNick()) . "</p>";
        } else {
            echo "<p>No hay usuario conectado</p>";
        }
        ?>

        <input type="submit" value="inicio Sesion" name="usuario">

        <?php if ($acceso->hayUsuario()) { ?>
            <label for="salir">Salir de la sesion actual: &nbsp;</label>
            <input type="submit" name="salir" id="salir" value="salir">
            <br><br>
            <hr>
            <label>Conectado actualmente como: <?php echo htmlspecialchars($acceso->getNick()); ?></label>
        <?php } ?>
    </form>
<?php
}

/**
 * Boton de carga de fichero.
 * Este formulario solo manda el POST; el controlador de arriba hace la carga real.
 */
function cargaFichero(): void
{
?>
    <hr>
    <form method="post">
        <label for="cargaFichero">Cargar fichero guardado: &nbsp;</label>
        <input type="submit" value="Cargar fichero" name="cargaFichero" id="cargaFichero">
    </form>
<?php
}

/**
 * Funcion para cargar beneficiarios desde fichero.
 * El formato usado es: nombre;nif;reduccion;fecha;bono;importe;bono;importe
 */
function cargarBeneficiariosDesdeFichero(string $nombreFichero, array &$datos): bool
{
    // Construimos la ruta completa dentro de la carpeta /imagenes, tal como dice el examen.
    $ruta = RUTABASE . "/imagenes/" . $nombreFichero;

    if (!file_exists($ruta)) {
        return false;
    }

    // Leemos el fichero ignorando lineas vacias.
    $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lineas === false) {
        return false;
    }

    $insertados = 0;

    foreach ($lineas as $linea) {
        $linea = trim($linea);

        // Permitimos comentarios en el fichero de carga para explicar el formato.
        if ($linea === "" || mb_substr($linea, 0, 1) === "#") {
            continue;
        }

        // Aceptamos separadores ; , o | para que el fichero sea facil de corregir.
        $partes = preg_split("/[;|,]/", $linea);

        if ($partes === false || count($partes) < 4) {
            continue;
        }

        try {
            // Creamos el beneficiario con los cuatro primeros datos obligatorios.
            $beneficiario = new Beneficiario(
                trim($partes[0]),
                trim($partes[1]),
                intval($partes[2]),
                trim($partes[3])
            );

            // El resto de posiciones van por parejas: numero de bono e importe.
            $bonos = array_slice($partes, 4);
            if (count($bonos) >= 2) {
                $nbonos = 0;
                $beneficiario->aniadeBonos(
                    $nbonos,
                    trim($bonos[0]),
                    trim($bonos[1]),
                    ...array_map("trim", array_slice($bonos, 2))
                );
            }

            $datos[] = $beneficiario;
            $insertados++;
        } catch (Exception $e) {
            // Si una linea lanza excepcion, la ignoramos y seguimos con las demas.
        }
    }

    return $insertados > 0;
}

/**
 * Muestra los beneficiarios en un textarea.
 * Solo se muestran si hay usuario conectado y tiene permiso 2.
 */
function mostrarBeneficiarios(object $acceso): void
{
    $beneficiarios = $_SESSION["BENEFI"] ?? [];

    echo "<h3>Mostrar Beneficiarios</h3>";

    if (!$acceso->hayUsuario() || !$acceso->puedePermiso(2)) {
        echo "<p>sin permiso para consultar los datos</p>";
        return;
    }
?>
    <textarea cols="100" rows="16"><?php
        foreach ($beneficiarios as $beneficiario) {
            // El beneficiario se muestra usando su metodo __toString.
            echo $beneficiario . "\n";

            // Recorremos los bonos con foreach, porque Bonos implementa Iterator.
            foreach ($beneficiario->getBonos() as $clave => $valor) {
                echo "$clave: $valor\n";
            }

            echo "---------------------------------\n";
        }
    ?></textarea>
<?php
}

/**
 * Formulario de acciones con combo y botones.
 * Sigue la estructura del formularioAcciones del ejemplo del profesor.
 */
function formularioAcciones(array $BENEFI): void
{
?>
    <hr>
    <form action="" method="post">
        <label for="BeneficiariosDisponibles">Elige beneficiario:</label>
        <select name="BeneficiariosDisponibles" id="BeneficiariosDisponibles">
            <option value="noExiste">Sin seleccionar</option>

            <?php
            foreach ($BENEFI as $key => $beneficiario) {
                $texto = $beneficiario->getNombre() . " - " . $beneficiario->getFechaNacimiento();
                echo "<option value='$key'>" . htmlspecialchars($texto) . "</option>";
            }
            ?>
        </select>

        <br><br>

        <input type="submit" class="boton" name="exportar" value="Exportar">
        <input type="submit" class="boton" name="nuevo" value="Nuevo">
    </form>
<?php
}
