<h2>Listado de productos</h2>

<?php
echo CHTML::iniciarForm(["productos", "index"]);

echo "Nombre: ";
echo CHTML::campoText("nombre", $nombre);
echo "<br>";

echo "Categoría: ";
echo CHTML::campoNumber("categoria", $categoria);
echo "<br>";

echo "Borrado: ";
echo CHTML::campoListaDropDown("borrado", $borrado, [
    "" => "",
    "0" => "NO",
    "1" => "SÍ"
]);
echo "<br><br>";

echo CHTML::campoBotonSubmit("Filtrar");

echo CHTML::finalizarForm();

echo "<br>";

// echo CHTML::link("Nuevo producto", ["productos", "nuevo"]);
// echo "<br><br>";

// *** TABLA ***
$grid = new CGrid($cab, $fil);
echo $grid->dibujate();

echo "<br>";

// *** PAGINADOR ***
$pager = new CPager($cabpag);
echo $pager->dibujate();

echo "<br>";

// *** FORMULARIO DESCARGA ***
echo CHTML::iniciarForm(["productos", "descargarProductos"]);

echo CHTML::campoHidden("nombre", $nombre);
echo CHTML::campoHidden("categoria", $categoria);
echo CHTML::campoHidden("borrado", $borrado);

echo CHTML::campoBotonSubmit("Descargar productos filtrados");

echo CHTML::finalizarForm();
?>
