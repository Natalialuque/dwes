<?php
echo CHTML::dibujaEtiqueta(
    "div",
    ["class" => "tarjeta"],
    CHTML::dibujaEtiqueta("h3", [], "Trayecto: " . $parada->nombreTrayecto) .
    CHTML::dibujaEtiqueta("p", [], "Codigo trayecto: " . $parada->cod_trayecto) .
    CHTML::dibujaEtiqueta("p", [], "Estacion: " . $parada->estacion) .
    CHTML::dibujaEtiqueta("p", [], "Poblacion: " . $parada->poblacion) .
    CHTML::dibujaEtiqueta("p", [], "Es origen: " . $parada->es_origen) .
    CHTML::link(
        "Descargar",
        Sistema::app()->generaURL(["ParadasTray", "descargar"], ["id" => $parada->cod_trayecto])
    )
);
