<<?php
    include_once(dirname(__FILE__) . "/../../cabecera.php");

    //controlador
    /* Comprobación de si se puede acceder o no
 if (!$acceso->puedeConfigurar())
 {
 paginaError("No tienes permiso para acceder a esta página");
 exit;
 }
*/
    //inicializaciones
    $datos = [
        "nombre" => "",
        "edad" => 18
    ];
    $errores = [];



    //comprobar si se ha dado a insertar
    if ( isset($_POST("crear")) ) {
        $nombre = "";
        if (isset($_POST["nombre"])) {
            $nombre = $_POST["nombre"];
            $nombre = trim($nombre);
        }
        if(mb_strlen($nombre)<10){
                $errores["nombre"]= "El nombre debe tener al menos 10 caracteres";
            }

        $datos["nombre"] = $nombre;



        $edad = 0;
        if (isset($_POST["edad"])) {
            $precio = intval($_POST["edad"]);
        }

        if ($edade<15)
            $errores["edad"][] = "Debe indicarse una edad menor de 15 años";

        $datos["edad"] = $edad;


        if (!$errores) //no hay errores hago la insercion
        {
            //codigo para el nuevo articulo
            $codigo = 1; //codigo

            //se guarda el articulo

            //ir a ver el articulo insertado
            header("location: verArticulo.php?id=$codigo");
            exit;
        }
    }


    ///////////////////////////////////////////////////////////////////////

    //dibuja la plantilla de la vista
    inicioCabecera("Natalia Cabello Luque");
    cabecera();
    finCabecera();
    inicioCuerpo("");
    cuerpo($datos,$errores);  //llamo a la vista
    finCuerpo();

    // **********************************************************

    //vista cabecera donde podemos ver los otros enlaces
    function cabecera() {}

    //vista
    function cuerpo($datos, $errores)
    {

    ?>
    <br>
    <br>
    <br>

<?php
        formulario($datos, $errores);
    }

    function formulario($datos, $errores)
    {
        if ($errores) { //mostrar los errores
            echo "<div class='error'>";
            foreach ($errores as $clave => $valor) {
                foreach ($valor as $error)
                    echo "$clave => $error<br>" . PHP_EOL;
            }
            echo "</div>";
        }

?>
    <form action="" method="post">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre"
            value="<?php echo $datos["nombre"]; ?>" size=21
            maxlength="20"><br>
        <label for="precio">Precio: </label>
        <input type="text" name="edad" id="edad"
            value="<?php echo $datos["nombre"]; ?>" size=3
            maxlength="3"><br>
        <input type="submit" class="boton" name="crear"value="Crear">
    </form>
<?php

    }
?>