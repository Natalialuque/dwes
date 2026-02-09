<?php

echo CHTML::dibujaEtiqueta("h1", [], "Listado de Partidas");

// Número total de partidas
echo CHTML::dibujaEtiqueta(
    "p",
    [],
    "Número total de partidas: " . $this->N_Partidas
);

// Partidas previstas para hoy
echo CHTML::dibujaEtiqueta(
    "p",
    [],
    "Partidas previstas para hoy: " . $this->N_PartidasHoy
);

// Contenedor de tarjetas
echo CHTML::dibujaEtiqueta("div", ["class" => "contenedor-tarjetas"]);

foreach ($this->partidas as $p) {
    $this->dibujaVistaParcial("tarjeta", ["p" => $p]);
}

echo CHTML::dibujaEtiquetaCierre("div");