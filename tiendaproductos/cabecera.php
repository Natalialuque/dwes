<?php
define("RUTABASE", dirname(__FILE__));
//define("MODO_TRABAJO","produccion"); //en "produccion o en desarrollo
define("MODO_TRABAJO", "desarrollo"); //en "produccion o en desarrollo

if (MODO_TRABAJO == "produccion")
    error_reporting(0);
   else
    error_reporting(E_ALL);



spl_autoload_register(function ($clase) {
    $ruta = RUTABASE . "/scripts/clases/";  //esto es la autocarga de clases
    $fichero = $ruta . "$clase.php";
    if (file_exists($fichero)) 
        {
         require_once($fichero);
        } 
        else 
        {
            throw new Exception("La clase $clase no se ha encontrado.");
        }
});

include(RUTABASE . "/aplicacion/plantilla/plantilla.php");
include(RUTABASE . "/aplicacion/config/acceso_bd.php");
//creo todos los objetos que necesita mi aplicación

session_start(); // activa o continúa la sesión

$aclArray = new ACLArray();
$acceso = new Acceso();
$acl =new ACLBD($servidor,$usuario,$contraseña,$baseDatos);

//creo aqui los 3 roles, si no existen porque si lo hacemos en la clase aclArray debemos modificar otros metodos
if ($acl->getCodRole('comprador') === false) { 
    $acl->anadirRole('comprador', [8 => true]); 
} 
if ($acl->getCodRole('administrativo') === false) { 
    $acl->anadirRole('administrativo', [8 => true, 9 => true]); 
} 
if ($acl->getCodRole('administrador') === false) {
     $acl->anadirRole('administrador', [9 => true, 10 => true]); // sin permiso 8 
}

// creo el usuario natalia si no existe para poder iniciar sesion

$bd=new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$array = $aclbd->dameUsuarios();
if(!in_array("natalia", $array)) {
    $aclbd->anadirUsuario("natalia","natalia","nat",$aclbd->getCodRole("administrador"));
    $sentencia = "INSERT INTO usuarios 
    (nick, nombre, nif, direccion, poblacion, provincia, CP, fecha_nacimiento, borrado, foto)
    VALUES (
        'natalia', 
        'Natalia Cabello',
        '78945612J',
        'Calle antequera, 10',
        'Mollina',
        'Malaga',
        '29532',
        '2004-04-04',
        1,
        'nats.png'
    );";
    $bd->query($sentencia);
}