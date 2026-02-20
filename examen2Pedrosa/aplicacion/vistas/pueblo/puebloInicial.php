<?php

// Enlace a NUEVA PARTIDA
echo CHTML::dibujaEtiqueta(
    "a",
    ["href" => Sistema::app()->generaURL(["partida", "nueva"])],
    CHTML::imagen("/imagenes/16x16/nuevo.png") . " NUEVA PUEBLO"
);

// Formulario
echo CHTML::iniciarForm("", "post");

echo CHTML::dibujaEtiqueta("p", [], "Seleccione");

echo CHTML::dibujaEtiqueta("p",[],"unesco");
echo CHTML :: campoRadioButton("unesco");
echo CHTML::dibujaEtiqueta("p",[],"No unesco");
echo CHTML :: campoRadioButton("No unesco");

echo "<br>";
echo CHTML::campoBotonSubmit("Ver");

echo CHTML::finalizarForm();


