<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");


//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "../../index.php",
 "relacion 2"=> "./index.php",
 "Ejercicio 3"=>"ejercicio3.php"

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;

//controlador 
// Función A: usando array de caracteres válidos
function generarCadenaArray($longitud = 20) {
    $caracteres = [];

    // Letras minúsculas
    for ($i = ord('a'); $i <= ord('z'); $i++) {
        $caracteres[] = chr($i);
    }

    // Letras mayúsculas
    for ($i = ord('A'); $i <= ord('Z'); $i++) {
        $caracteres[] = chr($i);
    }

    // Números
    for ($i = ord('0'); $i <= ord('9'); $i++) {
        $caracteres[] = chr($i);
    }

    $cadena = "";
    for ($i = 0; $i < $longitud; $i++) {
        $cadena .= $caracteres[array_rand($caracteres)];
    }

    return $cadena;
}



// Función B: usando código ASCII y filtrando con ctype_alnum
function generarCadenaASCII($longitud = 20) {
    $validos = [];

    for ($i = 48; $i <= 122; $i++) {
        $char = chr($i);
        if (ctype_alnum($char)) {
            $validos[] = $char;
        }
    }

    $cadena = "";
    for ($i = 0; $i < $longitud; $i++) {
        $cadena .= $validos[array_rand($validos)];
    }

    return $cadena;
}

// Generamos las cadenas para mostrarlas en la vista
$cadenaArray = generarCadenaArray();
$cadenaASCII = generarCadenaASCII();

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 2");
cuerpo();  //llamo a la vista
finCuerpo();

function cabecera(){
   
}


//Aqui vamos añadir todo el codigo de las funciones matematicas
//vista

function cuerpo()
{
  global $cadenaArray, $cadenaASCII;
    ?>
    
    <h2>Cadena generada con array:</h2>
    <pre><?php echo $cadenaArray; ?></pre>

    <h2>Cadena generada usando código ASCII:</h2>
    <pre><?php echo $cadenaASCII; ?></pre>
    <?php  
}
?>