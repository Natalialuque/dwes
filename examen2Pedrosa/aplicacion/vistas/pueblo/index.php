<?php

echo CHTML::dibujaEtiqueta("h1", [], "Listado de pueblos");

// Número total de pueblos
echo CHTML::dibujaEtiqueta(
    "p",
    [],
    "Número total de pueblos: " . $this->N_Pueblos
);

// pueblos unesco total
echo CHTML::dibujaEtiqueta(
    "p",
    [],
    "pueblos de la unesco: " . $this->N_PueblosUnesco
);

// Contenedor de tarjetas
echo CHTML::dibujaEtiqueta("div", ["class" => "contenedor-tarjeta"]);

foreach ($this->_Mispueblos as $p) {
    $this->dibujaVistaParcial("tarjeta", ["p" => $p]);
}

echo CHTML::dibujaEtiquetaCierre("div");