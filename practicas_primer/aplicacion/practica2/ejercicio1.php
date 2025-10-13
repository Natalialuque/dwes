<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");


//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "../../index.php",
 "relacion 2"=> "./index.php",
 "Ejercicio 1"=>"ejercicio1.php"

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;


//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 2");
cuerpo();  //llamo a la vista
finCuerpo();

function cabecera(){
   
}

//vista
function cuerpo(){

    //comillas dobles y mostramos
    echo "<h3>CADENA COMILLAS DOBLES</h3>";
    $cad="Comillas dobles y caracteres especiales á, é, ñ"; //definicion de cadena con "
    echo $cad;

    //comillas simples y mostramos
    echo "<h3>CADENA COMILLAS SIMPLES</h3>";
    $cad2='Comillas simes con etiquetas html <h4>JoJoJo</h4>'; //definicion de cadena con '
    echo $cad2;


    //cadena de heredoc y mostramos
    echo "<h3>CADENA HEREDOC</h3>";
    $nombre="Jorge";
    $texto=<<<fin
            Mi querida amiga <br />
            escribo estas líneas esperando que me leas. <br />
            Es de <b>VITAL</b> importancia que me contestes. <br />
            Firmado: $nombre<br />
            fin;
    echo$texto;


    //cadena NowDoc
    //No el usuario porque es texto plano y las cadenas NOWDOC no las reconoce
    echo "<h3> Cadenas NOWDOC </h3>";
    $usuario = "Natalia";
    $contenido = <<<'fin'
    <p>Bienvenida: $usuario</p>
    <p>Este texto contiene etiquetas como <strong> y <em>, además de caracteres especiales: á, é, ñ, ‘, “.</p>
    fin;
    echo$contenido;

}