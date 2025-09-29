<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

$var=12;

if (isset($VAr))
    $VAr++;

unset($var);

$numero=mt_rand(1,10);
$nombre='Profesor';
$apellido='2daw';
$variable="nombre";

if($numero<=5) {
    $var="nombre";
} else {
    $var="apellido";
}
$resultado=$$var;


if(gettype($resultado)=="integer") {
    $resultado="es entero";
}
$var="esto es una cadeana";
if(gettype($var)=="integer") {
    $resultado="es entero";
}

$num = 0x1485;




//dibuja la plantilla de la vista
inicioCabecera("pruebas");
cabecera();
finCabecera();
inicioCuerpo("2DAW APLICACION");
cuerpo();  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{}

//vista
function cuerpo()
{
?>
   esta en pruebas basicas
<?php
  echo "<br>escrito desde php".PHP_EOL;
  echo "<br>otra linea".PHP_EOL;
  echo "<br>el host de llamada ".$_SERVER["HTTP_HOST"].
        " usando el navegador ".$_SERVER["HTTP_USER_AGENT"]."<br>".PHP_EOL;
}