<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Recuperamos el array actual de beneficiarios desde sesion.
$BENEFI = $_SESSION["BENEFI"] ?? [];

// Array donde guardaremos los mensajes de error del formulario.
$errores = [];

// Valores que se muestran en el formulario, para conservar lo escrito si hay errores.
$valores = [
    "nombre" => $_POST["nombre"] ?? "",
    "nif" => $_POST["nif"] ?? "",
    "reduccion" => $_POST["reduccion"] ?? "1",
    "fecha_nacimiento" => $_POST["fecha_nacimiento"] ?? "",
];

// Barra de ubicacion de esta pagina.
$ubicacion = [
    "pagina principal" => "/index.php",
    "nuevo beneficiario" => "/aplicacion/beneficiarios/nuevo.php",
];

// CONTROLADOR: cuando se pulsa guardar, validamos y creamos el beneficiario.
if (isset($_POST["guardar"])) {
    $nombre = trim($_POST["nombre"] ?? "");
    $nif = trim($_POST["nif"] ?? "");
    $reduccion = intval($_POST["reduccion"] ?? 1);
    $fechaNacimiento = trim($_POST["fecha_nacimiento"] ?? "");

    validarFormularioNuevo($nombre, $nif, $reduccion, $fechaNacimiento, $errores);

    if (empty($errores)) {
        try {
            // Si no hay errores, creamos el objeto Beneficiario.
            $beneficiario = new Beneficiario($nombre, $nif, $reduccion, $fechaNacimiento);

            // Lo anadimos al array y lo guardamos en sesion para usarlo desde index.
            $BENEFI[] = $beneficiario;
            $_SESSION["BENEFI"] = $BENEFI;

            // Volvemos a la pagina principal.
            header("Location: /index.php");
            exit;
        } catch (Exception $e) {
            $errores["general"] = $e->getMessage();
        }
    }
}

// DIBUJO DE LA PLANTILLA
inicioCabecera("Nuevo beneficiario");
cabecera();
finCabecera();
inicioCuerpo("Nuevo beneficiario");
cuerpo($errores, $valores);
finCuerpo();

function cabecera(): void
{
}

// Vista principal de la pagina de nuevo beneficiario.
function cuerpo(array $errores, array $valores): void
{
    formularioNuevo($errores, $valores);
}

// Validacion separada para dejar el controlador mas claro.
function validarFormularioNuevo(string &$nombre, string &$nif, int $reduccion, string &$fechaNacimiento, array &$errores): void
{
    // Nombre obligatorio y maximo 30 caracteres.
    if ($nombre === "" || !validaCadena($nombre, 30, "")) {
        $errores["nombre"] = "El nombre es obligatorio y debe tener como maximo 30 caracteres.";
    }

    // NIF en mayusculas y con uno de los dos formatos del enunciado.
    $nif = mb_strtoupper($nif);
    if (!validaExpresion($nif, "/^([0-9]{8}[A-Z]|[A-Z][0-9]{7}[A-Z])$/", "")) {
        $errores["nif"] = "El NIF debe tener formato 99999999A o A9999999A.";
    }

    // La reduccion tiene que ser 1, 2 o 3.
    if (!validaRango($reduccion, [1, 2, 3])) {
        $errores["reduccion"] = "La reduccion debe ser una de las opciones indicadas.";
    }

    // Si se escribe fecha, debe tener formato dd/mm/aaaa y no ser futura.
    if ($fechaNacimiento !== "") {
        if (!validaFecha($fechaNacimiento, "")) {
            $errores["fecha_nacimiento"] = "La fecha debe tener formato dd/mm/aaaa.";
            return;
        }

        $fecha = DateTime::createFromFormat("d/m/Y", $fechaNacimiento);
        $hoy = new DateTime();
        $hoy->setTime(23, 59, 59);

        if ($fecha > $hoy) {
            $errores["fecha_nacimiento"] = "La fecha no puede ser posterior a hoy.";
        }
    }
}

function formularioNuevo(array $errores, array $valores): void
{
    // Si hay errores, se muestran encima del formulario.
    if (!empty($errores)) {
        echo "<div class='error'>";
        foreach ($errores as $error) {
            echo htmlspecialchars($error) . "<br>";
        }
        echo "</div>";
    }
?>
    <!-- Formulario de alta de beneficiario -->
    <form method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($valores["nombre"]) ?>">
        <br>

        <label for="nif">NIF:</label>
        <input type="text" id="nif" name="nif" value="<?= htmlspecialchars($valores["nif"]) ?>">
        <br>

        <label for="fecha_nacimiento">Fecha nacimiento:</label>
        <input type="text" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($valores["fecha_nacimiento"]) ?>">
        <br>

        <label for="reduccion">Reduccion:</label>
        <select id="reduccion" name="reduccion">
            <option value="1" <?= $valores["reduccion"] == "1" ? "selected" : "" ?>>Sin reduccion</option>
            <option value="2" <?= $valores["reduccion"] == "2" ? "selected" : "" ?>>Discapacidad</option>
            <option value="3" <?= $valores["reduccion"] == "3" ? "selected" : "" ?>>Familia numerosa</option>
        </select>
        <br>

        <input type="submit" name="guardar" value="Guardar">
        <a href="/index.php">Volver</a>
    </form>
<?php
}
