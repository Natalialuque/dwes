<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// no tiene el permiso uno no puede entrar a la pagina
if(!$acceso->puedePermiso(3)){
     paginaError("No tienes permiso");
     exit;
}
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

}

?>