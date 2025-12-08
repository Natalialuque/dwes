<?php

/**
 * comprueba que $var contiene un entero cuyo valor está entre $min y $max. En $var se devuelve el entero saneado (en caso de no cumplir las condiciones devuelve $defecto). La  función devuelve true si es correcto y false en caso contrario. 
 *
 * @param integer $var
 * @param integer $min
 * @param integer $max
 * @param integer $defecto
 * @return boolean
 */
function validaEntero(int &$var, int $min, int $max, int $defecto): bool
{
    $result = false;
    if (is_int($var)) {
        if ($var >= $min && $var <= $max) {
            return true;
        } else {
            $var = $defecto;
        }
    }
    return $result;
}

/**
 * Esta función comprueba que $var contiene un real cuyo valor está entre $min y $max. En $var se devuelve el real saneado (en caso de no cumplir las condiciones devuelve $defecto). La función devuelve true si es correcto y false en caso contrario. 
 *
 * @param float $var
 * @param float $min
 * @param float $max
 * @param float $defecto
 * @return boolean
 */
function validaReal(float &$var, float $min, float $max, float $defecto): bool
{

    $result = false;
    if (is_numeric($var)) {
        if ($var >= $min && $var <= $max) {
            return true;
        } else {
            $var = $defecto;
        }
    }
    return $result;
}

/**
 *  Esta función comprueba que $var contiene una fecha correcta en el formato dd/mm/aaaa. En $var se devuelve la fecha saneada (2 cifras para dia y mes y cuatro para año- ej 07/02/2023, valido 1/2/2023 aunque se sanea y se convierte en 01/02/2023). En caso de no cumplir las condiciones devuelve $defecto en $var. La función devuelve true si es correcta y false en caso contrario. 
 *
 * @param string $var
 * @param string $defecto
 * @return boolean
 */
function validaFecha(string &$var, string $defecto): bool
{
    $expresion = "/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/";
    // $expresion = "/^\d{1,2}\/\d{1,2}\/\d{4}$/";

    if (preg_match($expresion, $var, $matches)) {
        
        $matches[1] = mb_strlen($matches[1]) == 2 ? $matches[1] : "0" . $matches[1];
        $matches[2] = mb_strlen($matches[2]) == 2 ? $matches[2] : "0" . $matches[2];

        $dia = $matches[1];
        $mes = $matches[2];
        $year = $matches[3];

        if (checkdate((int)($mes), (int)($dia), (int)($year))) {
            $var = $dia . "/" . $mes . "/" . $year;
            return true;
        }
        else 
        {
            $var = $defecto;
            return false;
        }

        } 
        else {
        $var = $defecto;
        return false;
    }
}

/**
 *  Esta función comprueba que $var contiene una hora correcta en el formato hh:mm:ss . En $var se devuelve la hora saneada (2 cifras para hora, min, segundos - Ej 04:25:03, valido 0:5:1 aunque se sanea y se convierte a 00:05:01) (en caso de no cumplir las condiciones devuelve $defecto en $var). La función devuelve true si es correcta y false en caso contrario 
 *
 * @param string $var
 * @param string $defecto
 * @return boolean
 */
function validaHora(string &$var, string $defecto): bool
{
    $expresion = "/^(\d{1,2}):(\d{1,2}):(\d{1,2})$/";

    if (preg_match($expresion, $var, $matches)) {
        if (intval($matches[1]) > 23 || intval($matches[1]) < 0) {
            $var = $defecto;
            return false;
        }
        if (intval($matches[2]) > 59 || intval($matches[2]) < 0) {
            $var = $defecto;
            return false;
        }
        if (intval($matches[3]) > 59 || intval($matches[3]) < 0) {
            $var = $defecto;
            return false;
        }
        $matches[1] = mb_strlen($matches[1]) == 2 ? $matches[1] : "0" . $matches[1];
        $matches[2] = mb_strlen($matches[2]) == 2 ? $matches[2] : "0" . $matches[2];
        $matches[3] = mb_strlen($matches[3]) == 2 ? $matches[3] : "0" . $matches[3];
        $var = $matches[1] . ":" . $matches[2] . ":" . $matches[3];

        return true;
    } else {
        $var = $defecto;
        return false;
    }
}


