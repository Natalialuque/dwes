<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$BENEFI = $_SESSION["BENEFI"] ?? [];
$errores = [];
$valores = [
    "nombre" => $_POST["nombre"] ?? "",
    "nif" => $_POST["nif"] ?? "",
    "reduccion" => $_POST["reduccion"] ?? "1",
    "fecha_nacimiento" => $_POST["fecha_nacimiento"] ?? "",
];

$ubicacion = [
    "pagina principal" => "/index.php",
    "nuevo beneficiario" => "/aplicacion/beneficiarios/nuevo.php",
];

if (isset($_POST["guardar"])) {
    $nombre = trim($_POST["nombre"] ?? "");
    $nif = trim($_POST["nif"] ?? "");
    $reduccion = intval($_POST["reduccion"] ?? 1);
    $fechaNacimiento = trim($_POST["fecha_nacimiento"] ?? "");

    validarFormularioNuevo($nombre, $nif, $reduccion, $fechaNacimiento, $errores);

    if (empty($errores)) {
    try {
        $beneficiario = new Beneficiario($nombre, $nif, $reduccion, $fechaNacimiento);
            $BENEFI[] = $beneficiario;
            $_SESSION["BENEFI"] = $BENEFI;
            header("Location: /index.php");
            exit;
    } catch (Exception $e) {
        $errores["general"] = $e->getMessage();
    }
    }
}

inicioCabecera("Nuevo beneficiario");
cabecera();
finCabecera();
inicioCuerpo("Nuevo beneficiario");
cuerpo($errores, $valores);
finCuerpo();

function cabecera(): void
{
}

function cuerpo(array $errores, array $valores): void
{
    formularioNuevo($errores, $valores);
}

function validarFormularioNuevo(string &$nombre, string &$nif, int $reduccion, string &$fechaNacimiento, array &$errores): void
{
    if ($nombre === "" || !validaCadena($nombre, 30, "")) {
        $errores["nombre"] = "El nombre es obligatorio y debe tener como maximo 30 caracteres.";
    }

    $nif = mb_strtoupper($nif);
    if (!validaExpresion($nif, "/^([0-9]{8}[A-Z]|[A-Z][0-9]{7}[A-Z])$/", "")) {
        $errores["nif"] = "El NIF debe tener formato 99999999A o A9999999A.";
    }

    if (!validaRango($reduccion, [1, 2, 3])) {
        $errores["reduccion"] = "La reduccion debe ser una de las opciones indicadas.";
    }

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
    if (!empty($errores)) {
        echo "<div class='error'>";
        foreach ($errores as $error) {
            echo htmlspecialchars($error) . "<br>";
        }
        echo "</div>";
    }
?>
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
