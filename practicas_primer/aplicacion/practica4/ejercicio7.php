<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador


$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 4"=> "./index.php",
 "Ejercicio 7"=>"ejercicio7.php"

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 4");
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
//ClaseMisPropiedades
    $Objeto = new ClaseMisPropiedades();
    $Objeto->propPublica = "publica";
    $Objeto->_propPrivada = "privada"; // Solo muestra aviso, no lanza error
    $Objeto->propiedad1 = 25;
    $Objeto->propiedad2 = "cadena de texto";

    echo "La propiedad 1 vale " . $Objeto->propiedad1 . "<br>";
    echo $Objeto->propiedad3; // Muestra aviso, devuelve null

        foreach ($Objeto as $clave => $valor) {
            echo "$clave => $valor<br>";
        }

}
?>