<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "../../index.php",
 "Personalizar"

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
    <!-- CREAMOS EL FORMULARIO A ELEGIR -->
    <form method="post" action="">
        <label id="colorFondo">Color de fondo</label>
        <select name="fondo" id="fondo">
            <option value="COLORESFONDO[0]"selected><?= (COLORESFONDO[0])?></option>
            <option value="COLORESFONDO[1]"><?= (COLORESFONDO[1])?></option>
            <option value="COLORESFONDO[2]"><?= (COLORESFONDO[2])?></option>
            <option value="COLORESFONDO[3]"><?= (COLORESFONDO[3])?></option>
            <option value="COLORESFONDO[4]"><?= (COLORESFONDO[4])?></option>

        </select>
        <br>
        <label id="colorLetras">Color de letras</label>
        <select name="letras" id="letras">
            <option value="COLORESTEXTO[0]"selected><?= (COLORESTEXTO[0])?></option>
            <option value="COLORESTEXTO[1]"><?= (COLORESFONDO[1])?></option>
            <option value="COLORESTEXTO[2]"><?= (COLORESFONDO[2])?></option>
            <option value="COLORESTEXTO[3]"><?= (COLORESFONDO[3])?></option>
        </select>
        <br>
       <button id="boton subir">Subirr</button>
    </form>
  
 <?php
}

?>