<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

$PRO = $_SESSION["PRO"] ?? [];



//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "index.php",
 ];



//INICIO SESION 
if (isset($_POST["usuario"])) { //intento de inicio de sesión
    $vecesInicio = 0;
    if (isset($_COOKIE["contador"])) {
        $vecesInicio = $_COOKIE["contador"];
    }

    $vecesInicio += 2;
    setcookie("contador", $vecesInicio, time() + 60 * 60);


    if ($vecesInicio % 3 == 0) {
        inicioSesion("MULTIPLO", "MULTIPLO", $acceso, $aclArray);
    } else {
        inicioSesion("NOMUL", "NOMUL", $acceso, $aclArray);
    }
}



//cargamos ficheros 
if (isset($_POST["cargaFichero"])) {
    $objetosCargados = [];
    cargarProyectosDesdeFichero("pro.txt", $objetosCargados); //cargamos los objetos nuevos

    foreach ($objetosCargados as $objeto) { //los añadimos al array global
        array_push($PRO, $objeto);
    }
    $_SESSION["PRO"] = $PRO;
}

if (isset($_POST["modificar"])) {
    $id = $_POST["proyectosDisponibles"];
    $_SESSION["PRO"] = $PRO; // asegurar que está en sesión

    if ($id === "noExiste" || !isset($PRO[$id])) {
        paginaError("El proyecto seleccionado no existe");
        exit;
    }
    // Redirigir a la clase modificar.php con el id del proyecto
    header("Location: aplicacion/proyecto/modificar.php?id=" . $id);
    exit;
}



if (isset($_POST["exportar"])) {
    $id = $_POST["proyectosDisponibles"];
    $_SESSION["PRO"] = $PRO;

    if ($id === "noExiste" || !isset($PRO[$id])) {
        paginaError("El proyecto seleccionado no existe");
        exit;
    }
    header("Location: aplicacion/proyecto/datospro.php?id=" . $id);
    exit;
}




//destruccion de sesion
if (isset($_POST["salir"])) {
    $acceso->quitarRegistroUsuario();
    session_destroy();
}


//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("2DAW APLICACION");
cuerpo($PRO, $acceso);  //llamo a la vista
finCuerpo();
// **********************************************************



//vista
function cabecera() 
{}

//vista
function cuerpo(array $PRO,object $acceso)
{

    //formulario login 
    formularioLogin( $acceso);

    //mostrar proyectos 
    mostrarProyectos($PRO);
    if ($acceso->hayUsuario(1)) {
        //Aquí habría que mostrar las propiedades también 
        mostrarProyectosPropiedades($PRO);
    } else {
        echo "<h3>Sin permiso ver otros</h3>";
    }


    // Botón de carga de fichero
    cargaDesdeFichero();
    //formulario Acciones 
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





//boton de carga fichero 
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
 * funcion que carga los proyectos desde ficheros 
 */

function cargarProyectosDesdeFichero(string $nombreFichero, array &$datos): bool
{
    $ruta = RUTABASE . "/ficheros/";
    if (!file_exists($ruta)) {
        mkdir($ruta);
    }

    $ruta .= $nombreFichero;
    $fic = fopen($ruta, "r");
    if (!$fic) return false;

    // Vaciar el array recibido
    $datos = [];

    while ($linea = fgets($fic)) {
        // Limpieza de saltos de línea
        $linea = str_replace(["\r", "\n"], "", $linea);

        if ($linea != "") {
            // Separar datos del proyecto
            $linea = mb_split("PROYECTO=", $linea);
            $linea = preg_split("/;/", $linea[1]);

            $nombre = ""; 
            $empresa = ""; 
            $fecha1 = ""; 
            $fecha2 = ""; 
            $tipo = 10;

            foreach ($linea as $value) {
                $prop = mb_split(":", $value);
                if ($prop[0] == "nombre") $nombre = $prop[1];
                if ($prop[0] == "empresa") $empresa = $prop[1];
                if ($prop[0] == "fecha1") $fecha1 = $prop[1];
                if ($prop[0] == "fecha2") $fecha2 = $prop[1];
                if ($prop[0] == "tipo") $tipo = $prop[1];
            }

            // Intentar crear el proyecto
            try {
                $objeto = new Proyecto($nombre, $empresa, $fecha1, $fecha2, $tipo);
            } catch (Exception $e) {
                echo "No todos los proyectos han podido ser cargados<br>";
                $objeto = null; // marcar como no válido
            }

            // Solo si el objeto se creó correctamente
            if (isset($objeto)) {
                // Cargar propiedades adicionales si las hay
                for ($i = 5; $i < count($linea); $i += 2) {
                    $totalpropiedades = 0;
                    $objeto->aniadeOtras($linea[$i], $linea[$i + 1], $totalpropiedades);
                }

                // Guardar el objeto en el array
                $datos[] = $objeto;
            }
        }
    }

    fclose($fic);
    return true;
}


/**
     * Método que carga un textarea con todos los proyectos sin las 
     * propiedades adicionales
     *
     * @param array $PRO
     * @return void
     */
    function mostrarProyectos(array $PRO)
    {

            ?>

        <br>
        <textarea name="" id="" cols="80" rows="15"><?php

                 foreach ($PRO as $proyecto) {
                    echo "- " . $proyecto . "\n";
                } ?>
            </textarea>


        <?php

    }


    /**
     * Función para mostrar los proyectos con las propiedades
     *
     * @param array $pro
     * @return void
     * 
     */
    function mostrarProyectosPropiedades(array $pro)
    {
    echo '<br><textarea name="" id="" cols="80" rows="15">';
    
    foreach ($pro as $proyecto) {
        echo "- " . $proyecto . "\n";

        $otras = $proyecto->getDescripcionOtras();
        if (is_object($otras)) {
            foreach ($otras as $clave => $valor) {
                echo "   $clave: $valor\n";
            }
        }
    }
        echo '</textarea>';
    }


    /**
     * Formulario para modificar o exportar
     *
     * @param [type] $PRO
     * @return void
     * 
     */
    function formularioAcciones(array $PRO)
{
    ?>
    <form action="" method="post">
        <legend>Acciones</legend>
        <select name="proyectosDisponibles" id="proyectosDisponibles">
            <optgroup label="Proyectos">
                <?php
                // Mostrar todos los proyectos disponibles
                foreach ($PRO as $key => $value) {
                    echo "<option value='$key'>" . $value->getNombre() . "</option>";
                }
                ?>
                <!-- Línea adicional con un proyecto que no exista -->
                <option value="noExiste">Proyecto inexistente</option>
            </optgroup>
        </select>
        <br><br>
        <input type="submit" class="boton" name="modificar" value="Modificar">
        <input type="submit" class="boton" name="exportar" value="Exportar">
    </form>
    <?php
}