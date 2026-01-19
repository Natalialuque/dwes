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
    cargarColeccionDesdeFichero("coleccion.txt", $objetosCargados); //cargamos los objetos nuevos

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
mostrarColecionesPropiedades( $COL,  $acceso);
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
    $ruta = RUTABASE . "/ficheros/" . $nombreFichero;

    if (!file_exists($ruta)) {
        echo "El fichero no existe<br>";
        return false;
    }

    $fic = fopen($ruta, "r");
    if (!$fic) return false;

    $datos = [];

    // 1) LEER PRIMERA LÍNEA → COLECCIÓN
    $linea = fgets($fic);
    if (!$linea) return false;

    $linea = trim($linea);
    $partes = explode("-:-", $linea);

    if (count($partes) < 3) {
        echo "Formato incorrecto en la colección<br>";
        return false;
    }

    $nombre = trim($partes[0]);
    $fecha = trim($partes[1]);
    $tematica = intval(trim($partes[2]));

    try {
        $coleccion = new Coleccion($nombre, $fecha, $tematica);
    } catch (Exception $e) {
        echo "No se ha podido crear la colección<br>";
        return false;
    }

    // 2) LEER LIBROS
    while ($linea = fgets($fic)) {

        $linea = trim($linea);
        if ($linea === "") continue;

        // separar propiedades del libro
        $props = explode(";", $linea);

        $nombreLibro = "";
        $autorLibro = "";
        $dinamicas = [];

        foreach ($props as $p) {
            $p = trim($p);
            if ($p === "") continue;

            list($clave, $valor) = array_map("trim", explode(":", $p));

            if ($clave === "nombre") $nombreLibro = $valor;
            elseif ($clave === "autor") $autorLibro = $valor;
            else {
                $dinamicas[] = $clave;
                $dinamicas[] = $valor;
            }
        }

        // comprobar que tiene nombre y autor
        if ($nombreLibro === "" || $autorLibro === "") {
            echo "Libro ignorado: falta nombre o autor<br>";
            continue;
        }

        // crear libro
        $libro = new Libro($nombreLibro, $autorLibro, ...$dinamicas);

        // añadir libro a la colección
        $coleccion->aniadirLibro($libro);
    }

    fclose($fic);

    // añadir colección al array
    $datos[] = $coleccion;

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
   function mostrarColecionesPropiedades(array $col, Acceso $acceso)
{
    echo '<br><textarea name="" id="" cols="80" rows="15">';

    foreach ($col as $coleccion) {

        echo "- " . $coleccion . "\n";

        if ($acceso->hayUsuario() && $acceso->puedePermiso(1)) {

            $libros = $coleccion->dameLibros();

            foreach ($libros as $clave => $libro) {

                echo "   $clave:\n";

                // nombre y autor
                echo "      nombre: " . $libro->nombre . "\n";
                echo "      autor: " . $libro->autor . "\n";

                // propiedades dinámicas usando tu ITERATOR
                foreach ($libro as $prop => $valor) {
                    echo "      $prop: $valor\n";
                }

                echo "---------------------------------\n";
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