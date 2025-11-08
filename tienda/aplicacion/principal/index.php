<<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once("/web/sitios/dwes/tienda/aplicacion/principal/almacendedatos.php");
//controlador
$ubicacion = [
    "Index Principal" => "/index.php",
    "Relación :" => "/aplicacion/principal/pruebas.php",
];
$GLOBALS['ubicacion'] = $ubicacion;


///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo();  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo() {
    global $muebles;
?>

<!-- 🔹 Tabla con todos los muebles -->
<h2>Listado de Muebles</h2>
<table border="1" cellpadding="4">
    <tr>
        <th>Índice</th>
        <th>Tipo</th>
        <th>Nombre</th>
        <th>Fabricante</th>
        <th>Material</th>
        <th>Precio</th>
        <th>Resumen</th>
    </tr>
    <?php foreach ($muebles as $indice => $mueble): ?>
        <tr>
            <td><?= $indice ?></td>
            <td><?= get_class($mueble) ?></td>
            <td><?= $mueble->getNombre() ?></td>
            <td><?= $mueble->getFabricante() ?></td>
            <td><?= $mueble->getMaterialDescripcion() ?></td>
            <td><?= $mueble->getPrecio() ?> €</td>
            <td><?= substr($mueble->__toString(), 0, 100) ?>...</td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- 🔹 Formulario con dos botones -->
<h2>Acciones sobre Mueble</h2>
<form method="post" action="">
    <label for="indice">Selecciona índice de mueble:</label>
    <select name="indice" id="indice">
        <?php foreach ($muebles as $i => $m): ?>
            <option value="<?= $i ?>"><?= $i ?> - <?= $m->getNombre() ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <input type="submit" name="mostrar" value="Mostrar Mueble">
    <input type="submit" name="modificar" value="Modificar Mueble">
</form>

<!-- 🔹 Mostrar propiedades del mueble seleccionado -->
<?php
if (isset($_POST['mostrar']) && isset($_POST['indice'])) {
    $i = $_POST['indice'];
    if (isset($muebles[$i])) {
        $mueble = $muebles[$i];
        echo "<h3>Propiedades del mueble $i</h3><ul>";
        $valor = null;
        foreach ($mueble->dameListaPropiedades() as $prop) {
            if ($mueble->damePropiedad($prop, 1, $valor)) {
                echo "<li><strong>$prop:</strong> $valor</li>";
            }
        }
        echo "</ul>";
    }
}
?>

<!-- 🔹 Redirección a formulario de modificación -->
<?php
if (isset($_POST['modificar']) && isset($_POST['indice'])) {
    $i = $_POST['indice'];
    echo "<script>window.open('modificar.php?indice=$i', '_blank');</script>";
}
?>

<?php
}

?>