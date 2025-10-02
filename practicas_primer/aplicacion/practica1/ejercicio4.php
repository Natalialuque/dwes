<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

//controlador

function triangulo (){
    define ("filas",5);

    $array = [];

    for($i = 1;$i <= filas; $i++){
        $fila=[];
        for($j = 1;$j <= $i; $j++){
            $fila[]= $i;
    }
    $array[]= $fila;
}
return $array;
}

///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 1");
cuerpo();  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo(){

     $array = triangulo();
   
     foreach ($array as $linea => $fila ) {
        foreach($fila as $valor){
            echo "{$valor}";
        }
        echo "<br>";
    }


}
?>