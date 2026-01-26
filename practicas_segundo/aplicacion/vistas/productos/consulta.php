<h2>Consulta de producto</h2>

<?php
echo "<p><b>Nombre:</b> " . $prod["nombre"] . "</p>";
echo "<p><b>Categoría:</b> " . $prod["descripcion_categoria"] . "</p>";
echo "<p><b>Fabricante:</b> " . $prod["fabricante"] . "</p>";
echo "<p><b>Fecha alta:</b> " . $prod["fecha_alta"] . "</p>";
echo "<p><b>Unidades:</b> " . $prod["unidades"] . "</p>";
echo "<p><b>Precio base:</b> " . $prod["precio_base"] . "</p>";
echo "<p><b>IVA:</b> " . $prod["iva"] . "</p>";
echo "<p><b>Precio IVA:</b> " . $prod["precio_iva"] . "</p>";
echo "<p><b>Precio venta:</b> " . $prod["precio_venta"] . "</p>";
echo "<p><b>Foto:</b> " . $prod["foto"] . "</p>";

echo "<p><b>Borrado:</b> " . ($prod["borrado"] ? "SÍ" : "NO") . "</p>";

echo "<br>";

echo CHTML::link("Volver al listado", ["productos"]);
?>
