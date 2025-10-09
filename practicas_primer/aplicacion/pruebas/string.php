<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

$cadena="sd127abcDE123";


// buscar un patron que localice uno o mas digitos seguidos de uno o mas letras
$patron="/\d+[a-z]+/";
$devuelto=[];

$ret=preg_match($patron, $cadena,$devuelto, PREG_OFFSET_CAPTURE);
if ($ret!==false)
  {
    //no hay error
    $var=1;
  }
  else
  {
    //hay error
    $var=1;
  }

// buscar un patron que localice uno o mas digitos seguidos de uno o mas letras
// sin distinguir mayusculas y minusculas en toda la cadena
$patron="/\d+[a-z]+/i";
$devuelto=[];

$ret=preg_match($patron, $cadena,$devuelto, PREG_OFFSET_CAPTURE);
if ($ret!==false)
  {
    //no hay error
    $var=1;
  }
  else
  {
    //hay error
    $var=1;
  }

// buscar un patron que localice uno o mas digitos seguidos de uno o mas letras
// devolviendo la parte del numero y de la palabra
$patron="/(\d+)([a-z]+)/";
$devuelto=[];

$ret=preg_match($patron, $cadena,$devuelto, PREG_OFFSET_CAPTURE);
if ($ret!==false)
  {
    //no hay error
    $var=1;
  }
  else
  {
    //hay error
    $var=1;
  }

//buscar un dni correcto y obtener la letra a parte del dni, sabiendo que lo primero 
//en la cadena debe ser el dni
$cadena="12543267Z";
$patron="/^\d{8}([a-zA-Z])/";
$patron="/^\d{8}([[:alpha:]])/";
$devuelto=[];

$ret=preg_match($patron, $cadena,$devuelto, PREG_OFFSET_CAPTURE);
if ($ret!==false)
  {
    //no hay error
    $var=1;
  }
  else
  {
    //hay error
    $var=1;
  }


$cadena=" 12345678P";  
$patron="/^\d{8}([a-zA-Z])/";
$devuelto=[];

$ret=preg_match($patron, $cadena,$devuelto, PREG_OFFSET_CAPTURE);
if ($ret!==false)
  {
    //no hay error
    $var=1;
  }
  else
  {
    //hay error
    $var=1;
  }

//busqueda hacia delante
//busca en la cadena trozos formados por letras o numeros o -,
//y obligatoriamente debe aparecer el -

$cadena=" -ami23.34,";  
$patron="/(?=-)[-0-9a-zA-Z]+/";
$devuelto=[];

$ret=preg_match($patron, $cadena,$devuelto, PREG_OFFSET_CAPTURE);
if ($ret!==false)
  {
    //no hay error
    $var=1;
  }
  else
  {
    //hay error
    $var=1;
  }

$cadena=" ami-23.34,";  
$patron="/(?=-)[-0-9a-zA-Z]+/";
$devuelto=[];

$ret=preg_match($patron, $cadena,$devuelto, PREG_OFFSET_CAPTURE);
if ($ret!==false)
  {
    //no hay error
    $var=1;
  }
  else
  {
    //hay error
    $var=1;
  }

$cadena=" ami-23.34,";  
$patron="/(?=.*-)[-0-9a-zA-Z]+/";
$devuelto=[];

$ret=preg_match($patron, $cadena,$devuelto, PREG_OFFSET_CAPTURE);
if ($ret!==false)
  {
    //no hay error
    $var=1;
  }
  else
  {
    //hay error
    $var=1;
  }

//buscar una palabra (serie de letras) que contenga un [ entre medias de las letras
$cadena="luis 12a[-pala[bra234";
$patron="/[[:alpha:]]+\[[a-zA-Z]+/";
$devuelto=[];

$ret=preg_match($patron, $cadena,$devuelto, PREG_OFFSET_CAPTURE);
if ($ret!==false)
  {
    //no hay error
    $var=1;
  }
  else
  {
    //hay error
    $var=1;
  }


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
   esta en pruebas cadenas
<?php

}