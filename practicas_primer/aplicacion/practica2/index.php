<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador


$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 2"=> "./index.php",

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 2");
cuerpo();  //llamo a la vista
finCuerpo();
//rururur
// **********************************************************

//vista
function cabecera() 

{
    
}

//vista
function cuerpo()
{
?>
    <h1>RELACIÓN 2: Gestión de cadenas</h1>
    <ul>
        <li><a href="ejercicio1.php">Ejercicio 1</a><br></li> 
        <li> <a href="ejercicio2.php">Ejercicio 2</a><br></li> 
        <li><a href="ejercicio3.php">Ejercicio 3</a><br></li> 
        <li> <a href="ejercicio4.php">Ejercicio 4</a><br></li> 
        <li> <a href="ejercicio5.php">Ejercicio 5</a><br></li> 
        <li><a href="ejercicio6.php">Ejercicio 6</a><br></li> 
        <li><a href="ejercicio7.php">Ejercicio 7</a><br></li> 
   </ul>

<?php
}