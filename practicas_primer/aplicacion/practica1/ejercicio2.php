<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

//controlador

function lanzaDado(){
    $resultados = [];
   
    for($i=1; $i<=6; $i++){
         $numero = rand(1, 6);
         switch ($numero) {
            case 1:
                $texto = "1";
                break;
            case 2:
                $texto = "2";
                break;
            case 3:
                $texto = "3";
                break;
            case 4:
                $texto = "4";
                break;
            case 5:
                $texto = "5";
                break;
            case 6:
                $texto = "6";
                break;
            default:
                $texto = "Error";
        }

         $resultados[] = "lanzamiento $i del dado: $numero";
    }

    return $resultados;

}


function lanzaDadoN(){
    $resultados2 = [];
    $n;

    for
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

    echo"<h2>LANZAMIENTO DE UN DADO</h2>";

    $resultados = lanzaDado();
    foreach ($resultados as $linea) {
    echo "<li>$linea</li>";
    }


    lanzaDadoN();

}
?>