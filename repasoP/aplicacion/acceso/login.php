<?php
include_once(dirname(__FILE__) . "../../../cabecera.php");

$datos = [
    "fondo" => "",
    "texto" => "",
];

if (isset($_COOKIE["numVisitas"])) {
    $_COOKIE["numVisitas"]++;
}

if ($_POST) {

    if (isset($_POST["validacion"])) {//comprobamos que existen los datos
        if ($aclComprobacion->esValido($_POST["user"], $_POST["pass"])) {//comprovmaos que el usuario y la contraseña son validos
            $users = $aclComprobacion->dameUsuarios();//recogemos los usuarios
            foreach ($users as $clave => $nick) {
                if ($nick == strtolower($_POST["user"])) {//buscamos el relevante respecto a nuestro nick
                    $permisos = $aclComprobacion->getPermisos($clave);//recogemos los datos de los permisos del user
                    $nombre = $aclComprobacion->getNombre($clave);//recogemos el nombre del user
                    $acceso->registrarUsuario($nick, $nombre, $permisos);//hacemos el registro de la sesión para el usuario
                } //if
            } //foreach
        } //if validacion

        if ($acceso->hayUsuario()) {//si conectamos de forma correcta con el usuario volvemos al inicio
            header("location: ../../index.php");
        }
    } //if isset

}

inicioCabecera("APLICACION PRUEBA");
cabecera();
finCabecera();

inicioCuerpo("APLICACION PRUEBA");
cuerpo($datos, $acceso);
finCuerpo();

// **********************************************************

function cabecera()
{
}


function cuerpo(array $datos, $acceso)
{
?>

    <?php

    echo  "<label for=''>Número de veces que se visitó la página web </label>" . (isset($_COOKIE["numVisitas"]) ? $_COOKIE["numVisitas"] : 1);
    echo "<br><br>";

    formulario($datos);



    ?>

<?php

}


/**
 * Formulario para cambiar los colores
 *
 * @return void
 */
function formulario()
{

?>

    <form action="" method="post">

        <label for="">Usuario: &nbsp;</label>
        <input type="text" name="user" id="user">
        <br><br>
        <label for="">Contraseña: &nbsp;</label>
        <input type="password" name="pass" id="pass">

        <br><br>
        <input type="submit" name="validacion" value="validacion">

    </form>

<?php
}
