<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// si no hay sesion iniciada le manda a login
if (!$acceso->hayUsuario()) {
    $_SESSION["redirigir_a"] = $_SERVER["REQUEST_URI"];
    header("Location: /aplicacion/acceso/login.php");
    exit;
}


//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "../../index.php",
 "Personalizar"

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;

if(isset($_POST["cambiarColores"])) {
    setcookie("colorTexto",$_POST["letra"],time()+3600*24*30, "/");
    setcookie("colorFondo",$_POST["fondo"],time()+3600*24*30, "/");
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

// si le da al boton de cerrar sesion quita el usuario
if(isset($_POST["cerrarSesion"])) $acceso->quitarUsuario();

// si no tiene el permiso uno no puede entrar a la pagina
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