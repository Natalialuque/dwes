<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once __DIR__ . "/../clases/RegistroTexto.php";

//controlador
//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "../../index.php",
 "Textos"

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;

//controlador

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
        <form action="" method="post">
            <label for="">Introduce el primer texto</label>
                <input type="text" name="textoprimero"> <br>
                <input type="submit" value="Registrar_texto" name="registrar">
                <input type="submit" value="Limpiar_todo" name="limpiar">
            <br>
            <br>
            <textarea name="" id="" style="margin-left: 5px; width:500px; height:300px;"></textarea>
        </form>
    <?php 
 
}

?>