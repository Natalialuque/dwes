<?php
echo CHTML::dibujaEtiqueta("label", [], "Introduce mínimo");
echo CHTML::campoNumber("min", "", ["id" => "min"]);

echo CHTML::dibujaEtiqueta("br", []);

echo CHTML::dibujaEtiqueta("label", [], "Introduce Máximo");
echo CHTML::campoNumber("max", "", ["id" => "max"]);

echo CHTML::dibujaEtiqueta("br", []);

echo CHTML::dibujaEtiqueta("label", [], "Introduce Cadena");
echo CHTML::campoText("cadena", "", ["id" => "cadena"]);   

echo CHTML::dibujaEtiqueta("br", []);

echo CHTML::boton("Pedir datos", ["id" => "pedir"]);

echo CHTML::dibujaEtiqueta("div", ["id" => "respuesta"]);

// URL para AJAX (se la pasamos al JS mediante data-atributo)
$urlAjax = Sistema::app()->generaURL(["practica2", "pedirDatos"]);
echo CHTML::dibujaEtiqueta("div", ["id" => "urlAjax", "data-url" => $urlAjax], "", true);

// añadir enlace al script en la cabecera
$this->textoHead = CHTML::scriptFichero("/scripts/pedirdatos.js", ["defer" => "defer"]);
?>
