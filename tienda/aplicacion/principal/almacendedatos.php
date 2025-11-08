<?php

$mueble1 = new mueblereciclado(
    "Armario",
    new caracteristicas("Color", "Gris", "Tipo", "Vestidor"),
    2,
    "Conforama",
    "Portugal",
    2023,
    "15/03/2023",
    "01/01/2024",
    89.99,
    55.0
);

$mueble2 = new mueblereciclado(
    "Zapatero",
    new caracteristicas("Color", "Beige", "Tipo", "Entrada"),
    1,
    "MueblesManolo",
    "Italia",
    2022,
    "10/06/2022",
    "01/01/2025",
    49.95,
    70.5
);

$mueble3 = new mueblereciclado(
    "Espejo",
    new caracteristicas("Color", "Plateado", "Tipo", "Baño"),
    3,
    "DecoHome",
    "Francia",
    2021,
    "01/02/2021",
    "01/01/2024",
    35.50,
    40.0
);

$mueble4 = new muebletradicional(
    "Silla",
    new caracteristicas("Color", "Rojo", "Tipo", "Comedor"),
    1,
    "MueblesLuque",
    "España",
    2024,
    "05/05/2024",
    "01/01/2026",
    75.00,
    18.5,
    "SLX001"
);

$mueble5 = new muebletradicional(
    "Estantería",
    new caracteristicas("Color", "Blanco", "Tipo", "Oficina"),
    4,
    "Ikea",
    "Suecia",
    2025,
    "12/04/2025",
    "01/01/2027",
    120.00,
    32.0,
    "EST2025"
);

$muebles = [
    1 => $mueble1,
    2 => $mueble2,
    3 => $mueble3,
    4 => $mueble4,
    5 => $mueble5
];

?>
