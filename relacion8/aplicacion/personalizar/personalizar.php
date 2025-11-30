<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// si no hay sesion iniciada le manda a login
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}


//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "../../index.php",
 "Personalizar"

];

/**cuando caduca la cookie */
if(isset($_POST["cambiarColores"])) {
    setcookie("colorTexto",$_POST["letras"],time()+3600*24*30, "/");
    setcookie("colorFondo",$_POST["fondo"],time()+3600*24*30, "/");
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}

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
cuerpo($acceso);  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

function formulario ($acceso){
?>
    <!-- CREAMOS EL FORMULARIO A ELEGIR RECORREMOS LOS ARRAY DE COLORES PARA MOSTRARLOS-->
    <form method="post" action="">
        <label id="colorFondo">Color de fondo</label>
        <select name="fondo" id="fondo">
           <?php
               foreach(COLORESFONDO as $color){
                echo"<option value=$color>$color</option>";
               }
                ?>
        </select>
        <br>
        <label id="colorLetras">Color de letras</label>
        <select name="letras" id="letras">
           <?php
               foreach(COLORESTEXTO as $color){
                echo"<option value=$color>$color</option>";
               }
                ?>
        </select>
        <br>
       <?php if($acceso->puedePermiso(2)) { ?>
              <input type="submit" value="cambiar los colores" name="cambiarColores">
        <?php 
        } 
        else {?>
             <p style="color: red;">No tienes permisos para modificiar los colores</p>
        <?php 
        }
        ?>  
    </form>
  
 <?php
}

//vista
function cuerpo($acceso) {

    formulario($acceso);
}

?>