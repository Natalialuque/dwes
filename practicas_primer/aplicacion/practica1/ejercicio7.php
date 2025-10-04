<<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

//controlador


///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo();  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo() {

  echo "USANDO FUNCIONES DE FECHA ";

  echo"<ul>";
// Fecha actual
echo "Fecha actual (d/m/Y): " . date("d/m/Y") . "<br>";
echo "Fecha actual (formato extendido): día " . date("d") . ", mes " . date("F") . ", año " . date("Y") . ", día de la semana " . date("l") . "<br>";
echo "Hora actual (hh:mm:ss): " . date("H:i:s") . "<br><br>";

// Fecha específica: 29/3/2024 a 12:45
$fechaFija = mktime(12, 45, 0, 3, 29, 2024);
echo "Fecha fija (d/m/Y): " . date("d/m/Y", $fechaFija) . "<br>";
echo "Fecha fija (formato extendido): día " . date("d", $fechaFija) . ", mes " . date("F", $fechaFija) . ", año " . date("Y", $fechaFija) . ", día de la semana " . date("l", $fechaFija) . "<br>";
echo "Hora fija (hh:mm:ss): " . date("H:i:s", $fechaFija) . "<br><br>";

// Fecha actual menos 12 días y 4 horas
$fechaModificada = strtotime("-12 days -4 hours");
echo "Fecha modificada (d/m/Y): " . date("d/m/Y", $fechaModificada) . "<br>";
echo "Fecha modificada (formato extendido): día " . date("d", $fechaModificada) . ", mes " . date("F", $fechaModificada) . ", año " . date("Y", $fechaModificada) . ", día de la semana " . date("l", $fechaModificada) . "<br>";
echo "Hora modificada (hh:mm:ss): " . date("H:i:s", $fechaModificada) . "<br>";

echo"</ul>";


echo "USANDO CLASE DATETIME ";

echo"<ul>";

// Fecha actual
$ahora = new DateTime();
echo "Fecha actual (d/m/Y): " . $ahora->format("d/m/Y") . "<br>";
echo "Fecha actual (formato extendido): día " . $ahora->format("d") . ", mes " . $ahora->format("F") . ", año " . $ahora->format("Y") . ", día de la semana " . $ahora->format("l") . "<br>";
echo "Hora actual (hh:mm:ss): " . $ahora->format("H:i:s") . "<br><br>";

// Fecha específica: 29/3/2024 a 12:45
$fechaFijaDT = new DateTime("2024-03-29 12:45:00");
echo "Fecha fija (d/m/Y): " . $fechaFijaDT->format("d/m/Y") . "<br>";
echo "Fecha fija (formato extendido): día " . $fechaFijaDT->format("d") . ", mes " . $fechaFijaDT->format("F") . ", año " . $fechaFijaDT->format("Y") . ", día de la semana " . $fechaFijaDT->format("l") . "<br>";
echo "Hora fija (hh:mm:ss): " . $fechaFijaDT->format("H:i:s") . "<br><br>";

// Fecha actual menos 12 días y 4 horas
$fechaModificadaDT = new DateTime();
$fechaModificadaDT->modify("-12 days -4 hours");
echo "Fecha modificada (d/m/Y): " . $fechaModificadaDT->format("d/m/Y") . "<br>";
echo "Fecha modificada (formato extendido): día " . $fechaModificadaDT->format("d") . ", mes " . $fechaModificadaDT->format("F") . ", año " . $fechaModificadaDT->format("Y") . ", día de la semana " . $fechaModificadaDT->format("l") . "<br>";
echo "Hora modificada (hh:mm:ss): " . $fechaModificadaDT->format("H:i:s") . "<br>";

echo"</ul>";

 
}

?>