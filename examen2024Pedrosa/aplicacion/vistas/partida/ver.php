<?php

// Enlace a NUEVA PARTIDA
echo CHTML::dibujaEtiqueta(
    "a",
    ["href" => Sistema::app()->generaURL(["partida", "nueva"])],
    CHTML::imagen("/imagenes/16x16/nuevo.png") . " NUEVA PARTIDA"
);

// Formulario
echo CHTML::iniciarForm("", "post");

echo CHTML::dibujaEtiqueta("p", [], "Seleccione crupier:");

echo CHTML::campoListaDropDown(
    "crupier",
    $crupierSel,
    $crupiers
);

echo CHTML::campoBotonSubmit("Ver");

echo CHTML::finalizarForm();

// Mostrar partidas filtradas
if (!empty($partidasFiltradas)) {
    foreach ($partidasFiltradas as $p) {
        $this->dibujaVistaParcial("tarjeta", ["p" => $p]);
    }
}
