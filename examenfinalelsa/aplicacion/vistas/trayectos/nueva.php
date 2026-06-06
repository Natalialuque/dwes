
<?php
echo CHTML::dibujaEtiqueta("h1",[], "Nueva Parada");
echo CHTML::iniciarForm(["trayectos", "nueva"], "POST");

echo CHTML::modeloLabel($modelo, "cod_trayecto");
echo "<br>";
echo CHTML::campoListaDropDown("cod_trayecto", "", Listas::listaTrayectos(false));
echo "<br>";
// echo CHTML::modeloLabel($modelo, "nombreTrayecto");
// echo "<br>";
// echo CHTML::modeloNumber($modelo, "nombreTrayecto");
// echo "<br>";
echo CHTML::modeloLabel($modelo, "estacion");
echo "<br>";
echo CHTML::modeloText($modelo, "estacion");
echo "<br>";
echo CHTML::modeloLabel($modelo, "poblacion");
echo "<br>";
echo CHTML::modeloText($modelo, "poblacion");
echo "<br>";


echo CHTML::campoBotonSubmit("Crear Parada",["name"=>"crear_parada"]);
echo CHTML::finalizarForm();