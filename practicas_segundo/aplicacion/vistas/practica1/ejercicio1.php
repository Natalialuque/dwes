<?php 

echo CHTML::dibujaEtiqueta("h2", [], "Funciones Matemáticas", true);


// BINARIO, OCTAL, HEXADECIMAL
echo CHTML::dibujaEtiqueta("h3", [], "Variables en binario, octal y hexadecimal", true);

echo CHTML::dibujaEtiqueta("ul", [], null, false);

echo CHTML::dibujaEtiqueta(
    "li",
    [],
    "Binario - " . decbin($binario) . " - Decimal - " . $binario,
    true
);

echo CHTML::dibujaEtiqueta(
    "li",
    [],
    "Octal - " . decoct($octal) . " - Decimal - " . $octal,
    true
);

echo CHTML::dibujaEtiqueta(
    "li",
    [],
    "Hexadecimal - " . dechex($hexadecimal) . " - Decimal - " . $hexadecimal,
    true
);

echo CHTML::dibujaEtiquetaCierre("ul");


// RESULTADOS DE FUNCIONES
echo CHTML::dibujaEtiqueta("h3", [], "Resultados de las funciones", true);

echo CHTML::dibujaEtiqueta("ul", [], null, false);

echo CHTML::dibujaEtiqueta(
    "li",
    [],
    "El resultado del redondeo (4.7) es: $resultado_round",
    true
);

echo CHTML::dibujaEtiqueta(
    "li",
    [],
    "El resultado de floor(5.2) es: $resultado_floor",
    true
);

echo CHTML::dibujaEtiqueta(
    "li",
    [],
    "El resultado de pow(2, 5) es: $resultado_pow",
    true
);

echo CHTML::dibujaEtiqueta(
    "li",
    [],
    "El resultado de sqrt(49) es: $resultado_sqrt",
    true
);

echo CHTML::dibujaEtiqueta(
    "li",
    [],
    "El resultado de convertir 123 de base 4 a base 8 es: $base4_base8",
    true
);

echo CHTML::dibujaEtiqueta(
    "li",
    [],
    "El resultado de dechex(25) es: $resultado_dechex",
    true
);

echo CHTML::dibujaEtiqueta(
    "li",
    [],
    "El resultado de abs(-15) es: $resultado_abs",
    true
);

echo CHTML::dibujaEtiqueta(
    "li",
    [],
    "El resultado de max(3, 7, 2, 9) es: $resultado_max",
    true
);

echo CHTML::dibujaEtiquetaCierre("ul");

