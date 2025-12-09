
<?php

include_once(dirname(__FILE__) . "/../../cabecera.php");



if (!isset($_POST["descargar"]))
    {
        echo "parametros incorrectos";
        exit;
    }
$id=intval($_POST["descargar"]);

if (!isset($PRO[$id]))
    {
        echo "No se encuentra el beneficiario";
        exit;
    }

//creación tipo de imagen y descarga
header("content-type: text/txt");
header("content-disposition: attachment; filename=bonos.txt");

$bonos=$benefi[$id]->getListaBonos();
foreach($bonos as $numero=>$importe)
    echo "$numero => $importe".PHP_EOL;