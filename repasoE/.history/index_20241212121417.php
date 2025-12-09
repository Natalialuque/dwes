<?php


include_once(dirname(__FILE__) . "/cabecera.php");


if (isset($_POST["usuario"])) { //intento de inicio de sesión
    $vecesInicio = 0;
    if (isset($_COOKIE["contador"])) {
        $vecesInicio = $_COOKIE["contador"];
    }

    $vecesInicio += 2;
    setcookie("contador", $vecesInicio, time() + 60 * 60);


    if ($vecesInicio % 3 == 0) {
        inicioSesion("MULTIPLO", "MULTIPLO", $acceso, $acl);
    } else {
        inicioSesion("NOMUL", "NOMUL", $acceso, $acl);
    }
}

// carga de ficheros
if (isset($_POST["cargaFichero"])) {
    $objetosCargados = [];
    cargarProyectosDesdeFichero("pro.txt", $objetosCargados); //cargamos los objetos nuevos

    foreach ($objetosCargados as $objeto) { //los añadimos al array global
        array_push($PRO, $objeto);
    }
    $_SESSION["PRO"] = $PRO;
}

// if(isset($_POST["nuevoBenef"])){
//     header("location: /aplicacion/beneficiarios/nuevo.php");
//     exit;
// }



//destruccion de sesion
if (isset($_POST["salir"])) {
    $acceso->quitarRegistroUsuario();
    session_destroy();
}


inicioCabecera("EXAMEN");
// cabecera();
finCabecera();

inicioCuerpo("EXAMEN");
cuerpo($PRO, $acceso);
finCuerpo();


function cabecera() {}


function cuerpo(array $PRO, object $acceso)
{
?>
    <br>

    <?php

    formularioLogin($acceso);
    mostrarProyectos($PRO);


    if ($acceso->hayUsuario()) {
 
        cargaDesdeFichero();
        if ($acceso->puedePermiso(1)) {
        } else {
            echo "<h3>Sin permiso para consulta de datos</h3>";
        }
    } else {
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
        <?php
        if ($acceso->hayUsuario()) { ?>
            <form action="" method="post">
                <label for="">Salir de la sesion actual: &nbsp;</label>
                <input type="submit" name="salir" value="salir">
                <br><br>
                <hr>
                <label for="">Conectado actualmente como: <?php echo $acceso->getNick() ?> </label>
            </form>
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
    function inicioSesion(string $user, string $pass, object $acceso, object $acl)
    {

        if ($acl->esValido($user, $pass)) { //comprovmaos que el usuario y la contraseña son validos
            $users = $acl->dameUsuarios(); //recogemos los usuarios
            foreach ($users as $clave => $nick) {
                if ($nick == strtolower($user)) { //buscamos el relevante respecto a nuestro nick
                    $permisos = $acl->getPermisos($clave); //recogemos los datos de los permisos del user
                    $nombre = $acl->getNombre($clave); //recogemos el nombre del user
                    $acceso->registrarUsuario($nick, $nombre, $permisos); //hacemos el registro de la sesión para el usuario
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
    function mostrarProyectos(array $pro)
    {

?>

<br>
<textarea name="" id="" cols="80" rows="15"><?php

                                            foreach ($pro as $proyecto) {

                                                // // if(isset())
                                                // $otras= $proyecto->getDescripcionOtras();

                                                // if($otras != "") {
                                                //     echo $proyecto . "Otras propiedades: " . $otras;
                                                // }
                                                echo $proyecto . "\n";
                                            } ?>
    </textarea>


<?php

    }


    /**
     * Carga un formulario para cargar los beneficiarios que tengamos en el fichero designado
     *
     * @return void
     */
    function cargaDesdeFichero()
    {

?>

    <br>
    <hr>
    <form method="post">
        <label for="cargaFichero">Cargar fichero guardado: &nbsp;</label>
        <input type="submit" value="Cargar fichero" name="cargaFichero">
    </form>

<?php

    }




    function cargarProyectosDesdeFichero(string $nombreFichero, array &$datos): bool
    {

        //ruta en la que se cargara el fichero
        $ruta = RUTABASE .  "/ficheros/";

        //si no existe la ruta se crea
        if (!file_exists($ruta)) {
            mkdir($ruta);
        }

        $ruta .= $nombreFichero;
        //se abre el fichero para lectura
        //debe existir
        $fic = fopen($ruta, "r");
        if (!$fic)
            return false;
        //borro el contenido del array
        foreach ($datos as $pos => $valor) {
            unset($datos[$pos]);
        }

        //leo el fichero linea a linea
        while ($linea = fgets($fic)) {
            $linea = str_replace("\r", "", $linea);
            $linea = str_replace("\n", "", $linea);
            if ($linea != "") {
                $linea = mb_split("PROYECTO=", $linea); //descomponemos la información
                $linea = mb_split(":", $linea);
                $linea = mb_split(";", $linea);
                $objeto = new Proyecto($linea[2], $linea[4], $linea[6], $linea[8], $linea[10]);
                //cargamos el objeto

                for ($i = 10; $i < count($linea); $i = $i + 2) { //cargamos las  otras propeidades
                    $totalpropiedades = 0;
                    $objeto->aniadeOtras($linea[$i], $linea[$i + 1], $totalpropiedades);
                }

                //$datos[] = $objeto;
                array_push($datos, $objeto); //guardamos el objeto
            }
        }

        //se cierra el fichero
        fclose($fic);

        return true;
    }
