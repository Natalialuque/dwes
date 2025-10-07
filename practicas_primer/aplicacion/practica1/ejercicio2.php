<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");


//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "../../index.php",
 "relacion 1"=> "./index.php",
 "Ejercicio 2"=>"ejercicio2.php"

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;


//controlador

function lanzaDado(){
    $resultados = [];
   
    for ($i = 1; $i <= 6; $i++) {
        $numero = rand(1, 6);

        // No es necesario el switch si solo usas el número directamente
        $resultados[] = "Lanzamiento $i del dado: $numero";
    }

    return $resultados;
 }

//constante 
define('NUM_LANZAMIENTOS', 1000);

function lanzaDadoN(){
 $conteo = array_fill(1, 6, 0);

    for ($i = 0; $i < NUM_LANZAMIENTOS; $i++) {
        $numero = rand(1, 6);

        switch ($numero) {
            case 1: $conteo[1]++; break;
            case 2: $conteo[2]++; break;
            case 3: $conteo[3]++; break;
            case 4: $conteo[4]++; break;
            case 5: $conteo[5]++; break;
            case 6: $conteo[6]++; break;
        }
    }

    $resultados = [];
    foreach ($conteo as $cara => $cantidad) {
        $porcentaje = round(($cantidad / NUM_LANZAMIENTOS) * 100, 1);
        $resultados[] = "El $cara ha salido $cantidad veces con un porcentaje de $porcentaje%";
    }

    return $resultados;    

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


///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("2DAW APLICACION");
cuerpo();  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}



//vista
function cuerpo(){

    echo "<h2>LANZAMIENTO DE UN DADO (6 veces)</h2>";
    echo "<ul>";
    $resultados = lanzaDado();
    foreach ($resultados as $linea) {
        echo "<li>$linea</li>";
    }
    echo "</ul>";

    echo "<h2>Lanzado el dado " . NUM_LANZAMIENTOS . " veces</h2>";
    echo "<ul>";
    $estadisticas = lanzaDadoN();
    foreach ($estadisticas as $linea) {
        echo "<li>$linea</li>";
    }
    echo "</ul>";



}
?>