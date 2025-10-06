<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador
$valor[0]=18;
$valor[1]="hola";
$valor[2]=3.14;   
$valor[3]=true;
$valor[5]=100;
$valor["primera"]="hola buenos dias yo me siento bien";



for($i=0; $i<count($valor); $i++){
    $aux=$valor[$i];
}

//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
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
    estas en pruebas arrays
<?php
}
