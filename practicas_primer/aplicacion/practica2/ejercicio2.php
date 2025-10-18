<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// barra de ubicación
$ubicacion = [
    "pagina principal" => "../../index.php",
    "relacion 2" => "./index.php",
    "Ejercicio 2" => "ejercicio2.php"
];

$GLOBALS["Ubicacion"] = $ubicacion;

// controlador 
$cadena = "Está la niña en casa";

// dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 2");
cuerpo();  // llamo a la vista
finCuerpo();

function cabecera() {
    // puedes añadir contenido aquí si lo necesitas
}

// vista
function cuerpo() {
    global $cadena; // accedemos a la variable definida fuera de la función
    $longitud = mb_strlen($cadena);
    //cerramos php para escribir en  html
     ?> 
    
    <h2>Recorrido normal con espacios según posición:</h2>
    <pre>
    <?php
    for ($i = 0; $i < $longitud; $i++) { 
        $char = mb_substr($cadena, $i, 1);
        echo str_repeat(" ", $i) . $char . "\n";
    }
    ?>
    </pre>

    <h2>Recorrer la cadena en orden inverso con formato:</h2>
    <pre>
    <?php
    for ($i = 0; $i < $longitud; $i++) {
        $char = mb_substr($cadena, -($i + 1), 1);
        $espacios = str_repeat(" ", $i);
        $formateado = ($i % 2 == 0) ? mb_strtoupper($char) : mb_strtolower($char);
        echo $espacios . $formateado . "\n";
    }
    ?>
    </pre>

    <h2>Separar la cadena por el carácter "a":</h2>
    <pre>
    <?php
    $partes = explode("a", $cadena);
    foreach ($partes as $parte) {
        echo $parte . "\n";
    }
    ?>
    </pre>

    <h2>Reemplazar el espacio después de "niña" por "/mujer ":</h2>
    <pre>
    <?php
    $pos = mb_strpos($cadena, "niña");
    if ($pos !== false) {
        $antes = mb_substr($cadena, 0, $pos + 4); // "niña"
        $despues = mb_substr($cadena, $pos + 5);  // salta el espacio
        $resultado = $antes . "/mujer " . $despues;
        echo $resultado;
    } else {
        echo $cadena;
    }
    ?>
    </pre>
    <?php
} 