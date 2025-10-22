<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

$obj= new ClasePrueba();

$cadena=$obj->escribeAlgo();

$obj->entPublico=25;
//$obj->_entPrivado=13;
//$obj->_entProtegido=100;

$obj1=new ClaseHija();

$cadena="$obj";
$cadena="$obj1";

//pruebas con la sobrecarga

$obj1=new ClaseSobrecargadaPorDefecto();
$obj2=new ClaseSobrecargadaPorDefecto();

$obj1->nombre="vicente";

$obj1=new ClaseSinsobrecarga();

$obj1->num=34;
//$num=$obj1->otro;

$obj1=new ClaseConsobrecarga();

$obj1->numero=234;
$num=$obj1->numero;

$obj1->otro=34;


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
   esta en pruebas clases
<?php

}