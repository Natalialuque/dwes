<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

//controlador


//conectar a la base de datos 
$bd= @new mysqli($servidor,$usuario,$contraseña,$baseDatos);

//compruebo si se ha 
if($mysqli -> connect_error)
{
    paginaError("Fallo al conectar en mySql:" . $bd-> connect_error);
    exit;
}

//establece la pagina de codigos del cliente
$bd -> set_charset(("utf8"));


$sentSelect="*";
$sentFrom="prueba1";
$sentWhere=" ";
$sentOrder="cadena";

//recojo los criterios de filtrado 
$sentWhere="numero>10";

//recojo ordenación 


//construyo la sentencia 
$sentencia = "select sentSelect". 
             "  from sentFrom". 
             "  where sentWhere". 
             "  order by sentOrder";
$consulta = $bd -> query($sentencia);
if(!$consulta){
    paginaError("fallo en el acesso a la basededatos");
    exit;
}

$fila=[];
while($fila=$consulta -> fetch_assoc())
{
    $fila["descripcion"]=$fila["cadena"].": ".$fila["numero"];
    $filas[]=$fila;
}


//ejecuccion sentencias borrado , actualizacion e inserccion 
if(isset($_GET["oper"])&& $_GET["oper"]==1){

//para evitar problemas de inyeccion 

//con tipos distintos de cadenas, convertir siempre el parametro recibo al tipo 
$id="2";
$id=intval($id);


$sentencia="update prueba1 set" . 
            "      numero=2000". 
            "     where id=2";

$consulta=$bd -> query($sentencia);
if(!$consulta){
    paginaError("Error al modificar ");
    exit;
}
}


///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($fila);  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo($fila) {

    ?> 
        <table>
            <thead>
                <tr>
                <th>CADENA NUMEROS</th><th>NUMERO</th><th>DESCRIPCION</th>
                </tr>
            </thead>
            <?php 
            foreach($fila as $filas){
                echo"<tr>";
                echo "<td>{$fila ["cadena"]}</td>";
                echo "<td>{$fila ["numero"]}</td>";
                echo "<td>{$fila ["descripcion"]}</td>";
                echo"</tr>";
            }
            ?>

        </table>
    <a href="pruebabd.php ? oper=1">Modificar fila 2</a>
    <?php
 
}

?>