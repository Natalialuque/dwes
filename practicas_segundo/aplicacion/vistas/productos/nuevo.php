<h2>Nuevo producto</h2>

<?php
echo CHTML::iniciarForm(["productos", "nuevo"]);

// NOMBRE
echo CHTML::modeloLabel($modelo, "nombre");
echo CHTML::modeloText($modelo, "nombre");
echo CHTML::modeloError($modelo, "nombre");
echo "<br>";

// CATEGORÍA
echo CHTML::modeloLabel($modelo, "cod_categoria");
echo CHTML::modeloNumber($modelo, "cod_categoria");
echo CHTML::modeloError($modelo, "cod_categoria");
echo "<br>";

// FABRICANTE
echo CHTML::modeloLabel($modelo, "fabricante");
echo CHTML::modeloText($modelo, "fabricante");
echo CHTML::modeloError($modelo, "fabricante");
echo "<br>";

// FECHA ALTA
echo CHTML::modeloLabel($modelo, "fecha_alta");
echo CHTML::modeloDate($modelo, "fecha_alta");
echo CHTML::modeloError($modelo, "fecha_alta");
echo "<br>";

// UNIDADES
echo CHTML::modeloLabel($modelo, "unidades");
echo CHTML::modeloNumber($modelo, "unidades");
echo CHTML::modeloError($modelo, "unidades");
echo "<br>";

// PRECIO BASE
echo CHTML::modeloLabel($modelo, "precio_base");
echo CHTML::modeloNumber($modelo, "precio_base");
echo CHTML::modeloError($modelo, "precio_base");
echo "<br>";

// IVA
echo CHTML::modeloLabel($modelo, "iva");
echo CHTML::modeloNumber($modelo, "iva");
echo CHTML::modeloError($modelo, "iva");
echo "<br>";

// FOTO
echo CHTML::modeloLabel($modelo, "foto");
echo CHTML::modeloText($modelo, "foto");
echo CHTML::modeloError($modelo, "foto");
echo "<br>";

// BOTÓN
echo CHTML::campoBotonSubmit("Guardar");

echo CHTML::finalizarForm();

echo "<br>";
echo CHTML::link("Volver al listado", ["productos"]);
?>
