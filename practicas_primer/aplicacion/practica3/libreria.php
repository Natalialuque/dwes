<?php
// libreria.php

/**
 * 1. cuentaVeces
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
 * 2. generarCadena
 * Genera una cadena aleatoria de longitud dada.
 * @param int $longitud
 * @return string|false
 */
function generarCadena(int $longitud = 10): string|false {
    // Implementación aquí
        return 0;

}


/**
 * 3. operaciones
 * Realiza operaciones según el tipo indicado.
 * @param int $tipo
 * @param float ...$numeros
 * @return float|false
 */
function operaciones(int $tipo, float ...$numeros): float|false {
    // Implementación aquí
        return 0;

}


/**
 * 4. devuelve
 * Devuelve el producto de tres números y actualiza el primero con la suma.
 * @param int &$a
 * @param int $b
 * @param int $c
 * @return int
 */
function devuelve(int &$a, int $b = 4, int $c = 10): int {
    // Implementación aquí
        return 0;

}


/**
 * 5. suma
 * @param int $a
 * @param int $b
 * @return int
 */
function suma(int $a, int $b): int {
    return $a + $b;
}

/**
 * 5. resta
 * @param int $a
 * @param int $b
 * @return int
 */
function resta(int $a, int $b): int {
    return $a - $b;
}

/**
 * 5. multiplicacion
 * @param int $a
 * @param int $b
 * @return int
 */
function multiplicacion(int $a, int $b): int {
    return $a * $b;
}

/**
 * 5. hacerOperacion
 * Ejecuta una operación usando una variable función.
 * @param string $operacion
 * @param int $a
 * @param int $b
 * @return int|false
 */
function hacerOperacion(string $operacion, int $a, int $b): int|false {
    // Implementación aquí
        return 0;

}


/**
 * 6. llamadaAFuncion
 * Llama a una función callback con dos operandos.
 * @param int $a
 * @param int $b
 * @param callable $callback
 * @return int
 */
function llamadaAFuncion(int $a, int $b, callable $callback): int {
    // Implementación aquí
        return 0;

}


/**
 * 7. ordenar
 * Ordena un array en orden descendente por longitud de elementos.
 * @param array &$array
 * @return void
 */
function ordenar(array &$array): void {
    // Implementación aquí
}


?>