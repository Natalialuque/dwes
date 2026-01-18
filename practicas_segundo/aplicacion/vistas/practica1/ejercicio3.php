<?php

echo CHTML::dibujaEtiqueta("h2", [], "Arrays del Ejercicio 3", true);


// ARRAY 1
echo CHTML::dibujaEtiqueta("h3", [], "Array 1", true);

echo CHTML::dibujaEtiqueta("ul", [], null, false);

foreach ($array1 as $key => $value) {
    echo CHTML::dibujaEtiqueta("li", [], "[$key] => $value", true);
}

echo CHTML::dibujaEtiquetaCierre("ul");


// ARRAY 2
echo CHTML::dibujaEtiqueta("h3", [], "Array 2", true);

echo CHTML::dibujaEtiqueta("ul", [], null, false);

foreach ($array2 as $key => $value) {
    echo CHTML::dibujaEtiqueta("li", [], "[$key] => $value", true);
}

echo CHTML::dibujaEtiquetaCierre("ul");


// ARRAY 3
echo CHTML::dibujaEtiqueta("h3", [], "Array 3", true);

echo CHTML::dibujaEtiqueta("ul", [], null, false);

foreach ($array3 as $key => $value) {
    $texto = is_array($value) ? implode(", ", $value) : $value;
    echo CHTML::dibujaEtiqueta("li", [], "[$key] => $texto", true);
}

echo CHTML::dibujaEtiquetaCierre("ul");


// ARRAY 4
echo CHTML::dibujaEtiqueta("h3", [], "Array 4", true);

echo CHTML::dibujaEtiqueta("ul", [], null, false);

foreach ($array4 as $key => $value) {
    echo CHTML::dibujaEtiqueta("li", [], "[$key] => $value", true);
}

echo CHTML::dibujaEtiquetaCierre("ul");


// ARRAY 5
echo CHTML::dibujaEtiqueta("h3", [], "Array 5", true);

echo CHTML::dibujaEtiqueta("ul", [], null, false);

foreach ($array5 as $key => $value) {
    echo CHTML::dibujaEtiqueta("li", [], "[$key] => $value", true);
}

echo CHTML::dibujaEtiquetaCierre("ul");


// ARRAY 6
echo CHTML::dibujaEtiqueta("h3", [], "Array 6", true);

echo CHTML::dibujaEtiqueta("ul", [], null, false);

foreach ($array6 as $key => $value) {
    $texto = is_array($value) ? implode(", ", $value) : $value;
    echo CHTML::dibujaEtiqueta("li", [], "[$key] => $texto", true);
}

echo CHTML::dibujaEtiquetaCierre("ul");

?>
