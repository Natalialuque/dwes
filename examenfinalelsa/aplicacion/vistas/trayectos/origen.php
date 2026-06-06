<?php

// Enlace a la acción "nueva"
echo CHTML::link(
    CHTML::imagen("/imagenes/16x16/nuevo.png", "Nueva Parada") . " NUEVO",
    ["trayectos", "nueva"]
);
echo CHTML::iniciarForm();
echo CHTML::campoListaDropDown("trayectos", 1, Listas::listaTrayectos(false), []);
echo CHTML::campoBotonSubmit("Ver",[]);
echo CHTML::finalizarForm();
if (isset($paradas) && count($paradas) > 0){
    echo "<h2>Paradas para el trayecto seleccionado</h2>";
    foreach ($paradas as $value) { 
        foreach ($value as $key => $valor) {
       // Pasamos a la vista parcial el valor actual
       echo $this->dibujaVistaParcial("vista_parcial", ["valor" => $valor], true);
       echo CHTML::link("Descargar", Sistema::app()->generaURL(["trayectos", "descargar"], ["cod_trayecto" => $cod_trayecto]));
       echo "<hr>";
        }
      
     }
    
}
elseif(isset($paradas) && count($paradas) ==0){
    echo "<p>No hay paradas definidas para el trayecto seleccionado.</p>";
}
