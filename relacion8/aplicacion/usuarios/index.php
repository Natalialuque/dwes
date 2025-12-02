<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// si no hay sesion iniciada le manda a login
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

// si le da al boton de cerrar sesion quita el usuario
if(isset($_POST["cerrarSesion"])) $acceso->quitarRegistroUsuario();

// no tiene el permiso uno no puede entrar a la pagina
if(!$acceso->puedePermiso(2)){
     paginaError("No tienes permiso para acceder a esta página");
     exit;
}

//controlador
$ubicacion = [
    "area personal" => "../../index.php",
    "indice principal Usuarios" => "",

];

//conectar a la base de datos 
$bd = @new mysqli($servidor, $usuario, $contraseña, $baseDatos);

//compruebo si se ha conectado bien
if ($bd->connect_error) {
    paginaError("Fallo al conectar en mySql:" . $bd->connect_error);
    exit;
} else {
    echo "conecta adecuadamente";
}

//establece la pagina de codigos del cliente
$bd->set_charset(("utf8"));

//para recoger todas las cosas de usuario
@$sentencia = "select * from usuarios";
@$consulta = $bd->query($sentencia);

if (!$consulta) {
    paginaError("Fallo al hacer la consulta: " . $bd->connect_error);
    exit;
}

$filas = [];
while ($fila = $consulta->fetch_assoc()) {
    $filas[] = $fila;
}


//controlador


///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($filas);  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() {}

//vista
function cuerpo($filas)
{
    tablaUsuarios($filas);
    filtrar($filas);
}

function tablaUsuarios($filas)
{
?>
    <h1>USUARIOS</h1>
    <table>
        <tr>
            <th>Nick</th>
            <th>Nombre</th>
            <th>NIF</th>
            <th>Direccion</th>
            <th>Poblacion</th>
            <th>Provincia</th>
            <th>CP</th>
            <th>Fecha_nacimiento</th>
            <th>Borrado</th>
            <th>Foto</th>
            <th>Operaciones</th>
        </tr>

        <?php foreach ($filas as $fila) {
            echo   "<tr>";
            echo "<td>{$fila["nick"]}</td>";
            echo "<td>{$fila["nombre"]}</td>";
            echo "<td>{$fila["nif"]}</td>";
            echo "<td>{$fila["direccion"]}</td>";
            echo "<td>{$fila["poblacion"]}</td>";
            echo "<td>{$fila["provincia"]}</td>";
            echo "<td>{$fila["CP"]}</td>";
            echo "<td>" . (!empty($fila['fecha_nacimiento']) ? $fila['fecha_nacimiento'] : '') . "</td>";
            echo "<td>" . ($fila['borrado'] ? 'Si' : 'No') . "</td>";
            echo "<td>{$fila["foto"]}</td>";
            echo "<td>
                    <a href='verUsuario.php?id={$fila["cod_usuario"]}'>Ver</a>
                    <a href='modificarUsuario.php?id={$fila["cod_usuario"]}'>Editar</a>
                    <a href='borrarUsuario.php?nick={$fila["nick"]}'>Borrar</a>
                </td>";
            echo "</tr>";
        }

        ?>
    </table>
    <td>
        <a href="nuevoUsuario.php">añadir usuario</a>
    </td>

<?php
}


/**Se debe poder filtrar por Nick, provincia y borrado y establecer un criterio de ordenación. */
function filtrar($filas){
    ?>
    <h3>FILTAR</h3>
        <form action="" method="post">
        
        <label>Nick:</label>
        <input type="text" name="nick" id="nick">
        <br>
        <label>Provincia:</label>
        <input type="text" name="provincia" id="provincia">
        <br>
        <label>Borrado:</label>
        <input type="text" name="borrado" id="borrado">
        <br>
        <label>Ordenar:</label>
        <select name="ordenar" id="ordenar">
            <?php  
            foreach (array_keys($filas[0]) as $fila) {
                echo "<option value=\"$fila\">";
                echo $fila;
                echo "</option>";
            }

            ?>
        </select>
        <br>
        <button id="filtra">filtrar</button>

    </form>
    <?php
}
?>