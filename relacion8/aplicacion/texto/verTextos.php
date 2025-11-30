<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once __DIR__ . "/../clases/RegistroTexto.php";

// si no hay sesion iniciada le manda a login
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}
//controlador
//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "../../index.php",
 "Textos"

 ];


//controlador

$textos = $_SESSION["textos"] ?? [];

if(isset($_POST["registrar"])){
    $texto = new RegistroTexto($_POST["textoprimero"]);
    array_push($textos,$texto);
}
if(isset($_POST["limpiar"])) {
    $textos=[];
}

$_SESSION["textos"] = $textos;



// si le da al boton de cerrar sesion quita el usuario
if(isset($_POST["cerrarSesion"])) $acceso->quitarRegistroUsuario();

// no tiene el permiso uno no puede entrar a la pagina
if(!$acceso->puedePermiso(1)){
     paginaError("No tienes permiso para acceder a esta página");
     exit;
}


///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($textos);  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo($textos) {

   ?>
        <form action="" method="post">
            <label for="">Introduce el primer texto</label>
                <input type="text" name="textoprimero"> <br>
                <input type="submit" value="Registrar_texto" name="registrar">
                <input type="submit" value="Limpiar_todo" name="limpiar">
            <br>
            <br>
            <textarea name="" id="" style="margin-left: 5px; width:500px; height:300px;"><?php
                foreach ($textos as $t) {
                    echo $t->getFechaHora() . " - " . $t->getCadena();
                  }
            ?></textarea>
            <br>
        </form>
    <?php 
 
}

?>