<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/../../librerias/validacion.php");


// si no hay sesion iniciada le manda a login
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

// si le da al boton de cerrar sesion quita el usuario
if(isset($_POST["cerrarSesion"])) $acceso->quitarRegistroUsuario();

// no tiene el permiso uno no puede entrar a la pagina
if(!$acceso->puedePermiso(2)){
     paginaError("No tienes permiso ");
     exit;
}


if(!$acceso->puedePermiso(3)){
     paginaError("No tienes permiso");
     exit;
}



//conectar a la base de datos 
$bd = @new mysqli($servidor, $usuario, $contraseña, $baseDatos);

//compruebo si se ha conectado bien
if ($bd->connect_error) {
    paginaError("Fallo al conectar en mySql:" . $bd->connect_error);
    exit;
} //else {
 //   echo "conecta adecuadamente";
//}

$sentencia = "select * from usuarios";


//inicializar variables necesarias 
$datos=[
    "nick"=>"",
    "nombre"=>"",
    "nif"=>"",
    "direccion"=>"",
    "poblacion"=>"",
    "provincia"=>"",
    "cp"=>"00000",
    "fecha_nacimiento"=>"",
    "borrado"=>"",
    "foto"=>""

];
    $errores = [];

//metodo para generar el nombre aleatorio 
if(isset($_POST["generar"])) {
    $array = array_merge(range('0', '9'), range('A', 'Z'), range('a', 'z'));
    $resultado="";
    for($i=0;$i<=20;$i++) {
        $resultado.= $array[mt_rand(1,count($array)-1)];
    }
    $datos["nombre"]=$resultado;
}



//comprobaciones
if(isset($_POST["subir"])){

    //comprobar nick
    $nick="";
    if(isset($_POST["nick"])){
        $nick = trim($_POST["nick"]);

        if($nick === " ") {
                $errores["nick"][] = "El nick no puede estar vacio";
        }elseif(!validaCadena($nick,50,"")){
            $errores["nick"][]="EL nick no puede tener mas de 50 caracteres";
        }elseif($aclArray->existeUsuario($_POST["nick"])){
            $errores["nick"][]="EL nick ya existe";
        }

    }
     $datos["nick"] = $nick;


    //comprobar nombre 
    $nombre="";
    if(isset($_POST["nombre"])){
        $nombre = trim($_POST["nombre"]);

        if($nombre===""){
            $errores["nombre"][]="el nombre no puede estar vacio";
        }elseif(!validaCadena($nombre,50,"")){
            $errores["nombre"][]="EL nombre no puede tener mas de 50 caracteres";
        }
    }
    $datos["nombre"]=$nombre;

    //comprobar nif
       $nif="";
    if(isset($_POST["nif"])){
        $nif = trim($_POST["nif"]);

        if($nif=== ""){
            $errores["nif"][]="el nif no puede estar vacio";
        }elseif(!validaCadena($nif,10,"")){
            $errores["nif"][]="EL nif no puede tener mas de 50 caracteres";
        }
    }
    $datos["nif"]=$nif;

    //comprobar direccion 
       $direccion="";
    if(isset($_POST["direccion"])){
        $direccion = trim($_POST["direccion"]);

        if($direccion===""){
            $errores["direccion"][]="el direccion no puede estar vacio";
        }elseif(!validaCadena($direccion,50,"")){
            $errores["direccion"][]="EL direccion no puede tener mas de 50 caracteres";
        }
    }
    $datos["direccion"]=$direccion;

    //comprobar poblacion 
      $poblacion="";
    if(isset($_POST["poblacion"])){
        $poblacion = trim($_POST["poblacion"]);

        if($poblacion===""){
            $errores["poblacion"][]="el poblacion no puede estar vacio";
        }elseif(!validaCadena($poblacion,50,"")){
            $errores["poblacion"][]="EL poblacion no puede tener mas de 50 caracteres";
        }
    }
    $datos["poblacion"]=$poblacion;

    //comprobar provincia 
     $provincia="";
    if(isset($_POST["provincia"])){
        $provincia = trim($_POST["provincia"]);

        if($provincia===""){
            $errores["provincia"][]="el provincia no puede estar vacio";
        }elseif(!validaCadena($provincia,30,"")){
            $errores["provincia"][]="EL provincia no puede tener mas de 30 caracteres";
        }
    }
    $datos["provincia"]=$provincia;


    //comprobar cp
     $cp="";
    if(isset($_POST["cp"])){
        $cp = trim($_POST["cp"]);

        if($cp===""){
            $errores["cp"][]="el cp no puede estar vacio";
        }elseif(!validaCadena($cp,5,"")){
            $errores["cp"][]="EL cp no puede tener mas de 5 caracteres";
        }
    }
    $datos["cp"]=$cp;

    //comprobar fecha nacimiento 
    $fecha_nacimiento="";
    if(isset($_POST["fecha_nacimiento"])){
        $fecha_nacimiento = trim($_POST["fecha_nacimiento"]);

      if ($fecha_nacimiento === "") {
            $errores["fecha_nacimiento"][] = "La fecha de nacimiento no puede estar vacía";
      } elseif (!validaFecha($fecha_nacimiento, "")) {
             $errores["fecha_nacimiento"][] = "La fecha de nacimiento no tiene el formato adecuado";
      } 
       
    }
    $datos["fecha_nacimiento"] = $fecha_nacimiento; 
    

    //comprobar borrado
    $borrado="";
    if(isset($_POST["borrado"])){
        $borrado = trim($_POST["borrado"]);

        if($borrado===""){
            $errores["borrado"][]="el borrado no puede estar vacio";
        }elseif($borrado!=0 && $borrado!=1){
            $errores["borrado"][]="el borrado debe ser 0 o 1";
        }
    }
    $datos["borrado"]=$borrado;

    //comprobar foto
    $foto = "";
    if (isset($_POST["foto"])) {
        $foto = trim($_POST["foto"]);

            if ($foto !== "") {
                if (!validaCadena($foto, 50, "")) {
                    $errores["foto"][] = "Foto debe ser de 50 caracteres máximo";
                }
            }
        }
        $datos["foto"] = ($foto === "") ? "defecto.png" : $foto;

    //comrponar contraseña 
    $contrasena = "";
    $contrasenaConfirm = "";

        if (isset($_POST["contrasena"])) {
            $contrasena = trim($_POST["contrasena"]);
        }
        if (isset($_POST["contrasenaConfirm"])) {
            $contrasenaConfirm = trim($_POST["contrasenaConfirm"]);
        }
        if ($contrasena === "") {
            $errores["contrasena"][] = "La contraseña no puede estar vacía";
        } elseif ($contrasena !== $contrasenaConfirm) {
            $errores["contrasena"][] = "Las contraseñas no coinciden";
        }

        $datos["contrasena"] = $contrasena;

   // Ejecutar el INSERT
    if (empty($errores)) {  // solo si no hay errores
         // Insertar en la tabla usuarios si no hay errores
    $sentencia = "INSERT INTO usuarios 
        (nick, nombre, nif, direccion, poblacion, provincia, CP, fecha_nacimiento, borrado, foto)
        VALUES (
            '{$datos["nick"]}', 
            '{$datos["nombre"]}', 
            '{$datos["nif"]}', 
            '{$datos["direccion"]}', 
            '{$datos["poblacion"]}', 
            '{$datos["provincia"]}', 
            '{$datos["cp"]}', 
            '{$datos["fecha_nacimiento"]}', 
            '{$datos["borrado"]}', 
            '{$datos["foto"]}'
        )";

    if ($bd->query($sentencia)) {
        // obtener el id del nuevo usuario
        $codUsuario = $bd->insert_id;

        // añadir contraseña y rol usando ACLBD
        $rolCodificado = $aclbd->getCodRole($_POST["rol"]);
        $aclbd->anadirUsuario(
            $datos["nombre"],
            $datos["nick"],
            $datos["contrasena"],
            $rolCodificado
        );

        // redirigir a verUsuario.php
        header("Location: verUsuario.php?id=" . $codUsuario);
        exit;
    } else {
        paginaError("Error al insertar usuario: " . $bd->error);
        exit;
    }

}

}


