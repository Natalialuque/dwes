<?php


include_once(dirname(__FILE__) . "/cabecera.php");


    if(isset($_POST["usuario"])){//intento de inicio de sesión
        $vecesInicio=0;
        if(isset($_COOKIE["contador"])){
                $vecesInicio = $_COOKIE["contador"];
            }

        $vecesInicio++;
        setcookie("contador", $vecesInicio, time() + 60 * 60);
            

        if($vecesInicio % 3 == 0){
            inicioSesion("MULTIPLO", "MULTIPLO", $acceso, $acl);
        }
        else{
            inicioSesion("NOMUL", "NOMUL", $acceso, $acl);
        }

    }

    //carga de ficheros
//     if(isset($_POST["cargaFichero"])){
//         $objetosCargados = [];
//         cargarBeneficiarioDesdeFichero("a_incorporar.txt", $objetosCargados);//cargamos los objetos nuevos

//         foreach($objetosCargados as $objeto){//los añadimos al array global
//             array_push($benefi, $objeto);
//         }
//         $_SESSION["BENEFI"]=$benefi;

//     }

//     if(isset($_POST["nuevoBenef"])){
//         header("location: /aplicacion/beneficiarios/nuevo.php");
//         exit;
//     }

    

//     //destruccion de sesion
//     if (isset($_POST["salir"])) {
//         $acceso->quitarRegistroUsuario();
//         session_destroy();
//     }
// }

inicioCabecera("EXAMEN");
// cabecera();
finCabecera();

inicioCuerpo("EXAMEN");
cuerpo($PRO, $acceso);
finCuerpo();


function cabecera()
{

}


function cuerpo(array $PRO, object $acceso)
{
?>
    <br>

    <?php

    formularioLogin($acceso);


    if ($acceso->hayUsuario()) {

        if($acceso->puedePermiso(2)){
            mostrarProyectos($PRO);
        }
        else{
            echo "<h3>Sin permiso para consulta de datos</h3>";
        }


        
    }
    else{
        echo "<h3>Sin permiso para consulta de datos</h3>";
    }
}



function formularioLogin(object $acceso)
{

?>

    <form method="post">

        <?php

        if ($acceso->hayUsuario()) {
            echo $acceso->getNick();
        } else {
            echo "<p>No hay usuario conectado</p>";
        }

        ?>

        <input type="submit" value="inicio Sesion" name="usuario">

    </form>
<?php
     if ($acceso->hayUsuario())
         {?>
    <hr>
    <form action="" method="post">
        <label for="">Salir de la sesion actual: &nbsp;</label>
        <input type="submit" name="salir" value="salir">
        <br><br>
        <hr>
        <label for="">Conectado actualmente como: <?php echo $acceso->getNick() ?> </label>
    </form>
<?php
         }


}

/**
 * Inicializamos el usuario con los datos recogidos
 *
 * @param string $user
 * @param string $pass
 * @return void
 */
function inicioSesion(string $user, string $pass, object $acceso, object $acl){

    if ($acl->esValido($user, $pass)) {//comprovmaos que el usuario y la contraseña son validos
        $users = $acl->dameUsuarios();//recogemos los usuarios
        foreach ($users as $clave => $nick) {
            if ($nick == strtolower($user)) {//buscamos el relevante respecto a nuestro nick
                $permisos = $acl->getPermisos($clave);//recogemos los datos de los permisos del user
                $nombre = $acl->getNombre($clave);//recogemos el nombre del user
                $acceso->registrarUsuario($nick, $nombre, $permisos);//hacemos el registro de la sesión para el usuario
            } //if
        } //foreach
    } //if validacion

}

/**
 * Método que carga un textarea con todos los beneficiarios guardados
 *
 * @param array $benefi
 * @return void
 */
function mostrarProyectos(array $pro){

    ?>

    <br>
    <textarea name="" id="" cols="80" rows="15"><?php 
        
        foreach($pro as $proyecto){ 
            
            if(isset(&))
            $otras= $proyecto->getDescripcionOtras();

            if($otras != "") {
                echo $proyecto . "Otras propiedades: " . $otras;
            }
            else echo $proyecto;

            } ?>
    </textarea>


    <?php

}


