<?php
echo CHTML::link(
    CHTML::imagen("/imagenes/16x16/nuevo.png", "nueva", ["style" => "width:40px;"]) . "NUEVA PARADA",
    ["ParadasTray", "nueva"]
);

echo "<br><br>";

echo CHTML::iniciarForm(["ParadasTray", "ver"]);
echo CHTML::campoLabel("Estacion", "estacion");
echo CHTML::campoListaDropDown("estacion", $estacionSeleccionada, $estaciones, ["linea" => "Seleccione estacion"]);
echo CHTML::campoBotonSubmit("Ver");
echo CHTML::finalizarForm();

if ($estacionSeleccionada !== "" && empty($paradas)) {
    echo CHTML::dibujaEtiqueta("p", [], "No hay paradas para la estacion seleccionada.");
}

if (!empty($paradas)) {
    echo CHTML::dibujaEtiqueta("div", ["class" => "paradas"], null, false);
    foreach ($paradas as $parada) {
        $this->dibujaVistaParcial("tarjeta", ["parada" => $parada]);
    }
    echo CHTML::dibujaEtiquetaCierre("div");
}
