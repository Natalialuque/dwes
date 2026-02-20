<?php

echo CHTML::dibujaEtiqueta(
    "div",
    ["class" => "tarjeta"],

    CHTML::dibujaEtiqueta("h3", [], "nombre #" . $p->nombre) .
    CHTML::dibujaEtiqueta("p", [], "codigo del pueblo: " . $p->cod_tipo) .
    CHTML::dibujaEtiqueta("p", [], "Descripcion del pueblo: " . $p->descripcion_tipo) .
    CHTML::dibujaEtiqueta("p", [], "elemento: " . $p->elemento) .
    CHTML::dibujaEtiqueta("p", [], "reconocido_unesco: " . $p->reconocido_unesco ) .
    CHTML::dibujaEtiqueta("p", [], "fecha_reconocimiento: " . $p->fecha_reconocimiento) .
    CHTML::link(
            "Descargar",
            Sistema::app()->generaURL(["pueblo", "descargar"], ["id" => $p->$cod_tipo])
    )
    
);