/**
 * Esta función comprueba que $var contiene un email correcto en el formato aaaaa@bbbb.ccc. 
 * En $var se devuelve el email saneado (en caso de no cumplir las condiciones devuelve $defecto).
 * La función devuelve true si es correcto y false en caso contrario. 
 *
 * @param string $var
 * @param string $defecto
 * @return boolean
 */
function validaEmail(string &$var, string $defecto): bool
{
    $reg = "/([a-zA-Z0-9]{1,})(\.[a-zA-Z0-9]{1,})*@([a-zA-Z0-9]{1,}\.[a-zA-Z]{1,})/";

    $regex_emails = '/\b[a-zA-Z]{1,}[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}\b/';

    if (preg_match($reg, $var)) {
        return true;
    } else {
        $var = $defecto;
        return false;
    }
}

/**
 * Esta función comprueba que $var contiene una cadena de longitud máxima $longitud. 
 * En caso de no cumplir las condiciones se asigna a $var el valor $defecto. 
 * La función devuelve true si es correcto y false en caso contrario.
 *
 * @param string $var
 * @param integer $longitud
 * @param string $defecto
 * @return boolean
 */
function validaCadena(string  &$var, int $longitud, string $defecto):bool{
    if(mb_strlen($var)<=$longitud){
        return true;
    }
    else{
        $var=$defecto;
        return false;
    }
}

/**
 * Esta función comprueba que $var cumple con la expresión regular $expresion.
 *  En caso de no cumplir las condiciones se asigna a $var el valor por $defecto. 
 * La función devuelve true si es correcto y false en caso contrario.
 *
 * @param string $var
 * @param string $expresion
 * @param string $defecto
 * @return void
 */
function validaExpresion(string &$var, string $expresion, string $defecto):bool{

    if(preg_match($expresion, $var)){
        return true;
    }
    else{
        $var=$defecto;
        return false;
    }

}

/**
 * Esta función comprueba que $var sea igual a uno de los elementos del array $posibles ($tipo=2)
 *  o a una de las claves del array $posibles ($tipo=1). 
 * La función devuelve true si es correcta y false en caso contrario
 *
 * @param mixed $var
 * @param array $posibles
 * @param integer $tipo
 * @return boolean
 */
function validaRango(mixed $var, array $posibles, int $tipo=2):bool{
    if($tipo == 2){
        return in_array($var,$posibles);
    }
    else if ($tipo==1){
        return key_exists($var, $posibles);
    }
    else    return false;

}

/**
 * Comprueba si la fecha introducida es anterior o igual a la fecha actual
 *
 * @param string $fecha
 * @return boolean
 */
function ComprobarFecha(string $fecha): bool
{

    $fechaMod = mb_split("/", $fecha);

    $hoy = new DateTime(); //fecha actual
    if (count($fechaMod) == 3) {
        $fecha = new DateTime($fechaMod[2] . "-" . $fechaMod[1] . "-" . $fechaMod[0]);
    } else {
        return false;
    }

    if ($hoy < $fecha) {
        return false;
    }

    return true;
}


/**
 * compara si la fecha de inicio es menor a la fecha fin
 *
 * 
 * @return boolean
 */
function compararFechas(string $fechaInici, string $fechaFin): bool
{

    $fechaModIni = mb_split("/", $fechaInici);
    $fechaModFin = mb_split("/", $fechaFin);

    if (count($fechaModIni) == 3) {
        $fechaini = new DateTime($fechaModIni[2] . "-" . $fechaModIni[1] . "-" . $fechaModIni[0]);
    } else {
        return false;
    }
    if (count($fechaModFin) == 3) {
        $fecha = new DateTime($fechaModFin[2] . "-" . $fechaModFin[1] . "-" . $fechaModFin[0]);
    } else {
        return false;
    }

    if ($fechaModIni > $fecha) {
        return false;
    }

    return true;
}