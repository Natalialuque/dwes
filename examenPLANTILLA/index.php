<!-- ESTE INDEX ESTA CARGADO DE OTROS EXAMENES, TEN CUIDADO Y CAMBIA TODO BIEN -->

<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

$COL = $_SESSION["COL"] ?? [];

//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "index.php",

 ];

 /*
  * login
  */
 if (isset($_POST["usuario"])) { //intento de inicio de sesión
    $vecesInicio = 0;
    if (isset($_COOKIE["contador"])) {
        $vecesInicio = $_COOKIE["contador"];
    }

    $vecesInicio += 2;
    setcookie("contador", $vecesInicio, time() + 60 * 60);


    if ($vecesInicio % 3 == 0) {
        inicioSesion("MULTIPLO", "MULTIPLO", $acceso, $aclArray);
    }
 }


 /**
  * para hacer la carga
  */
  if (isset($_POST["cargaFichero"])) {
     $objetosCargados = [];
    cargarProyectosDesdeFichero("coleccion.txt", $objetosCargados); //cargamos los objetos nuevos

    foreach ($objetosCargados as $objeto) { //los añadimos al array global
        array_push($COL, $objeto);
    }
     $_SESSION["COL"] = $COL;
 }


/**
 * modificar
 */
 if (isset($_POST["modificar"])) {
     $id = $_POST["ColecionesDisponibles"];
     $_SESSION["COL"] = $COL; // asegurar que está en sesión

     if ($id === "noExiste" || !isset($COL[$id])) {
         paginaError("La coleccion seleccionada no existe");
       exit;
     }
     // Redirigir a la clase modificar.php con el id de la coleciones
     header("Location: aplicacion/colecciones/modificar.php?id=" . $id);
     exit;
 }


/**
 * enviar 
 */
if (isset($_POST["exportar"])) {
    $id = $_POST["ColecionesDisponibles"];
    $_SESSION["COL"] = $COL;

    if ($id === "noExiste" || !isset($COL[$id])) {
        paginaError("La coleccion seleccionado no existe");
        exit;
    }
    header("Location: aplicacion/colecciones/enviar.php?id=" . $id);
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
cuerpo($COL,$acceso);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{}

//vista
function cuerpo(array $COL,object $acceso)
{
//inicio login 
formularioLogin($acceso);

//mostrar colecciones teniendo en cuenta que permiso tiene
    mostrarColeciones($COL);
    
    if ($acceso->hayUsuario(1)) {
        //Aquí habría que mostrar las colleciones también 
        mostrarColecionesPropiedades($COL);
    } else {
        echo "<h3>Sin permiso ver otros</h3>";
    }

//Boton de carga de fichero 
    cargaDesdeFichero();
//Formulario de Acciones donde modificiamos o descargamos
    formularioAcciones($COL);

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
 * Boton carga fichero
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
 * funcion que carga los coleciones desde ficheros 
 */

function cargarColeccionDesdeFichero(string $nombreFichero, array &$datos): bool
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
            // Separar datos del colecciones
            $linea = mb_split("COLECCIONES=", $linea);
            $linea = preg_split("/;/", $linea[1]);

            $nombre = ""; 
            $fecha = ""; 
            $tematica = 10;
            $tematicaDescripcion="";

            foreach ($linea as $value) {
                $col = mb_split(":", $value);
                if ($col[0] == "nombre") $nombre = $col[1];
                if ($col[0] == "fecha") $fecha = $col[1];
                if ($col[0] == "tematica") $tematica = $col[1];
                if ($col[0] == "tematicaDescripcion") $tematicaDescripcion = $col[1];
            }

            // Intentar crear la coleecion
            try {
                $objeto = new Coleccion($nombre,$fecha, $tematica, $tematicaDescripcion);
            } catch (Exception $e) {
                echo "No todos las colecciones han podido ser cargadas<br>";
                $objeto = null; // marcar como no válido
            }

            // Solo si el objeto se creó correctamente
            if (isset($objeto)) {
                // Cargar coleciones adicionales si las hay
                for ($i = 5; $i < count($linea); $i += 2) {
                    $totalColleciones = 0;
                    $objeto->aniadelirbo($linea[$i], $linea[$i + 1], $totalColleciones);
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
* rellena el text area directamente con la coleccion 
*
* @param array $COL
* @return void
*/
 function mostrarColeciones(array $COL)
    {

            ?>

        <br>
        <textarea name="" id="" cols="80" rows="15"><?php

                 foreach ($COL as $coleccion) {
                    echo "- " . $coleccion . "\n";
                } ?>
            </textarea>


        <?php

    }


    /**
     * FUNCION PARA MOSTRAR, rellena el segundo textArea para mostrar los valores con propieadades
     *
     * @param array $coleciones
     * @return void
     * 
     */
    function mostrarColecionesPropiedades(array $col)
    {
    echo '<br><textarea name="" id="" cols="80" rows="15">';
    
    foreach ($col as $colecion) {
        echo "- " . $colecion . "\n";

        $libros = $colecion->dameLibros();
        if (is_object($libros)) {
            foreach ($libros as $clave => $valor) {
                echo "   $clave: $valor\n";
            }
        }
    }
        echo '</textarea>';
    }

    
    /**
     * Formulario para modificar o exportar
     *
     * @param [type] $COL
     * @return void
     * 
     */
    function formularioAcciones(array $COL)
    {
    ?>
    <form action="" method="post">
        <legend>Acciones</legend>
        <select name="ColecionesDisponibles" id="ColecionesDisponibles">
              <optgroup label="Coleciones">
                <?php
                // Mostrar todos las colecciones disponibles
                foreach ($COL as $key => $value) {
                    echo "<option value='$key'>" . $value->getNombre() . "</option>";
                }
                ?> 
                <!-- Línea adicional con un proyecto que no exista -->
                <option value="noExiste">Coleccion inexistente</option>
            </optgroup>  
        </select>
        <br><br>
        <input type="submit" class="boton" name="modificar" value="Modificar">
        <input type="submit" class="boton" name="exportar" value="Exportar">
    </form>
    <?php
    }