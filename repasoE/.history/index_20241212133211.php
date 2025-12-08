<?php


include_once(dirname(__FILE__) . "/cabecera.php");

$ubicacion = [
    [
        "posicion" => "Inicio",
        "direccion" => ""
    ]
];

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


if (isset($_POST["modificar"])) {
    header("location: aplicacion/proyecto/modificar.php");
    exit;
}


if (isset($_POST["descargar"])) {
    header("location: aplicacion/proyecto/datospro.php");
    exit;
}






//destruccion de sesion
if (isset($_POST["salir"])) {
    $acceso->quitarRegistroUsuario();
    session_destroy();
}


inicioCabecera("EXAMEN");
cabecera();
finCabecera();

inicioCuerpo("EXAMEN", $ubicacion);
cuerpo($PRO, $acceso);
finCuerpo();


function cabecera() {}


function cuerpo(array $PRO, object $acceso)
{
?>
    <br>
    <?php
    //Cargar todos los datos que son independientes de si hay usuario conectado
    formularioLogin($acceso);
    mostrarProyectos($PRO);
    if ($acceso->hayUsuario(1)) {
        //Aquí habría que mostrar las propiedades también 
        //mostrarProyectosPropiedades();
    } else {
        echo "<h3>Sin permiso ver otros</h3>";
    }
    cargaDesdeFichero();
    formularioAcciones($PRO);
}

/**
 * Formulario para iniciar sesión
 *
 * @param object $acceso
 * @return void
 */
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
     * Iniciar sesión
     *
     * @param string $user
     * @param string $pass
     * @return void
     */
    function inicioSesion(string $user, string $pass, object $acceso, object $acl)
    {

        if ($acl->esValido($user, $pass)) {
            $users = $acl->dameUsuarios();
            foreach ($users as $clave => $nick) {
                if ($nick == strtolower($user)) {
                    $permisos = $acl->getPermisos($clave);
                    $nombre = $acl->getNombre($clave);
                    $acceso->registrarUsuario($nick, $nombre, $permisos);
                }
            }
        }
    }

    /**
     * Método que carga un textarea con todos los proyectos sin las 
     * propiedades adicionales
     *
     * @param array $pro
     * @return void
     */
    function mostrarProyectos(array $pro)
    {

?>

<br>
<textarea name="" id="" cols="80" rows="15"><?php

                                            foreach ($pro as $proyecto) {
                                                echo "- " . $proyecto . "\n";
                                            } ?>
    </textarea>


<?php

    }


    /**
     * Carga un formulario para cargar los proyectos desde un fichero
     *
     * @return void
     */
    function cargaDesdeFichero()
    {
?>
    <hr>
    <form method="post">
        <label for="cargaFichero">Cargar fichero guardado: &nbsp;</label>
        <input type="submit" value="Cargar fichero" name="cargaFichero">
    </form>

<?php
    }

    /**
     * Función para cargar los proyectos desde un fichero
     *
     * @param string $nombreFichero
     * @param array $datos
     * @return boolean
     */
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
            $reg = "/;:/";
            if ($linea != "") {
                $linea = mb_split("PROYECTO=", $linea); //descomponemos la información
                // $linea = mb_split(":", $linea);
                $linea = preg_split($reg, $linea[1]);
                // $linea = explode(";", $linea);
                echo "aqui";

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


    /**
     * Función para mostrar los proyectos con las propiedades
     *
     * @param array $pro
     * @return void
     */
    function mostrarProyectosPropiedades(array $pro)
    {

?>

    <br>
    <textarea name="" id="" cols="80" rows="15">

    <?php

        foreach ($pro as $proyecto) {

            if ($proyecto->getDescripcionOtras() != "") {

                $otras = $proyecto->getDescripcionOtras();
                echo $proyecto . "Otras propiedades: " . $otras;
            }
    ?>
    </textarea>


<?php

        }
    }


    /**
     * Formulario para modificar o exportar
     *
     * @param [type] $PRO
     * @return void
     */
    function formularioAcciones($PRO)
    {

?>
<form action="" method="post">
    <legend>Acciones</legend>
    <select name="proyectosDisponibles" id="proyectosDisponibles">
        <optgroup label="Proyectos">
            <?php
            foreach ($PRO as $key => $value) {
                echo "<option value ='$key' >" . $value->getNombre() . " </option>";
            }
            ?>

        </optgroup>
    </select>
    <input type="submit" class="boton" name="modificar" value="Modificar" id="modificar">
    <input type="submit" class="boton" name="exportar" value="exportar" id="exportar">
</form>

<?php




    }
