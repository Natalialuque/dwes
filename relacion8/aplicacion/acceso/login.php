<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "login" => "/aplicacion/acceso/login.php"
];

$datos = [
    "cod" => "",
    "usuario" => "",
    "nombre" => "",
    "passwd" => "",
    "permisos" => ""
];

$errores=[];

if(isset($_POST["registro"])) {
    $usuario = $_POST["usuario"] ?? "";
    $contraseña = $_POST["passwd"] ?? "";


    if($aclArray->esValido($usuario,$contraseña)) {
        $datos["cod"]=$aclArray->getCodUsuario($usuario);
        $datos["usuario"]=$usuario;
        $datos["nombre"]=$aclArray->getNombre($aclArray->getCodUsuario($usuario));
        $datos["passwd"]=$contraseña;
        $datos["permisos"]=$aclArray->getPermisos($aclArray->getCodUsuario($usuario));    
        
        $acceso->registrarUsuario($datos["usuario"], $datos["nombre"],$datos["permisos"]);
        header("Location: /index.php");
        exit;
    }
    else $errores["login"][] = "Error al iniciar sesión";
}

// Dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($datos,$errores);  //llamo a la vista
finCuerpo();

// **********************************************************

function formulario($errores) {

    if ($errores) { //mostrar los errores
        echo "<div class='error'>";
        foreach ($errores as $clave => $valor) {
            foreach ($valor as $error)
                echo "$clave => $error<br>" . PHP_EOL;
        }
        echo "</div>";
    }

?>

    <form action="" method="post">
        <label for="">Usuario</label>
        <input type="text" name="usuario" id="usuario"><br>
        <label for="">Contraseña</label>
        <input type="password" name="passwd" id="passwd"><br>
        <input type="submit" value="Login" name="registro">
    </form>

    <?php
}


function cabecera() {}
//vista
function cuerpo($datos, $errores)
{
    if (empty($errores) && isset($_POST["guardar"])) {
        formulario($errores);
    } else {
        formulario($errores);
    }
?>  


<?php


}