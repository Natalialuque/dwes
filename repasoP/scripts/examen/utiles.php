<?php

/**
 * comprueba si la fecha introducida es anterior a 18 años indicando que
 * la persona es mayor de edad
 *
 * @param string $fechaNac
 * @return boolean
 */
function mayorEdad(string $fechaNac): bool
{

    $fechaMod = mb_split("/|-", $fechaNac);

    $mayoriaEdad = new DateTime("-18 year");
    $fecha = new DateTime($fechaMod[0] . "-" . $fechaMod[1] . "-" . $fechaMod[2]);

    if ($mayoriaEdad <= $fecha) {
        return false;
    }

    return true;
}

/**
 * comprueba si la fecha introducida es anterior a la fecha actual
 *
 * @param string $fechaNac
 * @return boolean
 */
function fechaAnteriorHoy(string $fechaNac): bool
{

    $fechaMod = mb_split("/", $fechaNac);

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
 * Funcion privada que comprueba la validez de los dos tipos de 
 * NIF aceptados.
 * 
 * Tipos de NIF válidos:
 *  - A9999999A
 *  - 99999999A
 *
 * @param string $nif
 * @return boolean
 */
function validaNIF(string $nif): bool
{

    $exp = "/[0-9]{8}[A-Z]{1}|[A-Z]{1}[0-9]{7}[A-Z]{1}/";

    if (preg_match($exp, $nif)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Método que carga los objetos Beneficiario con sus respectivos bonos desde
 * un fichero que le llega como parametro
 *
 * @param string $nombreFichero
 * @param array $datos
 * @return boolean Resultado de la carga
 */
function cargarBeneficiarioDesdeFichero(string $nombreFichero, array &$datos): bool
{

    //ruta en la que se cargara el fichero
    $ruta = RUTABASE .  "/imagenes/";

    //si no existe la ruta se crea
    if (!file_exists($ruta)) {
        mkdir($ruta);
    }

    $ruta .= $nombreFichero;
    //se abre el fichero para lectura
    //debe existir
    $fic = fopen($ruta, "r");
    if (!$fic)
        return false;
    //borro el contenido del array
    foreach ($datos as $pos => $valor) {
        unset($datos[$pos]);
    }

    //leo el fichero linea a linea
    while ($linea = fgets($fic)) {
        $linea = str_replace("\r", "", $linea);
        $linea = str_replace("\n", "", $linea);
        if ($linea != "") {
            $linea = mb_split(":|;|\|\|\|\||BONOS=|BENEFICIARIO=", $linea); //descomponemos la información
            $objeto = new Beneficiario($linea[2], $linea[4], $linea[6], $linea[8]); //cargamos el objeto

            for ($i = 10; $i < count($linea); $i = $i + 2) { //cargamos los bonos
                $numBonos = 0;
                $objeto->aniadeBonos($numBonos, $linea[$i], $linea[$i + 1]);
            }

            //$datos[] = $objeto;
            array_push($datos, $objeto); //guardamos el objeto
        }
    }

    //se cierra el fichero
    fclose($fic);

    return true;
}

/**
 * Funcion que recibe un nombre de archivo y un objeto para escribirlo en un fichero
 *
 * @param string $nombre
 * @param array $beneficiario
 * @return void
 */
function escribeFichero(string $nombre, object $beneficiario): bool
{

    $ruta = $_SERVER["DOCUMENT_ROOT"] . "/aplicacion/temp/";
    //$ruta = RUTABASE . "/aplicacion/archivos";  

    //si no existe la ruta la creamos
    if (!file_exists($ruta)) {
        mkdir($ruta);
    }

    //añadimos el nombre al fichero
    $ruta .= $nombre;

    //se abre el fichero para escritura
    //si existe se borra el contenido
    $fic = fopen($ruta, "w");
    if (!$fic) {
        return false;
    }

    $bonos = $beneficiario->getListaBonos();

    $lista = "Bonos: \n";
    foreach ($bonos as $tipo => $valor) {
        $lista .= $tipo . "--> " . $valor . "€ \n";
    }

    fputs($fic, $beneficiario . "\n");
    fputs($fic, $lista);

    //se cierra el fichero
    fclose($fic);

    return true;
}
