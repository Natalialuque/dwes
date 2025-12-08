<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
require_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");


//-------------------------- Barra de ubicación 
$ubicacion = [
    [
        "posicion" => "Inicio",
        "direccion" => "/index.php"
    ],
    ["posicion" => "Modificar",],

];

//-------------------------- Controlador



//-------------------------- Vista 
inicioCabecera("EXAMEN"); //Esto es lo que sale arriba de la pestaña de chrome
cabecera();
finCabecera();
inicioCuerpo("Modificar Proyecto", $ubicacion);
cuerpo($PRO);
finCuerpo();

function cabecera() {}

function cuerpo($PRO)
{
?>

<div id=mostrar1>
    <?php
    mostrarDatos($PRO);
    echo "<div id=formulario>";
    formulario($PRO);
}

//-------------------------- Funciones adicionales

function formulario($PRO)
{

    $propiedades = $equipo->dameListaPropiedades();

    if ($errores) { //mostrar los errores
        echo "<div class='error'>";
        foreach ($errores as $clave => $valor) {
            foreach ($valor as $error)
                echo "$clave => $error<br>" . PHP_EOL;
        }
        echo "</div>"  . PHP_EOL;
    }


    ?>
        <!-- Formulario para realizar modificaciones -->
        <form action="" method="post">
            <?php
            echo  "<input type='hidden' name='id_equipo' value='" . $datos['id_equipo'] . "'>"  . PHP_EOL;
            foreach ($propiedades as $propiedad) {



                echo "<label>" . ucfirst($propiedad) . ": </label>";

                if ($propiedad == "anio" || $propiedad == "precio" || $propiedad == "consumo") {
                    $res = "";
                    $value = $_POST[$propiedad] ?? $equipo->damePropiedad($propiedad, 1, $res);
                    echo "<input type='number' name='$propiedad' value='" .  ($value ? $res : $_POST[$propiedad]) . "'> <br>"  . PHP_EOL;
                } else if ($propiedad == "color") {
                    $valor = $_POST[$propiedad] ?? $equipo->getColor();
                    echo "<select name='$propiedad' id='color'>
                <optgroup label='Colores'>"  . PHP_EOL;

                    foreach ($colores as $key => $value) {

                        $selected = ($valor == $key) ? 'selected' : '';
                        echo "<option value='$key' $selected>$value</option>"  . PHP_EOL;
                    }
                    echo "</optgroup></select> <br>" . PHP_EOL;
                } else if ($propiedad == "wifi") {
                    $wifi = $_POST[$propiedad] ?? $equipo->getWifi();
                    echo "<label>Si: </label>";
                    echo "<input type='radio' name='$propiedad' value='true' " . ($wifi == true ? 'checked' : '') . "> "  . PHP_EOL;
                    echo "<label>No: </label>";
                    echo "<input type='radio' name='$propiedad' value='false' " . ($wifi == false ? 'checked' : '') . "> <br>"  . PHP_EOL;
                } else if ($propiedad == "fabricante") {
                    $res = "";
                    $value = $_POST[$propiedad] ?? $equipo->damePropiedad($propiedad, 1, $res);
                    echo "<input type='text' name='$propiedad' value='" .  ($value ?  mb_substr($res, 4) : $_POST[$propiedad]) . "'> <br>"  . PHP_EOL;
                } else {
                    $res = "";
                    $value = $_POST[$propiedad] ?? $equipo->damePropiedad($propiedad, 1, $res);
                    echo "<input type='text' name='$propiedad' value='" .  ($value ? $res : $_POST[$propiedad]) . "'> <br>"  . PHP_EOL;
                }
            }

            if (($equipo->exportarCaracteristicas()) != "") {
                $array = [];
                $items = explode(', ', $equipo->exportarCaracteristicas());

                foreach ($items as $item) {
                    list($key, $value) = explode(':', $item);
                    $array[$key] = $value;
                }

                echo "<br><strong>Características adicionales:</strong><br>";
                foreach ($array as $key => $value) {
                    $value = $datos['caracteristicas'][$key] ?? $value;
                    echo "<label>" . $key . ": </label>"  . PHP_EOL;
                    echo "<input type='text' name='caracteristicas[$key]' value='" . $value . "'> <br>"  . PHP_EOL;
                }

                // Si el formulario ya tiene valores predefinidos para las características, asegúrate de no incluirlos otra vez


            }
            ?>
            <input type="submit" class="boton" name="enviar" value="Modificar" id="enviar">
        </form>
    </div>

<?php

}


function mostrarDatos($equipo, $colores, $mensaje)
{

?>
    <table class="tablaModificar">
        <caption><?php echo get_class($equipo);

                    if ($mensaje != "") echo "<br>$mensaje";

                    ?> </caption>
        <thead>
            <tr>
                <th>Propiedad</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Inicializamos el contador y las propiedades
            $res = "";
            $propiedades = $equipo->dameListaPropiedades();
            $totalPropiedades = count($propiedades);
            $contador = 0;

            // Iteramos sobre las propiedades y las mostramos en la tabla
            foreach ($propiedades as $propiedad) {
                echo "<tr>";
                echo "<td><b>" . ucfirst($propiedad) . ":</b></td>"; // Propiedad

                $equipo->damePropiedad($propiedad, 1, $res); // Obtenemos el valor de la propiedad

                // Realizamos transformaciones en los valores según corresponda
                if ($propiedad == "fabricante") {
                    $res = mb_substr($res, 4); // Cortamos los primeros 4 caracteres del fabricante
                }
                if ($propiedad == "color") {
                    $res = $colores[$res]; // Obtenemos el nombre del color si es un código
                }
                if ($propiedad == "wifi") {
                    $res = ($res == 1) ? "Sí" : "No"; // Transformamos el valor de wifi en 'Sí' o 'No'
                }

                // Mostramos el valor de la propiedad en la tabla
                echo "<td>" . $res . "</td>";

                $contador++;

                echo "</tr>";

                // Si no es la última propiedad, añadimos un salto de línea (esto ya lo manejamos con el formato de la tabla)
            }

            // Verificamos si hay características adicionales y las mostramos
            if (($equipo->exportarCaracteristicas()) != "") {
                $array = [];
                $items = explode(',', $equipo->exportarCaracteristicas());

                foreach ($items as $item) {
                    list($key, $value) = explode(':', $item);
                    $array[$key] = $value;
                }

                // Mostramos las características adicionales
                foreach ($array as $key => $value) {
                    echo "<tr><td><b>" . mb_strtoupper($key) . ":</b></td><td>" . $value . "</td></tr>";
                }
            } else {
                // Si no tiene características adicionales
                echo "<tr><td colspan='2'><strong>No tiene características adicionales.</strong></td></tr>";
            }
            ?>
        </tbody>
    </table>
    <br><br>


<?php     }
