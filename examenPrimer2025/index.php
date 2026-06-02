<!-- ESTE INDEX ESTA CARGADO DE OTROS EXAMENES, TEN CUIDADO Y CAMBIA TODO BIEN -->

<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador
/**CAMBIAR POR LO QUE TOQUE */
$COL = $_SESSION["COL"] ?? [];

//barra de ubicacion 
 $ubicacion = [
 "pagina principal"=> "index.php",

 ];

 /*
  * Para e boton de logeo, donde hacemos todas las cosas 
  */
// Inicializar cookie si no existe
if (!isset($_COOKIE["contador"])) {
    setcookie("contador", 1, time() + 3600);
    $_COOKIE["contador"] = 1; // para usarla en este mismo request
}

if (isset($_POST["usuario"])) { //intento de inicio de sesión
    
    $vecesInicio = $_COOKIE["contador"]+2;
    setcookie("contador", $vecesInicio, time() + 3600);
    $_COOKIE["contrador"]=$vecesInicio;


    if ($vecesInicio % 3 == 0) {
        $acceso->registrarUsuario("MULTIPLO","MULTIPLO",[1]);
    }

 }

//destruccion de sesion
if (isset($_POST["salir"])) {
    $acceso->quitarRegistroUsuario();
    session_destroy();
}


 /**
  * para hacer la carga de un fichero
  */
  if (isset($_POST["cargaFichero"])) {
    
 }


/**
 * para modificar 
 */
 if (isset($_POST["modificar"])) {
     
 }


/**
 * para enviar  
 */
if (isset($_POST["exportar"])) {
    
}


/**
 * para tener uno nuevo
 */
if(isset($_POST["nuevo"])){

}




//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("2DAW APLICACION");
cuerpo($COL,$acceso);  //llamo a la vista CAMBIAR VARIABLESSSS
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{}

//vista donde metemos todas las funciones declaradas abajo para que funcionen 
//CAMBIAR VARIABLES 
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
    *
    *function inicioSesion(string $user, string $pass, object $acceso, object $acl)
    *{

    *    if ($acl->esValido($user, $pass)) {
    *        $users = $acl->dameUsuarios();
    *        foreach ($users as $clave => $nick) {
    *            if ($nick == strtolower($user)) {
    *                $permisos = $acl->getPermisos($clave);
    *                $nombre = $acl->getNombre($clave);
    *                $acceso->registrarUsuario($nick, $nombre, $permisos);
    *            }
    *        }
    *    }
   * }*/

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
 *Funcion para cargar la clase de ficheros 
 */

function cargarColeccionDesdeFichero(string $nombreFichero, array &$datos): bool
{
 return false;   
}


/**
* Funcion para mostrar colecciones que se encarga de rellenar el text area directamente con la coleccion 
*  CAMBIAR NOMBRE DE VARIABLES SUPER SUPER IMPORTANTE!!! 
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
     * Formulario para modificar o exportar, es igual TENER EN CUENTA CAMBIAR VARIABLES !!!!!
     *
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