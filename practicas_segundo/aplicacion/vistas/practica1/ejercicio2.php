<?php

echo CHTML::dibujaEtiqueta("h2", [], "LANZAMIENTO DE UN DADO (6 veces)", true);

echo CHTML::dibujaEtiqueta("ul", [], null, false);

foreach ($resultados6 as $linea) {
    echo CHTML::dibujaEtiqueta("li", [], $linea, true);
}

echo CHTML::dibujaEtiquetaCierre("ul");


// 1000 LANZAMIENTOS

echo CHTML::dibujaEtiqueta("h2", [], "Lanzado el dado $numLanzamientos veces", true);

echo CHTML::dibujaEtiqueta("ul", [], null, false);

foreach ($estadisticas as $linea) {
    echo CHTML::dibujaEtiqueta("li", [], $linea, true);
}

echo CHTML::dibujaEtiquetaCierre("ul");

?>
