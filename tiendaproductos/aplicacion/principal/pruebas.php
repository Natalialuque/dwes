<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Relación 5:" => "/aplicacion/principal/pruebas.php",
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo();
finCuerpo();

function cabecera() {}

function cuerpo() {
?>
<h2>Creación de clase MuebleReciclado</h2> 
<?php 
    $carac = new caracteristicas("ancho", 120, "alto", 80, "largo", 60);
    $muebleReciclado = new mueblereciclado("Natalia", $carac, 1, "ikea", "España", 2025, "09/04/2025", "19/12/2025", 45.5, 26.4);

    // Añadir características
    $muebleReciclado->anadir("color", "verde", "estilo", "vintage");

    // Mostrar objeto
    echo "<pre>$muebleReciclado</pre>";

    // Mostrar características exportadas
    echo "<h4>Características exportadas:</h4>";
    echo "<pre>" . $muebleReciclado->exportarCaracteristicas() . "</pre>";

    // Probar dameListaPropiedades
    echo "<h4>Propiedades disponibles:</h4><ul>";
    foreach ($muebleReciclado->dameListaPropiedades() as $prop) {
        echo "<li>$prop</li>";
    }
    echo "</ul>";

    // Probar damePropiedad en modo 1
    echo "<h4>Valores de propiedades (modo 1):</h4><ul>";
    foreach ($muebleReciclado->dameListaPropiedades() as $prop) {
        if ($muebleReciclado->damePropiedad($prop, 1, $valor)) {
            echo "<li>$prop: $valor</li>";
        }
    }
    echo "</ul>";

    // Probar puedeCrear
   $numero = 0;
if (mueblebase::puedeCrear($numero)) {
    echo "<p>Se pueden crear $numero muebles más.</p>";
} else {
    echo "<p>No se pueden crear más muebles.</p>";
}

?>

<h2>Creación de clase MuebleTradicional</h2>
<?php
    $carac2 = new caracteristicas("Color", "azul", "estilo", "moderno", "ancho", 250, "largo", 150, "alto", 200, "ningunamas", "si");
    $muebleTradicional = new muebletradicional("Natalia", $carac2, 2, "ike", "España", 2025, "09/04/2025", "19/12/2025", 60.0, 26.4, "A30210");

    echo "<pre>$muebleTradicional</pre>";

    echo "<h4>Características exportadas:</h4>";
    echo "<pre>" . $muebleTradicional->exportarCaracteristicas() . "</pre>";

    echo "<h4>Propiedades disponibles:</h4><ul>";
    foreach ($muebleTradicional->dameListaPropiedades() as $prop) {
        echo "<li>$prop</li>";
    }
    echo "</ul>";

    echo "<h4>Valores de propiedades (modo 1):</h4><ul>";
    foreach ($muebleTradicional->dameListaPropiedades() as $prop) {
        if ($muebleTradicional->damePropiedad($prop, 1, $valor)) {
            echo "<li>$prop: $valor</li>";
        }
    }
    echo "</ul>";
?>
<?php
}
?>
