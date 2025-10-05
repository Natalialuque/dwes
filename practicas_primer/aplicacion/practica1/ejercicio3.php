<?php

include_once(dirname(__FILE__) . "/../../cabecera.php");

//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "../../index.php",
 "relacion 1"=> "./index.php",
 "Ejercicio 3"=>"ejercicio3.php"

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;


///////////CONTROLADOR//////////
//Hacer lo anterior creando y rellenando el array usando varias sentencias.  
// Array 1: índice numérico
$array1 = [];
$array1[1]=2;
$array1[16]=17;
$array1[54]=55;
$array1[]=34; //variables final

//Array2
$array2 = [];
$array2["uno"] = "vaffanculo";
$array2["dos"] = true;
$array2["tres"] = 1.345;

// Array 3: índice "última"
$array3 = [];
$array3["última"] = [1, 3, 4, "nueva"];

//Hacer lo anterior usando una sola sentencia con array;
$array4 = [1 => "valor1", 16 => "valor16", 54 => "valor54", 34];
$array5 = ["uno" => "cadena", "dos" => true, "tres" => 1.345];
$array6 = ["última" => [1, 3, 4, "nueva"]];



///////////////////////////////////////////////////////////////////////
//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
finCabecera();
inicioCuerpo("Practica 1");
cuerpo($array1,$array2,$array3,$array4,$array5,$array6);  //llamo a la vista
finCuerpo();

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

///////////////////////////////////////////////////////////////////////

//vista

function cuerpo($array1,$array2,$array3,$array4,$array5,$array6){

    echo "<h3>Array 1</h3>";
    foreach ($array1 as $key => $value) {
    echo "[$key] => $value<br>";
    }

    echo "<h3>Array 2</h3>";
     foreach ($array2 as $key => $value) {
    echo "[$key] => $value<br>";
    }

     echo "<h3>Array 3</h3>";
     foreach ($array3 as $key => $value) {
    echo "[$key] => $value<br>";
    }

     echo "<h3>Array 4</h3>";
     foreach ($array4 as $key => $value) {
    echo "[$key] => $value<br>";
    }

     echo "<h3>Array 5</h3>";
     foreach ($array5 as $key => $value) {
    echo "[$key] => $value<br>";
    }

     echo "<h3>Array 6</h3>";
     foreach ($array6 as $key => $value) {
    echo "[$key] => $value<br>";
    }


}


?>