
<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

$POB = $_SESSION["POB"] ?? [];

//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "index.php",

 ];

 /*
  * login
  */
 if (isset($_POST["usuario"])) { //intento de inicio de sesión
   
    
 }


 /**
  * para hacer la carga
  */
  if (isset($_POST["cargaFichero"])) {
     $objetosCargados = [];
     //CAMBIAR PORQUE COGE OTRA
    cargarPoblacionDesdeFichero("poblaciones.txt", $objetosCargados); //cargamos los objetos nuevos

    foreach ($objetosCargados as $objeto) { //los añadimos al array global
        array_push($POB, $objeto);
    }
     $_SESSION["POB"] = $POB;
 }


/**
 * modificar
 */
 if (isset($_POST["modificar"])) {
     $id = $_POST["PoblacionesDisponibles"];
     $_SESSION["POB"] = $POB; // asegurar que está en sesión

     if ($id === "noExiste" || !isset($POB[$id])) {
         paginaError("La poblacion seleccionada no existe");
       exit;
     }
     // Redirigir a la clase modificar.php con el id de la poblacion
     header("Location: aplicacion/poblaciones/modificar.php?id=" . $id);
     exit;
 }


/**
 * enviar 
 */
if (isset($_POST["exportar"])) {
    $id = $_POST["PoblacionesDisponibles"];
    $_SESSION["POB"] = $POB;

    if ($id === "noExiste" || !isset($POB[$id])) {
        paginaError("La poblacion seleccionado no existe");
        exit;
    }
    header("Location: aplicacion/poblaciones/enviar.php?id=" . $id);
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
cuerpo($POB,$acceso);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{}

//vista
function cuerpo(array $POB,object $acceso)
{
//inicio login 
formularioLogin($acceso);

//mostrar poblacion teniendo en cuenta que permiso tiene
    mostrarPoblaciones($POB);
    
    if ($acceso->hayUsuario(4)) {
        mostrarPoblacionesPropiedades($POB);
    } else {
        echo "<h3>Sin permiso ver otros</h3>";
    }

//Boton de carga de fichero 
    cargaDesdeFichero();
//Formulario de Acciones donde modificiamos o descargamos
    formularioAcciones($POB);

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
        <input type="edit"  name="edit">
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
 * funcion que carga las poblaciones desde ficheros 
 */

function cargarPoblacionDesdeFichero(string $nombreFichero, array &$datos): bool
{
    $ruta = RUTABASE . "/imagenes/";
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
            // Separar datos del poblaciones
            $linea = mb_split("POBLACIONES=", $linea);
            $linea = preg_split("/,/", $linea[1]);

            $nombre = ""; 
            $origen = 1000; 
         

            foreach ($linea as $value) {
                $pob = mb_split(":", $value);
                if ($pob[0] == "nombre") $nombre = $pob[1];
                if ($pob[0] == "origen") $origen = $pob[1];
            }

            // Intentar crear la poblacion
            try {
                $objeto = new Poblacion($nombre,$origen);
            } catch (Exception $e) {
                echo "No todos las poblaciones han podido ser cargadas<br>";
                $objeto = null; // marcar como no válido
            }

        }
    }

    fclose($fic);
    return true;
}


/**
* rellena el text area directamente con la poblacion 
*
* @param array $POB
* @return void
*/
 function mostrarPoblaciones(array $POB)
    {

            ?>

        <br>
        <textarea name="" id="" cols="80" rows="15"><?php

                 foreach ($POB as $poblacion) {
                    echo "- " . $poblacion . "\n";
                } ?>
            </textarea>


        <?php

    }


    /**
     * FUNCION PARA MOSTRAR, rellena el segundo textArea para mostrar los valores con propieadades
     *
     * @param array $poblaciones
     * @return void
     * 
     */
    function mostrarPoblacionesPropiedades(array $POB)
    {
    echo '<br><textarea name="" id="" cols="80" rows="15">';
    
    foreach ($POB as $poblacion) {
        echo "- " . $poblacion . "\n";

        $poblacion = $poblacion->dameElementos();
        if (is_object($poblacion)) {
            foreach ($poblacion as $clave => $valor) {
                echo "   $clave: $valor\n";
            }
        }
    }
        echo '</textarea>';
    }

    
    /**
     * Formulario para modificar o exportar
     *
     * @param [type] 
     * @return void
     * 
     */
    function formularioAcciones(array $POB)
    {
    ?>
    <form action="" method="post">
        <legend>Acciones</legend>
        <select name="PoblacionesDisponibles" id="PoblacionesDisponibles">
              <optgroup label="Poblaciones">
                <?php
                // Mostrar todos las poblaciones disponibles
                foreach ($POB as $key => $value) {
                    echo "<option value='$key'>" . $value->getNombre() . "</option>";
                }
                ?> 
                <!-- Línea adicional con un proyecto que no exista -->
                <option value="noExiste">Poblacion inexistente</option>
            </optgroup>  
        </select>
        <br><br>
        <input type="submit" class="boton" name="modificar" value="Modificar">
        <input type="submit" class="boton" name="exportar" value="Exportar">
            <div>
                <input type="radio" class="boton" name="descargar" value="descargar">Descargar
                <input type="radio" class="boton" name="nodescar" value="nodescargar">No descargar
            </div>
                

    </form>
    <?php
    }