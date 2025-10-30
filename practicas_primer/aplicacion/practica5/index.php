<<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once("/web/sitios/dwes/practicas_primer/scripts/librerias/validacion.php");

//controlador
$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 4"=> "./index.php",

 ];

 $GLOBALS["Ubicacion"]=$ubicacion;


///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo();  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo() {

        //PRUEBA validaEntero VAL_NORMAL y VAL_FILTER
                    //  $var = 1;
                    //  $resultado = validaEntero($var, 5, 7, 7);

                    //  echo "Valor: $var | Resultado: " . ($resultado ? "válido" : "inválido") . "\n";


                    //  echo"<h1>BIEN</h1>";
                    //  $valor1 = 25;
                    //  $result1 = validaEntero($valor1, 10, 30, 0);
                    //  echo "Valor: $valor1 | Resultado: " . ($result1 ? "válido" : "inválido") . "\n";


        //PRUEBA validaReal en VAL_NORMAL y VAL_FILTER
                    // $real1 = 12.5;
                    // $result1 = validaReal($real1, 10.0, 20.0, 0.0);
                    // echo "Valor: $real1 | Resultado: " . ($result1 ? "válido" : "inválido") . "\n";

                    // $real2 = 25.7;
                    // $result2 = validaReal($real2, 10.0, 20.0, 0.0);
                    // echo "Valor: $real2 | Resultado: " . ($result2 ? "válido" : "inválido") . "\n";

        //PRUEBA validaFecha en VAL_NORMAL y VAL_FILTER
                        // $fecha1 = "2023-10-15";
                        // $result1 = validaFecha($fecha1, "1970-01-01");
                        // echo "Valor: $fecha1 | Resultado: " . ($result1 ? "válido" : "inválido") . "\n";

                        // $fecha2 = "15/10/2023";
                        // $result2 = validaFecha($fecha2, "1970-01-01");
                        // echo "Valor: $fecha2 | Resultado: " . ($result2 ? "válido" : "inválido") . "\n";

        //PRUEBA validaHora en VAL_NORMAL y VAL_FILTER
                    //  $hora1 = "14:30:00";
                    //  $result1 = validaHora($hora1, "00:00:00");
                    //  echo "Valor: $hora1 | Resultado: " . ($result1 ? "válido" : "inválido") . "\n";

                    //  $hora2 = "25:00:00";
                    //  $result2 = validaHora($hora2, "00:00:00");
                    //  echo "Valor: $hora2 | Resultado: " . ($result2 ? "válido" : "inválido") . "\n";

        //PRUEBA validaemail en VAL_NORMAL y VAL_FILTER
                    $email1 = "usuario@dominio.com";
                    $result1 = validaEmail($email1, "aaaa@bbbb.ccc");
                    echo "Email: $email1 | Resultado: " . ($result1 ? "válido" : "inválido") . "\n";

                  echo"  <br>";

                    // Caso con espacios
                    $email2 = "  usuarioAdominio.com ";
                    $result2 = validaEmail($email2, "aaaa@bbb.ccc");
                    echo "Email: $email2 | Resultado: " . ($result2 ? "válido" : "inválido") . "\n";

}

?>