
<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

if (!isset($_GET["id"])) {
    echo "parametros incorrectos";
    exit;
}

$id = $_GET["id"];

if (!isset($PRO[$id])) {
    echo "No se encuentra el Proyecto";
    exit;
}

// Cabeceras de descarga
header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=proyectos.txt");

// Contenido del fichero
$otras = $PRO[$id]->getDescripcionOtras();
echo $PRO[$id] . " Otras propiedades: " . $otras . PHP_EOL;

exit;