///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($datos,$errores,$aclbd);  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo($datos,$errores,$aclbd) {
    formulario($datos,$errores,$aclbd);
}


function formulario($datos, $errores,$aclbd){

    
   if ($errores) { //mostrar los errores
            echo "<div class='error'>";
            foreach ($errores as $clave => $valor) {
                foreach ($valor as $error)
                    echo "$clave => $error<br>" . PHP_EOL;
            }
            echo "</div>";
    }
?>
<h3>NUEVO USUARIO</h3>
 <form action="" method="post">
    <label>Nick:</label>
    <input type="text" name="nick" id="nick" value="<?= $datos["nick"] ?>"> 
    <br>
     <label for="">Contraseña:</label>
        <input type="password" name="contrasena"> <br>

        <label for="">Confirma Contraseña:</label>
        <input type="password" name="contrasenaConfirm"> <br>
        
        <label for="">Rol:</label>
        <select name="rol" id="">
            <?php 
            foreach($aclbd->dameRoles() as $rol) {
                echo "<option value='$rol'>$rol</option>";
            }
            ?>
        </select> 
        
    <br><br>
    <label>Nombre:</label>
    <input type="text" name="nombre" id="nombre" value="<?= $datos["nombre"] ?>">
    <input type="submit" value="Genera Nombre" name="generar">
     <br>
    <label>Nif:</label>
    <input type="text" name="nif" id="nif" value="<?= $datos["nif"] ?>">
     <br>
    <label>Direccion:</label>
    <input type="text" name="direccion" id="direccion" value="<?= $datos["direccion"] ?>">
    <br>
    <label>Poblacion:</label>
    <input type="text" name="poblacion" id="poblacion" value="<?= $datos["poblacion"] ?>">
    <br>
    <label>Provincia:</label>
    <input type="text" name="provincia" id="provincia" value="<?= $datos["provincia"] ?>">
    <br>
    <label>CP:</label>
    <input type="text" name="cp" id="cp" value="<?= $datos["cp"] ?>">
     <br>
    <label>fecha Nacimiento:</label>
    <input type="text" name="fecha_nacimiento" id="fecha_nacimiento" value="<?= $datos["fecha_nacimiento"] ?>">
     <br>
    <label>Borrado:(0-no // 1-si) </label>
    <input type="text" name="borrado" id="borrado" value="<?= $datos["borrado"] ?>" >
     <br>
    <label>Foto:(no obligatorio) </label>
    <input type="text" name="foto" id="foto" value="<?= $datos["foto"] ?>">

    <br>
    <input type="submit" value="Registrar usuario" name="subir">
    <br>
    <a href="index.php">Volver a la tabla</a>
</form>

<?php
    
}