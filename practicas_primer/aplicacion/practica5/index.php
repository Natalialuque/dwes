<<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

//controlador
$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 4"=> "./index.php",

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;


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

?>
    <h1>Relación 5: Introducción de información.</h1>
    <ul>
        <li><a href="ejercicio1.php">Ejercicio 1</a><br></li> 
        <li> <a href="ejercicio2.php">Ejercicio 2</a><br></li> 
        
   </ul>

<?php
 
}

?>