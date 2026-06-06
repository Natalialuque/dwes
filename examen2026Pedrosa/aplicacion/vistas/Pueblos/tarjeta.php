<?php

echo CHTML::dibujaEtiqueta(
    "div",
    ["class" => "tarjeta"],
     CHTML::dibujaEtiqueta("h3",[],"Nombre: ".$p->nombre) .
     CHTML::dibujaEtiqueta("p",[],"Codigo tipo elemento: " . $p->cod_tipo_elemento) .
     CHTML::dibujaEtiqueta("p",[],"Tipo descripcion: " . $p->descripcion_tipo) .
     CHTML::dibujaEtiqueta("p",[],"Elemento: " . $p->elemento) .
     CHTML::dibujaEtiqueta("p",[],"Reconocido por Unesco: " . $p->reconocido_unesco) .
     CHTML::dibujaEtiqueta("p",[],"fecha_reconocimiento: " . $p->fecha_reconocimiento) .
     CHTML::link(
            "Descargar",
            Sistema::app()->generaURL(["Pueblos", "descargar"], ["id" => $p->nombre])
        )
    
);