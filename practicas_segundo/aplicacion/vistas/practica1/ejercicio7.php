<?php

echo CHTML::dibujaEtiqueta("h2", [], "USANDO FUNCIONES DE FECHA", true);

echo CHTML::dibujaEtiqueta("ul", [], null, false);

echo CHTML::dibujaEtiqueta("li", [], "Fecha actual (d/m/Y): $fechaActual", true);
echo CHTML::dibujaEtiqueta("li", [], "Fecha actual (formato extendido): $fechaActualExtendida", true);
echo CHTML::dibujaEtiqueta("li", [], "Hora actual (hh:mm:ss): $horaActual", true);

echo CHTML::dibujaEtiqueta("li", [], "Fecha fija (d/m/Y): $fechaFija", true);
echo CHTML::dibujaEtiqueta("li", [], "Fecha fija (formato extendido): $fechaFijaExtendida", true);
echo CHTML::dibujaEtiqueta("li", [], "Hora fija (hh:mm:ss): $horaFija", true);

echo CHTML::dibujaEtiqueta("li", [], "Fecha modificada (d/m/Y): $fechaModificada", true);
echo CHTML::dibujaEtiqueta("li", [], "Fecha modificada (formato extendido): $fechaModificadaExtendida", true);
echo CHTML::dibujaEtiqueta("li", [], "Hora modificada (hh:mm:ss): $horaModificada", true);

echo CHTML::dibujaEtiquetaCierre("ul");


// USANDO CLASE DATETIME

echo CHTML::dibujaEtiqueta("h2", [], "USANDO CLASE DATETIME", true);

echo CHTML::dibujaEtiqueta("ul", [], null, false);

echo CHTML::dibujaEtiqueta("li", [], "Fecha actual (d/m/Y): $dtActual", true);
echo CHTML::dibujaEtiqueta("li", [], "Fecha actual (formato extendido): $dtActualExtendida", true);
echo CHTML::dibujaEtiqueta("li", [], "Hora actual (hh:mm:ss): $dtHoraActual", true);

echo CHTML::dibujaEtiqueta("li", [], "Fecha fija (d/m/Y): $dtFija", true);
echo CHTML::dibujaEtiqueta("li", [], "Fecha fija (formato extendido): $dtFijaExtendida", true);
echo CHTML::dibujaEtiqueta("li", [], "Hora fija (hh:mm:ss): $dtHoraFija", true);

echo CHTML::dibujaEtiqueta("li", [], "Fecha modificada (d/m/Y): $dtModificada", true);
echo CHTML::dibujaEtiqueta("li", [], "Fecha modificada (formato extendido): $dtModificadaExtendida", true);
echo CHTML::dibujaEtiqueta("li", [], "Hora modificada (hh:mm:ss): $dtHoraModificada", true);

echo CHTML::dibujaEtiquetaCierre("ul");

?>
