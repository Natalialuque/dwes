<<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

//controlador
$cadena = "sd123fgbdf";

//buscar un patron que localice uno o mas digitos seguidos de uno o mas letras
$patron = "/\d+[a-z]+/";
$devuelvo = [];

$sret==preg_match($patron,$cadena,$devuelvo,PREG_OFFSET_CAPTURE);
if($sret !== false){
    
    //No hay error 
    $var =1;
}else{
    //hay error 
    $var=1;

}

//buscar un patron que localice uno o mas digitos seguidos de uno o mas letras sin distringuir mayusculas
$cadena = "1234567N";
$patron = "/\d{8}([a-zA-Z])/";
$devuelvo = [];

$sret==preg_match($patron,$cadena,$devuelvo,PREG_OFFSET_CAPTURE);
if($sret !== false){
    
    //No hay error 
    $var =1;
}else{
    //hay error 
    $var=1;

}
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

  
 
}

?>