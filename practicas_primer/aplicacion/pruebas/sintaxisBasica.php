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

$num= 123456789126345678989;
$num= 123456789126345678989123456789;

settype($num,"float");

$num=intval("1234");
//$num=intval("esto");
//$num=$num/0;
$cadena = "esta es la cadena 'nueva cadena'";
//las comillas dobles hay que ponerlas con el \
$cadena = "esta es la cadena \"nueva cadena\"";

$cadena= "la variable \$num tiene como valor \$num";
$cadena= "la variable \$num tiene como valor ".$num." entero";

//conversion de tipo 
$num=12;
$num=(double)$num;
$num=settype($num,"string");
$num=intval($num);

if($num){
    $num=0;
}

if($num){
    $num=12;
}

//da falso tambien
$cadena=" ";
if($cadena)
$num=24;

$resultado = $num+"12hola";
//$resultado = $num +"hola12";
//$resultado = $num +"hola";


$var1=100;
$var2=$var1;
$var3=&$var1;
$var3=125;

//constantes
//Menor que -1, igual que 0 y mayor que 1
$resultado=-14<=>-12;
$resultado=-14<=>12;
$resultado=14<=>12;

$resultado=$var3??$num??0;
$var3=null;
$resultado=$var3??$num??-5;



if($num>1){
    $resultado="es correcto";
    $cadena="ok";
}
$num=10;




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