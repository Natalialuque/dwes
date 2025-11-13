<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

//controlador
$rutaweb = "/imagenes/";
$fichero="creado.jpg";
$rutaphp=RUTABASE.$rutaweb;
//if(!file_exists($rutaphp.$fichero)){
    //creo la imagen 
    $gd=imagecreatetruecolor(200,200);
    if(!$gd){
        exit;
    }
    $color=imagecolorallocate($gd,160,226,252);
    imagefilledrectangle($gd, 0,0,200,200,$color);

    $color=imagecolorallocate($gd,0,0,0);
    imageline($gd, 0,0,200,200,$color);

    imagejpeg($gd,$rutaphp.$fichero);

//}

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
    esta clase es de pruebas 

    <img src="/imagenes/creado.jpg" alt="imagencreada">
    
    
    <?php
  
 
}

?>