<?php

echo CHTML::dibujaEtiqueta(
    "div",
    ["class" => "tarjeta"],

    CHTML::dibujaEtiqueta("h3", [], "Partida #" . $p->cod_partida) .
    CHTML::dibujaEtiqueta("p", [], "Mesa: " . $p->mesa) .
    CHTML::dibujaEtiqueta("p", [], "Fecha: " . $p->fecha) .
    CHTML::dibujaEtiqueta("p", [], "Código baraja: " . $p->cod_baraja) .
    CHTML::dibujaEtiqueta("p", [], "Baraja: " . ($p->nombre_baraja ?? "Desconocida")) .
    CHTML::dibujaEtiqueta("p", [], "Jugadores: " . $p->jugadores) .
    CHTML::dibujaEtiqueta("p", [], "Crupier: " . $p->crupier) .
    CHTML::link(
            "Descargar",
            Sistema::app()->generaURL(["Partida", "descargar"], ["id" => $p->cod_partida])
    )
);
