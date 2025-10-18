<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");


$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 3"=> "./index.php",

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;

//controlador
include 'libreria.php';

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("Practica 3");
cuerpo();  //llamo a la vista
finCuerpo();
//rururur
// **********************************************************

//vista
function cabecera() 

{
    
}

//vista
function cuerpo()
{
    echo"<h1>RELACION 3: FUNCIONES</h1>";

    /**ejercicio 1 */
    echo "<h3>Ejercicio 1: cuentaVeces</h3>";

            $vector = [];
            $numero = 2;

            // Primera llamada
           
            /**
             * "posición" no está prohibida → pasa el if.
                *$numero se incrementa → pasa de 2 a 3.
                 *$vector["posición"] no existe → se crea con valor 7.
             */     
            if (cuentaVeces($vector, "posición", 7, $numero)) {
                echo "Llamada nº $numero<br>";
                echo "Vector actualizado:<br>";
                print_r($vector);
            } else {
                echo "Error en la primera llamada<br>";
            }

            echo "<br><br>";

            // Llamada con clave inválida
            if (cuentaVeces($vector, "2daw", 5, $numero)) {
                echo "Llamada nº $numero<br>";
                echo "Vector actualizado:<br>";
                print_r($vector);
            } else {
                echo "Error: clave inválida ('2daw')<br>";
            }

    /**ejercicio 2 */
    //EL . ES PARA CONCATENAR
    echo "<h3>Ejercicio 2: Generar cadena</h3>";

        echo "Cadena aleatoria de 7 caracteres: " .generarCadena(7). "<br>";
        echo "Cadena aleatoria de 0 caracteres: " .generarCadena(0);

    /**ejercicio 3 */
    echo "<h3>Ejercicio 3: Operaciones</h3>";
            
        echo "Suma:".operaciones(1,2,3,4,5)."<br>";
        echo "Resta:".operaciones(2,1,2,3,4)."<br>";
        echo "Multiplicacion:".operaciones(3,1,2,3,4)."<br>";
        echo "Suma pares // Resta impares:".operaciones(5,1,2,3,4,5,6);

    /**ejercicio 4 */
    //Lo unico que hace este ejercicio es modificar el valor de a, pero luego no afecta a la multiplicacion !!!!!!!!!!!
    echo "<h3>Ejercicio 4: Devuelve</h3>";
            $a = 7;
            $resultado = devuelve($a,4);

            echo "Valor modificado: $a <br>";      // Muestra: 21
            echo"El resultado es: $resultado";     //Muestra 280

    /**ejercicio 5 */
    echo "<h3>Ejercicio 5: suma, resta, multi </h3>";

            echo "Suma:".hacerOperacion('suma', 5, 3)."<br>"; // Resultado: 8
            echo "Resta:".hacerOperacion('resta', 10, 4)."<br>"; // Resultado: 6
            echo "Multi:".hacerOperacion('multi', 2, 5)."<br>"; // Resultado: 10
            $resultado = hacerOperacion('dividir', 4, 2); // operación no válida
            echo "División: " . ($resultado !== false ? $resultado : "No existe la division") . "<br>";

    /**ejercicio 6 */
    echo "<h3>Ejercicio 6: LLamada Funcion </h3>";

            echo llamadaAFuncion(1, 2, fn($a, $b) => $a + $b) . "<br>"; // suma → 3
            echo llamadaAFuncion(5, 3, fn($a, $b) => $a - $b) . "<br>"; // resta → 2
            echo llamadaAFuncion(4, 6, fn($a, $b) => $a * $b) . "<br>"; // multiplicación → 24

            echo "<h5>Con funciones anonumas</h5>";
                $sumar = function($a, $b) {
                    return $a + $b;
                };

                $restar = function($a, $b) {
                    return $a - $b;
                };

                $multiplicar = function($a, $b) {
                    return $a * $b;
                };

                echo llamadaAFuncion(1, 2, $sumar) . "<br>";       // → 3
                echo llamadaAFuncion(5, 3, $restar) . "<br>";      // → 2
                echo llamadaAFuncion(4, 6, $multiplicar) . "<br>"; // → 24
            
    /**ejercicio 7 */
    echo "<h3>Ejercicio 7: Ordenar </h3>";
            $vector = ["uno", "grande", "caminos", "a"];

            echo "<strong>Antes de ordenar:</strong><br>";
            foreach ($vector as $palabra) {
                echo "$palabra<br>";
            }

            ordenar($vector); // ordena el array

            echo "<br><strong>Después de ordenar:</strong><br>";
            foreach ($vector as $palabra) {
                echo "$palabra<br>";
            }
}