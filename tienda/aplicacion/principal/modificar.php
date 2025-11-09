<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once("/web/sitios/dwes/tienda/aplicacion/principal/almacendedatos.php");

// controlador
$ubicacion = [
    "Index Principal" => "/aplicacion/principal/index.php",
    "formulario" => "",
];
$GLOBALS['ubicacion'] = $ubicacion;

$indice = $_GET['indice'] ?? null;
$mueble = $muebles[$indice] ?? null;
$errores = [];
$exito = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $mueble) {
    $tipo = get_class($mueble);
    $aux = clone $mueble;

    if (!$aux->setNombre($_POST['nombre'])) $errores[] = "Nombre inválido";
    if (!$aux->setPrecio((float)$_POST['precio'])) $errores[] = "Precio inválido";

    $material = $_POST['material'] ?? '';
    if (!in_array($material, mueblebase::MATERIALES_POSIBLES)) {
        $errores[] = "Material no válido";
    }

    if ($tipo === 'muebletradicional') {
        $serie = $_POST['serie'] ?? '';
        if (strlen($serie) > 10 || $serie === '') {
            $errores[] = "Serie inválida";
        }
    }

    if ($tipo === 'mueblereciclado') {
        $porcentaje = (float)($_POST['porcentaje'] ?? 0);
        if ($porcentaje < 0 || $porcentaje > 100) {
            $errores[] = "Porcentaje reciclado fuera de rango";
        }
    }

    if (empty($errores)) {
        $mueble->setNombre($_POST['nombre']);
        $mueble->setPrecio((float)$_POST['precio']);
        $mueble->setMaterialPrincipal(array_search($material, mueblebase::MATERIALES_POSIBLES));

        if ($tipo === 'muebletradicional') {
            $mueble->setSerie($_POST['serie']);
        } elseif ($tipo === 'mueblereciclado') {
            $mueble->setPorcentajeReciclado($porcentaje);
        }

        $exito = true;
    }
}

// vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo();
finCuerpo();

function cabecera() {
}

function cuerpo() {
    global $mueble, $indice, $errores, $exito;

    if (!$mueble) {
        echo "<p>No se ha encontrado el mueble con índice $indice.</p>";
        return;
    }

    if ($exito) {
        echo "<h3>Mueble actualizado correctamente</h3>";
        echo "<pre>$mueble</pre>"; 
        return;
    }

    if (!empty($errores)) {
        echo "<h4>Errores:</h4><ul>";
        foreach ($errores as $e) {
            echo "<li>$e</li>";
        }
        echo "</ul>";
    }

    $tipo = get_class($mueble);
    ?>

    <form method="post">
        <label>Nombre: <input type="text" name="nombre" value="<?= $mueble->getNombre() ?>"></label><br><br>
        <label>Precio: <input type="number" step="0.01" name="precio" value="<?= $mueble->getPrecio() ?>"></label><br><br>

        <label>Material:
            <select name="material">
                <?php foreach (mueblebase::MATERIALES_POSIBLES as $id => $mat): ?>
                    <option value="<?= $mat ?>" <?= $mueble->getMaterialDescripcion() === $mat ? 'selected' : '' ?>><?= $mat ?></option>
                <?php endforeach; ?>
            </select>
        </label><br><br>

        <?php if ($tipo === 'muebletradicional'): ?>
            <label>Serie: <input type="text" name="serie" value="<?= $mueble->getSerie() ?>"></label><br><br>
        <?php elseif ($tipo === 'mueblereciclado'): ?>
            <label>Porcentaje reciclado: <input type="number" step="0.1" name="porcentaje" value="<?= $mueble->getPorcentajeReciclado() ?>"></label><br><br>
        <?php endif; ?>

        <input type="submit" value="Guardar cambios">
    </form>

    <?php
}
?>

