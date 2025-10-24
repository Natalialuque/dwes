<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador


$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 4"=> "./index.php",
 "Ejercicio 1"=>"ejercicio1.php"
 

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
//InstrumentoBase
echo"<h4>Esta clase no funciona en si, es una clase padre de la que 
        necesitamos cosas para el funcionamiento del resto de clase</h4>";

// Para clase pública
    // $instrumentoBase = new InstrumentoBase("Flauta dulce");
    // $instrumentoBase2 = new InstrumentoBase("El viento", 12);

    // echo $instrumentoBase;
    // echo $instrumentoBase2;

    // $instrumentoBase2->envejecer();
    // echo "Edad después de envejecer: " . $instrumentoBase2->getEdad() . "<br>";    

    // echo $instrumentoBase->afinar() . "<br>";

    // echo $instrumentoBase->sonido("aire") . "<br>"; 

}
?>