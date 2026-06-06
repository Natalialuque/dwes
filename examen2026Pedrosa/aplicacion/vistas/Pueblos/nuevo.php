<h1>Nuevo pueblo</h1>

<?php
echo CHTML::iniciarForm(["Pueblos","nuevo"]);

// Mostrar resumen de errores del modelo
echo CHTML::modeloErrorSumario($modelo);
echo "<br>";

// Campo: nombre
echo CHTML::modeloLabel($modelo,"nombre");
echo CHTML::modeloText($modelo,"nombre",["maxlength"=>25]);
echo CHTML::modeloError($modelo,"nombre");
echo "<br><br>";

// Campo: cod_tipo_elemento (combo)
echo CHTML::modeloLabel($modelo,"cod_tipo_elemento");
$datosCodElemento = [0 => "Sin indicar"];
foreach (Listas::listaTipoElemento() as $l) {
    $datosCodElemento[] = $l;
}
echo CHTML::modeloListaDropDown($modelo,"cod_tipo_elemento",$datosCodElemento);
echo CHTML::modeloError($modelo,"cod_tipo_elemento");
echo "<br><br>";

// Campo: elemento
echo CHTML::modeloLabel($modelo,"elemento");
echo CHTML::modeloText($modelo,"elemento",["maxlength"=>35]);
echo CHTML::modeloError($modelo,"elemento");
echo "<br><br>";

// Campo: reconocido_unesco (radiobutton)
echo CHTML::modeloLabel($modelo,"reconocido_unesco");
$datosUnesco = [1 => "No", 0 => "Si"];
echo CHTML::modeloListaRadioButton($modelo,"reconocido_unesco",$datosUnesco," ");
echo CHTML::modeloError($modelo,"reconocido_unesco");
echo "<br><br>";

// Campo: fecha_reconocimiento
echo CHTML::modeloLabel($modelo,"fecha_reconocimiento");
echo CHTML::modeloText($modelo,"fecha_reconocimiento",["placeholder"=>"dd/mm/yyyy"]);
echo CHTML::modeloError($modelo,"fecha_reconocimiento");
echo "<br><br>";

// Botón de envío
echo CHTML::campoBotonSubmit("Crear");
echo CHTML::finalizarForm();
?>
