<?php

$archivo = "descarga1.txt";
$texto = "hemos realizado la descarga1";

// Cabeceras para forzar la descarga
header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=\"{$archivo}\"");
header("Content-Length: " . strlen($texto));

// Salida del contenido
echo $texto;
exit;
