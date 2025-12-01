<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// no tiene el permiso uno no puede entrar a la pagina
if(!$acceso->puedePermiso(3)){
     paginaError("No tienes permiso");
     exit;
}
//controlador

if(isset($_POST["subir"])){

    //comprobar nick

    //comprobar nombre 

    //comprobar nif

    //comprobar direccion 

    //comprobar poblacion 

    //comprobar provincia 

    //comprobar cp

    //comprobar fecha nacimiento 

    //comprobar borrado

    //comprobar foto


}


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
    formulario();
}


function formulario(){
?>
<h3>NUEVO USUARIO</h3>
 <form action="" method="post">
    <label>Nick:</label>
    <input type="text" name="nick" id="nick"> 
    <br>
    <label>Nombre:</label>
    <input type="text" name="nombre" id="nombre">
     <br>
    <label>Nif:</label>
    <input type="text" name="nif" id="nif">
     <br>
    <label>Direccion:</label>
    <input type="text" name="direccion" id="direccion">
    <br>
    <label>Poblacion:</label>
    <input type="text" name="poblacion" id="poblacion">
    <br>
    <label>Provincia:</label>
    <input type="text" name="provincia" id="provincia">
    <br>
    <label>CP:</label>
    <input type="text" name="cp" id="cp">
     <br>
    <label>fecha Nacimiento:</label>
    <input type="text" name="fechaNaci" id="fechaNaci">
     <br>
    <label>Borrado:(0-no // 1-si) </label>
    <input type="text" name="borrado" id="borrado">
     <br>
    <label>Foto:(no obligatorio) </label>
    <input type="text" name="foto" id="foto">

    <br>
    <input type="submit" value="Registrar usuario" name="subir">
    <br>
    <a href="index.php">Volver a la tabla</a>
</form>

<?php


    
}

?>