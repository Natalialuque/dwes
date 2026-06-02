<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Recuperar colecciones desde sesión
$COL = $_SESSION["COL"] ?? [];

// 1. Verificar parámetro id
if (!isset($_GET["id"])) {
    echo "La colección indicada no es válida";
    exit;
}

$id = $_GET["id"];

// 2. Verificar que la colección existe
if (!isset($COL[$id])) {
    echo "La colección indicada no es válida";
    exit;
}

// Objeto colección
$coleccion = $COL[$id];

// 3. Construir el contenido del fichero
$contenido  = "COLECCIÓN: " . $coleccion->getNombre() . PHP_EOL;
$contenido .= "Fecha alta: " . $coleccion->getFechaAlta() . PHP_EOL;
$contenido .= "Temática: " . $coleccion->getTematicaDescripcion() . PHP_EOL;
$contenido .= "----------------------------------------" . PHP_EOL;
$contenido .= "LIBROS:" . PHP_EOL . PHP_EOL;

// Recorrer libros
foreach ($coleccion->dameLibros() as $libro) {

    // Gracias al Iterator de Libro, podemos recorrer propiedades dinámicas
    foreach ($libro as $prop => $valor) {
        $contenido .= "$prop: $valor" . PHP_EOL;
    }

    $contenido .= "----------------------------------------" . PHP_EOL;
}

// 4. Si se marcó “descargar”, enviar cabeceras de descarga
if (isset($_GET["descargar"])) {
    header("Content-Type: text/plain");
    header("Content-Disposition: attachment; filename=coleccion_$id.txt");
    echo $contenido;
    exit;
}

// 5. Si NO se marcó descargar → mostrar en pantalla
echo "<pre>$contenido</pre>";
