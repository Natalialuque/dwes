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
    $_COOKIE["contador"]=$vecesInicio;


    if ($vecesInicio % 3 == 0) {
        $acceso->registrarUsuario("MULTIPLO","MULTIPLO",[1=>true]);
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
        $coleccion=$_SESSION["COL"];
        $objetosCargados = [];
      if(cargarColeccionDesdeFichero("FicherosAcargar.txt", $objetosCargados)){
        foreach ($objetosCargados as $objeto) { 
        array_push($coleccion, $objeto);
         }
        $_SESSION["COL"] = $coleccion;
      }else{
        echo"error";
      }

        
 }


/**
 * para modificar 
 */
 if (isset($_POST["modificar"])) {
     $id = $_POST["ColeccionesDisponibles"];
     $_SESSION["COL"] = $COL; // asegurar que está en sesión

     if ($id === "noExiste" || !isset($COL[$id])) {
         paginaError("La coleccion seleccionada no existe");
       exit;
     }
     // Redirigir a la clase modificar.php con el id de la coleciones
     header("Location: aplicacion/clases/modificar.php?id=" . $id);
     exit;
     
 }


/**
 * para enviar  
 */
if (isset($_POST["exportar"])) {

    $id = $_POST["ColeccionesDisponibles"];

    if ($id === "noExiste" || !isset($COL[$id])) {
        paginaError("La colección seleccionada no existe");
        exit;
    }

    // Construir URL
    $url = "aplicacion/clases/enviar.php?id=" . $id;

    // Si se marcó descargar → añadir parámetro
    if (isset($_POST["descargar"])) {
        $url .= "&descargar=1";
    }

    header("Location: " . $url);
    exit;
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
mostrarColeciones($acceso);    
    
//Boton de carga de fichero 
    cargaFichero();
//Formulario de Acciones donde modificiamos o descargamos
    formularioAcciones($COL);
   //modificar($COL);
   //enviaColeccion($COL);

   

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
 * Boton carga fichero que no baria y siempre igual
 *
 * @return void
 */
function cargaFichero()
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
    // Construimos la ruta completa al fichero dentro de /ficheros/
    $ruta = RUTABASE . "/ficheros/" . $nombreFichero;

    // Si el fichero no existe → error
    if (!file_exists($ruta)) {
        echo "El fichero no existe<br>";
        return false;
    }

    // Intentamos abrir el fichero en modo lectura
    $fic = fopen($ruta, "r");
    if (!$fic) return false;

    // IMPORTANTE: NO vaciamos $datos, solo añadimos al final
    // $datos = [];  ← ESTO NO SE DEBE HACER

    // ---------------------------------------------------------
    // 1) LEER PRIMERA LÍNEA → DATOS DE LA COLECCIÓN
    // ---------------------------------------------------------

    $linea = fgets($fic);          // Leemos la primera línea
    if (!$linea) return false;     // Si está vacía → error

    $linea = trim($linea);         // Quitamos espacios y saltos de línea

    // Formato esperado: nombre -:- fecha -;- tematica
    $partes = explode("-:-", $linea);

    // Deben existir al menos 3 partes
    if (count($partes) < 3) {
        echo "Formato incorrecto en la colección<br>";
        return false;
    }

    // Extraemos los datos básicos
    $nombre   = trim($partes[0]);
    $fecha    = trim($partes[1]);
    $tematica = intval(trim($partes[2]));

    // Intentamos crear la colección (puede lanzar excepción)
    try {
        $coleccion = new Coleccion($nombre, $fecha, $tematica);
    } catch (Exception $e) {
        echo "No se ha podido crear la colección<br>";
        return false;
    }

    // ---------------------------------------------------------
    // 2) LEER LIBROS (cada línea representa un libro)
    // ---------------------------------------------------------

    while ($linea = fgets($fic)) {

        $linea = trim($linea);
        if ($linea === "") continue;   // Saltar líneas vacías

        // Cada propiedad está separada por ";"
        $props = explode(";", $linea);

        // Variables obligatorias
        $nombreLibro = "";
        $autorLibro  = "";

        // Propiedades dinámicas (clave, valor, clave, valor...)
        $dinamicas = [];

        // Procesamos cada propiedad del libro
        foreach ($props as $p) {

            $p = trim($p);
            if ($p === "") continue;

            // Cada propiedad tiene formato clave:valor
            $trozos = explode(":", $p);

            // Si no hay clave y valor → línea mal formada
            if (count($trozos) < 2) continue;

            list($clave, $valor) = array_map("trim", $trozos);

            // Guardamos nombre y autor obligatorios
            if ($clave === "nombre") {
                $nombreLibro = $valor;
            }
            elseif ($clave === "autor") {
                $autorLibro = $valor;
            }
            else {
                // Guardamos propiedades dinámicas en pares
                $dinamicas[] = $clave;
                $dinamicas[] = $valor;
            }
        }

        // ---------------------------------------------------------
        // Validación mínima: un libro debe tener nombre y autor
        // ---------------------------------------------------------
        if ($nombreLibro === "" || $autorLibro === "") {
            echo "Libro ignorado: falta nombre o autor<br>";
            continue;
        }

        // Creamos el libro con las propiedades dinámicas
        $libro = new Libro($nombreLibro, $autorLibro, ...$dinamicas);

        // Añadimos el libro a la colección
        $coleccion->aniadirLibro($libro);
    }

    // Cerramos el fichero
    fclose($fic);

    // ---------------------------------------------------------
    // 3) Añadir la colección creada al array recibido por referencia
    // ---------------------------------------------------------
    $datos[] = $coleccion;

    return true;
}



