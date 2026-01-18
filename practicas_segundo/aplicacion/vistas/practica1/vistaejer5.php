<?php

echo CHTML::dibujaEtiqueta("h2", [], "Ejercicio 5 – Procesamiento de Arrays", true);

echo CHTML::dibujaEtiqueta("ul", [], null, false);

foreach ($vector as $posicion => $contenido) {

    // Llamamos a la vista parcial
    $this->dibujaVistaParcial(
        "vistaejer5-parte",
        [
            "posicion" => $posicion,
            "contenido" => $contenido
        ]
    );
}

echo CHTML::dibujaEtiquetaCierre("ul");

?>
