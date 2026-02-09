<?php

echo CHTML::dibujaEtiqueta("h1", [], "Listado de Partidas");

// Totales
echo CHTML::dibujaEtiqueta("p", [],
    "Total de partidas: " . $N_Partidas
);

echo CHTML::dibujaEtiqueta("p", [],
    "Partidas previstas para hoy: " . $N_PartidasHoy
);

// Tabla
echo CHTML::dibujaEtiqueta("table", ["border" => 1, "cellpadding" => 5], null, false);

// Cabecera
echo CHTML::dibujaEtiqueta("tr", [], null, false);

echo CHTML::dibujaEtiqueta("th", [], "Código");
echo CHTML::dibujaEtiqueta("th", [], "Mesa");
echo CHTML::dibujaEtiqueta("th", [], "Fecha");
echo CHTML::dibujaEtiqueta("th", [], "Código Baraja");
echo CHTML::dibujaEtiqueta("th", [], "Jugadores");
echo CHTML::dibujaEtiqueta("th", [], "Crupier");
echo CHTML::dibujaEtiqueta("th", [], "Nombre Baraja");

echo CHTML::dibujaEtiquetaCierre("tr");

// Filas
foreach ($partidas as $p) {

    echo CHTML::dibujaEtiqueta("tr", [], null, false);

    echo CHTML::dibujaEtiqueta("td", [], $p->cod_partida);
    echo CHTML::dibujaEtiqueta("td", [], $p->mesa);
    echo CHTML::dibujaEtiqueta("td", [], $p->fecha);
    echo CHTML::dibujaEtiqueta("td", [], $p->cod_baraja);
    echo CHTML::dibujaEtiqueta("td", [], $p->jugadores);
    echo CHTML::dibujaEtiqueta("td", [], $p->crupier);
    echo CHTML::dibujaEtiqueta("td", [], $p->nombre_baraja);

    echo CHTML::dibujaEtiquetaCierre("tr");
}

echo CHTML::dibujaEtiquetaCierre("table");