/**
* Funcion para mostrar colecciones que se encarga de rellenar el text area directamente con la coleccion 
*  CAMBIAR NOMBRE DE VARIABLES SUPER SUPER IMPORTANTE!!! 

* @return void
*/
 function mostrarColeciones(object $acceso){
    $colecciones=$_SESSION["COL"];
    ?>
    <textarea name="" id="" cols="80" rows="15""><?php
        foreach($colecciones as $valor) {
            echo $valor . "\n";
            if($acceso->puedePermiso(1)) {
                $array=$valor->dameLibros();
                foreach($array as $clave => $valor) {
                    foreach($valor as $claveProp => $prop) {
                        echo "$claveProp: $prop\n";
                    }
                    echo "---------------------------------\n";
                }
                echo "\n";
            }
        }
        ?>
    </textarea>
    <?php
    }


   

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
    /**
     * Metodo del formulario de de modificar y enviar con todo junto 
     *
     * @return void
     * 
    **/ 
    function formularioAcciones(array $COL)
    {
    ?>
    <form action="" method="post">

        <label for="ColeccionesDisponibles">Elige colección:</label>
        <select name="ColeccionesDisponibles" id="ColeccionesDisponibles">
            <option value="noExiste">Sin seleccionar</option>

            <?php
            foreach ($COL as $key => $coleccion) {
                echo "<option value='$key'>" . $coleccion->getNombre() . "</option>";
            }
            ?>
        </select>

        <br><br>

        <!-- Checkbox de descarga (venía del método enviaColeccion) -->
        <label for="descargar">Descargar:</label>
        <input type="checkbox" name="descargar" id="descargar">

        <br><br>

        <!-- Botones de acción -->
        <input type="submit" class="boton" name="modificar" value="Modificar">
        <input type="submit" class="boton" name="exportar" value="Exportar">
    </form>
    <?php
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * AQUI TENDRIAMOS LOS METODOS POR SEPARADO 
     *
     */

    function modificar(array $COL) {
    
    $colecciones = $COL;
    ?>
    <form action="" method="post">
        <label for="">Elige colección para modificar</label>
        <select name="modificaColecc" id="">
            <option value="noexiste">Sin seleccionar</option>
            <?php
                for($i=0;$i<count($colecciones);$i++) {
                    echo "<option value=$i>".$colecciones[$i]->getNombre()."</option>";
                }
            ?>
        </select>
        <input type="submit" value="Modificar" name="modificar">
    </form>
    <?php
}

function enviaColeccion(array $COL) {
   
    $colecciones = $COL;
    ?>
    <form action="" method="post">
        <label for="">Elige colección para enviar/descargar</label>
        <select name="enviaColecc" id="">
            <option value="noexiste">Sin seleccionar</option>
            <?php
                for($i=0;$i<count($colecciones);$i++) {
                    echo "<option value=$i>".$colecciones[$i]->getNombre()."</option>";
                }
            ?>
        </select>
        <label for="">Descargar:</label>
        <input type="checkbox" name="descargar" id="">
        <input type="submit" value="Enviar" name="enviar">
    </form>
    <?php
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////