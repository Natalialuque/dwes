<?php

include_once(dirname(__FILE__) . "/cabecera.php");

// header("refresh: 1 /aplicacion/practica1/index.php");
// paginaError("no es lo que esparabas");
// exit;

// echo "Ruta física a la raiz del sitio ".RUTABASE."<br>".PHP_EOL;
// echo "url a la que se llama ".$_SERVER["HTTP_HOST"]."<br>".PHP_EOL;
// echo "url a la que se llama ".$_SERVER["SERVER_NAME"]."<br>".PHP_EOL;

if(isset($_POST)){

    //inicio de sesion
    if(isset($_POST["usuario"])){//intento de inicio de sesión
        $vecesInicio=0;
        if(isset($_COOKIE["contador"])){
                $vecesInicio = $_COOKIE["contador"];
            }

        $vecesInicio++;
        setcookie("contador", $vecesInicio, time() + 60 * 60);
            

        if($vecesInicio % 3 == 0){
            inicioSesion("PAR", "PAR", $acceso, $aclComprobacion);
        }
        else{
            inicioSesion("IMPAR", "IMPAR", $acceso, $aclComprobacion);
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

inicioCabecera("PRACTICA 9");
cabecera();
finCabecera();

inicioCuerpo("PRACTICA 9");
cuerpo($benefi, $acceso);
finCuerpo();

// **********************************************************

function cabecera()
{
}


function cuerpo(array $benefi, object $acceso)
{
?>


    <!-- <ul><a href="./aplicacion/personalizar/personalizar.php"> Entrar personalizar</a></ul> -->
    <!-- <ul><a href="./aplicacion/texto/verTextos.php"> Entrar Ver textos</a></ul> -->

    <br>

    <?php

    formularioLogin($acceso);


    if ($acceso->hayUsuario()) {

        if($acceso->puedePermiso(2)){
            mostrarBeneficiarios($benefi);
            cargaDesdeFichero();
            nuevoBeneficiario();
            descargaBeneficiario($benefi);
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
function inicioSesion(string $user, string $pass, object $acceso, object $aclComprobacion){

    if ($aclComprobacion->esValido($user, $pass)) {//comprovmaos que el usuario y la contraseña son validos
        $users = $aclComprobacion->dameUsuarios();//recogemos los usuarios
        foreach ($users as $clave => $nick) {
            if ($nick == strtolower($user)) {//buscamos el relevante respecto a nuestro nick
                $permisos = $aclComprobacion->getPermisos($clave);//recogemos los datos de los permisos del user
                $nombre = $aclComprobacion->getNombre($clave);//recogemos el nombre del user
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
function mostrarBeneficiarios(array $benefi){

    ?>

    <br>
    <textarea name="" id="" cols="80" rows="15"><?php 
        
        foreach($benefi as $beneficiario){ 
            
            $bonos = $beneficiario->getListaBonos();

            $lista = "Importe total: ".$beneficiario->getImporteBonos()."\n";
            $lista.="Bonos: \n";
            foreach($bonos as $tipo => $valor){
                $lista .= $tipo . "--> " . $valor . "€ \n";
            }
            
            echo $beneficiario . "\n"; 
            echo $lista . "\n";
            
            } ?>
    </textarea>


    <?php

}

/**
 * Carga un formulario para cargar los beneficiarios que tengamos en el fichero designado
 *
 * @return void
 */
function cargaDesdeFichero(){

    ?>

    <br>
    <hr>
    <form method="post">
        <label for="cargaFichero">Cargar fichero guardado: &nbsp;</label>
        <input type="submit" value="Cargar fichero" name="cargaFichero">
    </form>

    <?php

}

function nuevoBeneficiario(){

    ?>
    <hr>
    <form method="post">
        <label for="cargaFichero">Crear un nuevo Beneficiario: &nbsp;</label>
        <input type="submit" value="Nuevo" name="nuevoBenef">
    </form>

    <?php

}

function descargaBeneficiario(array $benefi){

    ?>
    <hr>
    <label for="">Descarga el beneficiario seleccionado:</label>
    <br><br>
    <form method="post" action="/aplicacion/beneficiarios/descarga.php">    
        <select name="descargaBenef" >
            <option value="-1" >Beneficiario inexistente </option>
            <?php
                foreach($benefi as $key => $value){
                    echo "<option value='" . $key . "'>". $value->get_nombre() . " - " . $value->get_fecha() ."</option>";
                }
            ?>

        </select>
        &nbsp;
        <input type="submit" value="descargar" name="descargar">
    </form>

    <?php

}
}
