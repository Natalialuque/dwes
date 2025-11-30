<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

//controlador
$ubicacion = [
 "area personal"=> "../../index.php",
 "indice principal Usuarios"=> "",

 ];

//conectar a la base de datos 
$bd= @new mysqli($servidor,$usuario,$contraseña,$baseDatos);

//compruebo si se ha 
if($mysqli -> connect_error)
{
    paginaError("Fallo al conectar en mySql:" . $bd-> connect_error);
    exit;
}else {
    echo"conecta correctamente";
}

$sentencia = "select * from usuarios";
$consulta = $bd->query($sentencia);
 



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

}

?>