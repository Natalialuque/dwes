<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// no tiene el permiso uno no puede entrar a la pagina
if(!$acceso->puedePermiso(3)){
     paginaError("No tienes permiso");
     exit;
}
//controlador






//comrpobar que el codigo existe
if(isset($_POST["ver"])){

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
     fomrularioVer();
}

function fomrularioVer(){
     ?>
     <h3>VER USUARIO</h3>
      <form action="" method="post">
     <label>Introduce el codigo</label>
     <input type="text" id="cod_usuario" name="codigo">
     <br>
    <input type="submit" value="Ver usuario" name="ver">
    <br>
    <a href="index.php">Volver a la tabla</a>
     </form>

     <?php
}

?>