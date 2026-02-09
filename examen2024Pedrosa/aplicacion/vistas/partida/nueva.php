<h1>Nueva partida</h1>
<?php
echo CHTML::modeloErrorSumario($modelo); 

echo CHTML::iniciarForm(["partida","nueva"]);

echo CHTML::modeloLabel($modelo, "cod_baraja",[]);
echo CHTML::modeloListaDropDown($modelo, "cod_baraja", $datosCodBaraja);
echo CHTML::modeloError($modelo,"cod_baraja");

echo "<br>";

echo CHTML::modeloLabel($modelo, "fecha",[]);
echo CHTML::modeloDate($modelo, "fecha");
echo CHTML::modeloError($modelo,"fecha");

echo "<br>";

echo CHTML::modeloLabel($modelo, "mesa",[]);
echo CHTML::modeloNumber($modelo, "mesa");
echo CHTML::modeloError($modelo,"mesa");

echo "<br>";

echo CHTML::modeloLabel($modelo, "jugadores",[]);

echo "<br>";

echo CHTML::campoListaRadioButton("jugadores",-1, $datosJugadores,"<br>");
echo CHTML::modeloError($modelo,"jugadores");

echo "<br>";

echo CHTML::modeloLabel($modelo, "crupier",[]);
echo CHTML::modeloText($modelo, "crupier");
echo CHTML::modeloError($modelo,"crupier");

echo "<br>";

echo CHTML::campoBotonSubmit("Crear partida");
echo CHTML::finalizarForm();