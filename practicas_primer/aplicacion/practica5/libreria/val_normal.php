<?php

/**
 * unction validaEntero(int &$var, int $min, int $max, int $defecto):bool Esta función 
*   comprueba que $var contiene un entero cuyo valor está entre $min y $max. En $var se 
*   devuelve el entero saneado (en caso de no cumplir las condiciones devuelve $defecto). La 
*   función devuelve true si es correcto y false en caso contrario.
 *
 * @param integer $var
 * @param integer $min
 * @param integer $max
 * @param integer $defecto
 * @return boolean
 */
function validaEntero(int &$var, int $min, int $max, int $defecto): bool{
 // Comprobamos si el valor está dentro del rango permitido
    if (is_int($var) && $var >= $min && $var <= $max) {
        return true;
    }

    // Si no cumple, asignamos el valor por defecto
    $var = $defecto;
    return false;
}







/**
 * function validaReal(float &$var, float $min, float $max, float $defecto):bool Esta función 
*comprueba que $var contiene un real cuyo valor está entre $min y $max. En $var se devuelve 
*el real saneado (en caso de no cumplir las condiciones devuelve $defecto). La función 
*devuelve true si es correcto y false en caso contrario
*@param float $var
*@param float $min
*@param float $max
*@param float $defecto
*@return boolean
 */

function validaReal(float &$var, float $min, float $max, float $defecto): bool{

    if(is_float($var) && $var >= $min && $var <= $max){
        return true;
    }

    $var = $defecto;
    return false;
}








/**
 * function validaFecha(string &$var, string $defecto):bool Esta función comprueba que $var 
*contiene una fecha correcta en el formato dd/mm/aaaa. En $var se devuelve la fecha saneada 
*(2 cifras para dia y mes y cuatro para año- ej fecha 1/2/2023 es válida aunque se sanea y se 
*convierte en 01/02/2023). En caso de no cumplir las condiciones devuelve $defecto en 
*$var. La función devuelve true si es correcta y false en caso contrario. 
*@param string $var
*@param string $defecto
*@return boolean
 */

function validaFecha(string &$var, string $defecto): bool{

    //Divide la cadena $var en partes usando /
     $fecha = mb_split("/", $var);

    // Validar que hay tres partes
    if (count($fecha) !== 3) {
        $var = $defecto;
        return false;
    }

    //Añade ceros a la izquierda si el día o el mes tienen solo una cifra.
    if (strlen($fecha[0]) == 1) {
        $fecha[0] = "0" . $fecha[0];
    }
    if (strlen($fecha[1]) == 1) {
        $fecha[1] = "0" . $fecha[1];
    }

    //checkdate() comprueba si la fecha es válida y lo de abajo lo construye con el formato aa/bb/aaaa
    if (checkdate($fecha[1], $fecha[0], $fecha[2])) {
        $var = $fecha[0] . "/" . $fecha[1] . "/" . $fecha[2];
        return true;
    } else {
        $var = $defecto;
        return false;
    }

}







/**
 *function validaHora(string &$var, string $defecto):bool Esta función comprueba que $var 
*contiene una hora correcta en el formato hh:mm:ss . En $var se devuelve la hora saneada (2 
*cifras para hora, min, segundos - Ej 0:5:1, hora valida aunque se sanea y se convierte a 
*00:05:01). En caso de no cumplir las condiciones devuelve $defecto en $var. La función 
*devuelve true si es correcta y false en caso contrario 
 *
 * @param string $var
 * @param string $defecto
 * @return boolean
 */
function validaHora(string &$var, string $defecto): bool{

    //Divide la cadena $var en partes usando /
     $hora = mb_split(":", $var);

    // Validar que hay tres partes
    if (count($hora) !== 3) {
        $var = $defecto;
        return false;
    }

    //Añade ceros a la izquierda si la hora,minuto o segundos tienen solo una cifra.
    if (strlen($hora[0]) == 1) {
        $hora[0] = "0" . $hora[0];
    }
    if (strlen($hora[1]) == 1) {
        $hora[1] = "0" . $hora[1];
    }
    if (strlen($hora[2]) == 1) {
        $hora[1] = "0" . $hora[2];
    }

    //No existe un metodo como tal para validar horas, asi que lo hacemos a mano
    $h = (int)$hora[0];
    $m = (int)$hora[1];
    $s = (int)$hora[2];

    if ($h >= 0 && $h <= 23 && $m >= 0 && $m <= 59 && $s >= 0 && $s <= 59) {
        $var = $hora[0] . ":" . $hora[1] . ":" . $hora[2];
        return true;
    } else {
        $var = $defecto;
        return false;
    }

}





/**
 * function validaEmail(string &$var, string $defecto):bool Esta función comprueba que $var 
*contiene un email correcto en el formato aaaaa@bbbb.ccc. En $var se devuelve el email 
*saneado (en caso de no cumplir las condiciones devuelve $defecto). La función devuelve 
*true si es correcto y false en caso contrario. 
 *
 * @param string $var
 * @param string $defecto
 * @return boolean
 */
function validaEmail(string &$var, string $defecto): bool{
// Eliminar espacios y caracteres invisibles
    $var = trim($var);

    $email = '/^[\w-]+@[\w\-]+\.\w{2,}$/';

    if (preg_match($email, $var)) {
        return true;
    } else {
        $var = $defecto;
        return false;
    }

}





/**
 * function validaCadena(string &$var, int $longitud, string $defecto):bool Esta función 
*comprueba que $var contiene una cadena de longitud máxima $longitud. En caso de no 
*cumplir las condiciones se asigna a $var el valor $defecto. La función devuelve true si es 
*correcto y false en caso contrario. 
 *
 * @param string $var
 * @param integer $longitud
 * @param string $defecto
 * @return boolean
 */
function validaCadena(string &$var, int $longitud, string $defecto): bool{

    if(mb_strlen($var) <= $longitud){
        return true;
    }

    $var = $defecto;
    return false;
}






/**
 * Undocumented function
 *
 * @param string $var
 * @param string $expresion
 * @param string $defecto
 * @return boolean
 */
function validaExpresion(string &$var, string $expresion, string $defecto): bool{
return true;

}
////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Undocumented function
 *
 * @param mixed $var
 * @param array $posibles
 * @param integer $tipo
 * @return boolean
 */
function validaRango(mixed $var, array $posibles, int $tipo = 1): bool{
return true;

}
?>
