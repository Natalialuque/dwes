<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$BENEFI = $_SESSION["BENEFI"] ?? [];
$id = $_GET["id"] ?? "";

if ($id === "" || !isset($BENEFI[$id])) {
    paginaError("No existe el beneficiario indicado");
    exit;
}

$beneficiario = $BENEFI[$id];
$nombreFichero = "beneficiario_" . $id . ".txt";

header("Content-Type: text/plain; charset=utf-8");
header("Content-Disposition: attachment; filename=$nombreFichero");

echo $beneficiario . PHP_EOL;

foreach ($beneficiario->getBonos() as $clave => $valor) {
    echo $clave . ": " . $valor . PHP_EOL;
}

exit;
