<?php
// Nombre del archivo a descargar
$nombreFichero = "datos_registro.txt";

// Cabeceras para forzar la descarga
header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=\"$nombreFichero\"");

// Contenido del fichero
echo "DATOS DE REGISTRO\n";
echo "-------------------\n";
echo "Nick: " . $modelo->nick . "\n";
echo "NIF: " . $modelo->nif . "\n";
echo "Fecha de nacimiento: " . $modelo->fecha_nacimiento . "\n";
echo "Provincia: " . $modelo->provincia . "\n";
echo "Estado: " . DatosRegistro::dameEstados($modelo->estado) . "\n";
echo "Contraseña: " . $modelo->contrasenia . "\n";
