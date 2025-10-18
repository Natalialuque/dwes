<?php
// libreria.php

/**
 * Ejercicio 1 cuentaVeces
 * Añade un valor al array en la clave indicada y actualiza el contador de llamadas.
 * @param array &$array
 * @param string $clave
 * @param int $valor
 * @param int &$contador
 * @return bool
 */
function cuentaVeces(array &$array, string $clave, int $valor1, int &$valor2): bool {
    if ($clave === "2daw" || $clave === "primera") {
        return false;
    }
    $valor2++;

    // Añadir el valor al array en la clave indicada
    //isset se encarga de coprobar si el array tiene otro valor antes de introducir uno nuevo
    if (isset($array[$clave])) {
        $array[$clave] += $valor1;
    } else {
        $array[$clave] = $valor1;
    }

    return true;
}


/**
 * Ejercicio2 generarCadena
 * Genera una cadena aleatoria de longitud dada.
 * @param int $longitud
 * @return string|false
 */
function generarCadena(int $numero = 10): string|false {
    
    ///Devolverá false si se ha indicado un número negativo o igual a 0.
    if($numero<=0){
        return false;
    }

    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $cadena = '';

        for ($i = 0; $i < $numero; $i++) {
           $indiceAleatorio = rand(0, strlen($caracteres) - 1);
           $cadena .= $caracteres[$indiceAleatorio];
        }

        return $cadena;

}


/**
 * Ejercicio3 operaciones
 * Realiza operaciones según el tipo indicado.
 * @param int $tipo
 * @param float ...$numeros
 * @return float|false
 */
//el float ...$numeros permite que la funcion reciba una cantidad idefinida de datos
function operaciones(int $tipo, float ...$numeros): float|false {

    switch ($tipo){
        case 1 : //suma 
            return array_sum($numeros);
        case 2: 
            $resultado = array_shift($numeros); // toma el primer número
            foreach ($numeros as $num) {//va sacando el los numeros del array
                $resultado -= $num;
            }
            return $resultado;
        case 3: 
            return array_product($numeros);
        default: // suma de pares, resta de impares (posición 1 es impar)
            $resultado = 0;
            foreach ($numeros as $i => $num) {
                $posicion = $i + 1; // porque el primer operando es posición 1
                if ($posicion % 2 === 0) {
                    $resultado += $num; // posición par → sumar
                } else {
                    $resultado -= $num; // posición impar → restar
                }
            }
            return $resultado;

        
    }

    return 0;

}


/**
 * Ejercicio 4 devuelve
 * Devuelve el producto de tres números y actualiza el primero con la suma.
 * @param int &$a
 * @param int $b
 * @param int $c
 * @return int
 */
//los dos segundos valores son fijos y el valor a es el que modificamos
function devuelve(int &$a, int $b, int $c = 10): int {
        $resultado=$a*$b*$c;
        $a = $a + $b +$c;
        return $resultado;

}

///////////////////////////////////////////////////////////////////////////////////////////////
/**EJERCICIO 5 */

function suma(int $a, int $b): int {
    return $a + $b;
}

function resta(int $a, int $b): int {
    return $a - $b;
}

function multiplicacion(int $a, int $b): int {
    return $a * $b;
}

/**
 * 5--> hacerOperacion
 * Ejecuta una operación usando una variable función.
 * @param string $operacion
 * @param int $a
 * @param int $b
 * @return int|false
 */
function hacerOperacion(string $operacion, int $a, int $b): int|false {
// Variables que almacenan funciones
    $fSuma = 'suma';
    $fResta = 'resta';
    $fMulti = 'multiplicacion';

    switch ($operacion) {
        case 'suma':
            return $fSuma($a, $b); // llama a la función suma() usando la variable
        case 'resta':
            return $fResta($a, $b); // llama a la función resta() usando la variable
        case 'multi':
            return $fMulti($a, $b); // llama a la función multiplicacion() usando la variable
        default:
            return false; // operación no reconocida
    }

}

////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Ejercicio 6: llamadaAFuncion
 * Llama a una función callback con dos operandos.
 * @param int $a
 * @param int $b
 * @param callable $callback
 * @return int
 */
// Aquí, aplicarOperacion no sabe qué operación va a hacer. Solo sabe que recibirá una función ($operacion) que puede ejecutar con $a y $b.
function llamadaAFuncion(int $a, int $b, callable $callback): int {
    return $callback($a, $b);
}


/**
 * Ejercicio 7: ordenar
 * Ordena un array en orden descendente por longitud de elementos.
 * @param array &$array
 * @return void
 */
function ordenar(array &$array): void {

    //usort para ordenar cadenas personalizadas
    usort($array, function($a, $b) {
        return strlen($b) - strlen($a); // orden descendente por longitud
    });

}


?>