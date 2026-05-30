
<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

if (!isset($_GET["id"])) {
    echo "parametros incorrectos";
    exit;
}

$id = $_GET["id"];

if (!isset($PRO[$id])) {
    echo "No se encuentra la coleccion";
    exit;
}

// Cabeceras de descarga
header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=coleciones.txt");

// Contenido del fichero
$otras = $COL[$id]->dameLibros();
echo $COL[$id] . " Otras Colecciones: " . $otras . PHP_EOL;

exit;