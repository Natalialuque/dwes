<h1>Nueva parada</h1>

<?php
echo CHTML::iniciarForm(["ParadasTray", "nueva"]);
echo CHTML::modeloErrorSumario($modelo);
echo "<br>";

echo CHTML::modeloLabel($modelo, "cod_trayecto");
echo CHTML::modeloListaDropDown($modelo, "cod_trayecto", Lista::listaTrayectos(), ["linea" => false]);
echo CHTML::modeloError($modelo, "cod_trayecto");
echo "<br><br>";

$nombre = $modelo->getNombre();
$campoEstacion = $nombre . "[estacion]";
echo CHTML::campoLabel($modelo->getDescripcion("estacion"), "parada_estacion");
echo CHTML::campoText($campoEstacion, $modelo->estacion, ["maxlength" => 30, "id" => "parada_estacion"]);
echo CHTML::modeloError($modelo, "estacion");
echo "<br><br>";

echo CHTML::modeloLabel($modelo, "poblacion");
echo CHTML::modeloText($modelo, "poblacion", ["maxlength" => 30]);
echo CHTML::modeloError($modelo, "poblacion");
echo "<br><br>";

echo CHTML::campoBotonSubmit("Crear");
echo CHTML::finalizarForm();
?>
