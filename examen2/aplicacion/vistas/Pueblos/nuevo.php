<h1>Nuevo pueblo</h1>
<?php

echo CHTML::iniciarForm(["Pueblos","nuevo"]);

// echo CHTML::modeloErrorSumario($modelo);

echo CHTML::modeloLabel($modelo,"nombre");
echo CHTML::modeloText($modelo,"nombre");
echo CHTML::modeloError($modelo,"nombre");

echo "<br>";

echo CHTML::modeloLabel($modelo,"cod_tipo_elemento");
$datosCodElemento =[];
$datosCodElemento[0] = "Sin indicar";
foreach(Listas::listaTipoElementos() as $l) {
    $datosCodElemento[] = $l;
}

echo CHTML::modeloListaDropDown($modelo,"cod_tipo_elemento",$datosCodElemento);
echo CHTML::modeloError($modelo,"cod_tipo_elemento");

echo "<br>";

echo CHTML::modeloLabel($modelo,"elemento");
echo CHTML::modeloText($modelo,"elemento",["maxlength"=>35]);
echo CHTML::modeloError($modelo,"elemento");

echo "<br>";

echo CHTML::modeloLabel($modelo,"reconocido_unesco");

$datosUnesco = ["Si","No"];

echo CHTML::modeloListaRadioButton($modelo,"reconocido_unesco",$datosUnesco," ");
echo CHTML::modeloError($modelo,"reconocido_unesco");

echo "<br>";

echo CHTML::modeloLabel($modelo,"fecha_reconocimiento");
echo CHTML::modeloText($modelo, "fecha_reconocimiento");
echo CHTML::modeloError($modelo,"fecha_reconocimiento");

echo "<br>";

echo CHTML::campoBotonSubmit("Crear");
echo CHTML::finalizarForm();

