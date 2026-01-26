<?php
echo CHTML::iniciarForm(["productos", "descargarProductos"]);

// CAMPOS OCULTOS
echo CHTML::campoHidden("nombre", $nombre);
echo CHTML::campoHidden("categoria", $categoria);
echo CHTML::campoHidden("borrado", $borrado);

// BOTÓN
echo CHTML::campoBotonSubmit("Descargar productos filtrados");

echo CHTML::finalizarForm();
?>


