
<?php

include_once(dirname(__FILE__) . "/../../cabecera.php");



if (!isset($_POST["descargar"])) {
    echo "parametros incorrectos";
    exit;
}
$id = intval($_POST["descargar"]);

if (!isset($PRO[$id])) {
    echo "No se encuentra el Proyecto";
    exit;
}

//creación tipo de imagen y descarga
header("content-type: text/txt");
header("content-disposition: attachment; filename=proyectos.txt");

$otras = $PRO[$id]->getDescripcionOtras();
echo $PRO[$id] . "Otras propiedades:" . $otras . PHP_EOL;
//Volver a la página principal
$dirPrevia = "/index.php";
if (isset($_SESSION) && isset($_SESSION["dir_previa"])) {
    $dirPrevia = $_SESSION["dir_previa"];
    unset($_SESSION["dir_previa"]);
}

header("Location: $dirPrevia");
exit;
