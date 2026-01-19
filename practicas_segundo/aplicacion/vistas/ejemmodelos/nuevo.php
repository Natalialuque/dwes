<?php
echo CHTML::iniciarForm();
echo CHTML::modeloLabel($modelo, "nombre");
echo CHTML::modeloText($modelo,
"nombre",array("maxlength"=>30,"size"=>31));
echo CHTML::modeloError($modelo, "nombre");
echo "<br>";

echo CHTML::modeloLabel($modelo, "descripcion");
echo CHTML::modeloText($modelo,
"descripcion", array("maxlength"=>60,"size"=>61));
echo CHTML::modeloError($modelo, "descripcion");
echo "<br>";

echo CHTML::modeloLabel($modelo, "unidades");
echo CHTML::modeloText($modelo,
"unidades", array("maxlength"=>8,"size"=>9));
echo CHTML::modeloError($modelo, "unidades");
echo "<br>";

/*echo CHTML::modeloLabel($modelo, "cod_fabricante");
echo CHTML::modeloListaDropDown($modelo,
"cod_fabricante",
Articulos::listaFabricantes(),
array("linea"=>false));
echo CHTML::modeloError($modelo, "cod_fabricante");
echo "<br>";
echo CHTML::modeloLabel($modelo, "fecha_alta");
echo CHTML::modeloText($modelo,
"fecha_alta",
array("maxlength"=>10,"size"=>11));
echo CHTML::modeloError($modelo, "fecha_alta");
echo "<br>";*/
echo CHTML::campoBotonSubmit("Crear");
echo CHTML::finalizarForm();