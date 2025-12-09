<?php
//namespace VALFILTER; //no poner si no hay dos iguales, si no se usa falla todo el rato y no sale error en el ide

/**
 * Esta función comprueba que $var contiene un entero cuyo valor está entre $min y $max. 
 * En $var se devuelve el entero saneado (en caso de no cumplir las condiciones devuelve $defecto)
 *
 * @param integer $var
 * @param integer $min
 * @param integer $max
 * @param integer $defecto
 * @return boolean -> La función devuelve true si es correcto y false en caso contrario
 */
function validaEntero(int &$var, int $min, int $max, int $defecto): bool
{
    $resultado  = false;
    if (filter_var($var, FILTER_VALIDATE_INT, array("options" => array("min_range" => $min, "max_range" => $max)))) {
        $resultado = true;
    } else {
        $var = $defecto;
    }
    return $resultado;
}

/** Esta función comprueba que $var contiene un real cuyo valor está entre $min y $max. En $var se devuelve
 * el real saneado (en caso de no cumplir las condiciones devuelve $defecto).
 * 
 * @param float &$var 
 * @param float $min
 * @param float $max
 * @param int $defecto
 * 
 * @return --> La función devuelve true si es correcto y false en caso contrario.
 * 
 */
function validaReal(float &$var, float $min, float $max, int $defecto): bool
{

    $resultado  = false;

    $opciones = [
        'options' => [
            'min_range' => $min,
            'max_range' => $max,
        ],
    ];

    $real = filter_var($var, FILTER_VALIDATE_FLOAT, $opciones);

    if ($real) {
        $resultado = true;
    } else {
        $var = $defecto;
    }

    return $resultado;
}


/** Esta función comprueba que $var contiene una fecha correcta en el formato dd/mm/aaaa. 
 * En $var se devuelve la fecha saneada (2 cifras para dia y mes y cuatro para año- ej 07/02/2023).
 * 
 * @param string &$var
 * @param string $defecto
 * 
 * @return --> En caso de no cumplir las condiciones devuelve $defecto en $var. 
 * La función devuelve true si es correcta y false en caso contrario
 */
function validaFecha(string &$var, string $defecto): bool {
    $resultado = false;
    $exp = "/\d{1,2}\/\d{1,2}\/\d{4}/";
    if(filter_var($var,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=> $exp)))) 
        {
            $array = mb_split("/", $var);
            if (checkdate($array[1], $array[0], $array[2])) 
                {
                    $resultado = true;
                    $var=mb_substr("00".$array[0],-2)."/".
                         mb_substr("00".$array[1],-2)."/".
                         $array[2];
                }
                else 
                {
                    $var = $defecto;
                }
        }
       else 
       {
        $var = $defecto;
        }
        
    return $resultado;

}

/** Esta función comprueba que $var contiene una fecha correcta en el formato aaaa/mm/dd. 
 * En $var se devuelve la fecha saneada (2 cifras para dia y mes y cuatro para año- ej 2023-07-20).
 * 
 * @param string &$var
 * @param string $defecto
 * 
 * @return --> En caso de no cumplir las condiciones devuelve $defecto en $var. 
 * La función devuelve true si es correcta y false en caso contrario
 */
function validaFechaObjeto(string &$var, string $defecto): bool {
    $resultado = false;
    $exp = "/\d{1,2}\/\d{1,2}\/\d{4}/";
    if(filter_var($var,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=> $exp)))) 
        {
            $array = mb_split("/", $var);
            if (checkdate($array[2], $array[1], $array[0])) 
                {
                    $resultado = true;
                    $var=mb_substr("00".$array[0],-2)."/".
                         mb_substr("00".$array[1],-2)."/".
                         $array[2];
                }
                else 
                {
                    $var = $defecto;
                }
        }
       else 
       {
        $var = $defecto;
        }
        
    return $resultado;

}

/**
 * Esta función comprueba que $var contiene una hora correcta en el formato hh:mm:ss . 
 * En $var se devuelve la hora saneada (2 cifras para hora, min, segundos - Ej 04:25:03) 
 * (en caso de no cumplir las condiciones devuelve $defecto en $var)
 * 
 * @param string &$var 
 * @param string $defecto
 * 
 * @return -> La función devuelve true si es correcta y false en caso contrario
 * 
 */

function validaHora(string &$var, string $defecto): bool{
    $resultado = false;
    $exp = "/[0-2]?[0-9]:[0-5]?[0-9]:[0-5]?[0-9]/";
    if(filter_var($var,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=> $exp)))){
        $resultado = true;
        $array = mb_split(":", $var);
        $var=mb_substr("00".$array[0],-2).":".
            mb_substr("00".$array[1],-2).":".
            mb_substr("00".$array[2],-2).":";
    }else {
        $var = $defecto;
    }

    return $resultado;
}


/** function validaEmail(string &$var, string $defecto): Esta función comprueba que $var
 *  contiene un email correcto en el formato aaaaa@bbbb.ccc. En $var se devuelve el email
 *  saneado (en caso de no cumplir las condiciones devuelve $defecto)
 * 
 * @param string &$var 
 * @param string $defecto
 * 
 * @return -> La función devuelve true si es correcto y false en caso contrario.
 */

 function validaEmail(string &$var, string $defecto):bool {

    $resultado = false;
    
    if(filter_var($var,FILTER_VALIDATE_EMAIL)){
        $resultado = true;
    }else {
        $var = $defecto;
    }

    return $resultado;

 }

  /** Esta función comprueba que $var contiene una cadena de longitud máxima $longitud. 
  * En caso de no cumplir las condiciones se asigna a $var el valor $defecto.
  * 
  * @param string &$var
  * @param int $longitud
  * @param string $defecto
  *
  * @return -> La función devuelve true si es correcto y false en caso contrario.
  *
  */
  function validaCadena(string &$var, int $longitud, string $defecto):bool {
    $resultado = false;

    if(mb_strlen($var)<=$longitud){
        $resultado = true;
    }else {
        $var = $defecto;
    }

    return $resultado;

 }


 /** Esta función comprueba que $var cumple con la expresión regular $expresion. 
 * En caso de no cumplir las condiciones se asigna a $var el valor por $defecto.
 * 
 * @param string &$var
 * @param string $expresion
 * @param string $defecto
 * 
 * @return -> La función devuelve true si es correcto y false en caso contrario.
 * 
 */

 function validaExpresion(string &$var, string $expresion, string $defecto):bool {
    $resultado = false;

    if(filter_var($var,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=> $expresion)))){
        $resultado = true;
    }else {
        $var = $defecto;
    }

    return $resultado;

 }

  /** Esta función comprueba que $var sea igual a uno de los elementos del array $posibles ($tipo=2) 
  * o a una de las claves del array $posibles ($tipo=1)
  * 
  * @param mixed &$var
  * @param array $posibles
  * @param int tipo = 2
  *
  * @return -> La función devuelve true si es correcta yfalse en caso contrario.
  */

  function validaRango(mixed $var, array $posibles, int $tipo=2): bool {
    $resultado = false;

    if($tipo === 2){
        $resultado = in_array($var,$posibles);
       
    }else if($tipo ===1) {
        $resultado = array_key_exists($var,$posibles);

    }

    return $resultado;

  }

 

  ?>