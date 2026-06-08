<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Recuperamos el array de beneficiarios y el id elegido en el combo del index.
$BENEFI = $_SESSION["BENEFI"] ?? [];
$id = $_GET["id"] ?? "";

// Si el id no existe, se muestra pagina de error.
if ($id === "" || !isset($BENEFI[$id])) {
    paginaError("No existe el beneficiario indicado");
    exit;
}

// Beneficiario que vamos a exportar.
$beneficiario = $BENEFI[$id];
$nombreFichero = "beneficiario_" . $id . ".txt";

// Cabeceras para que el navegador descargue un fichero de texto.
header("Content-Type: text/plain; charset=utf-8");
header("Content-Disposition: attachment; filename=$nombreFichero");

// Primera linea: datos generales del beneficiario.
echo $beneficiario . PHP_EOL;

// Despues se escriben el importe total y los bonos usando foreach.
foreach ($beneficiario->getBonos() as $clave => $valor) {
    echo $clave . ": " . $valor . PHP_EOL;
}

// Cortamos la ejecucion para que no se pinte la plantilla HTML.
exit;
