<<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once("/web/sitios/dwes/practicas_primer/scripts/librerias/validacion.php");

//controlador
$ubicacion = [
 "area personal"=> "../../index.php",
 "relacion 5"=> "./index.php",
 "ejercicio 1"=> "ejercicio1.php",

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


        echo "Esto es una clase de pruebas para la librería de validación <br><br>";


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

                        //  $fecha2 = "15/10/2023";
                        //  $result2 = validaFecha($fecha2, "1970-01-01");
                        //  echo "Valor: $fecha2 | Resultado: " . ($result2 ? "válido" : "inválido") . "\n";

        //PRUEBA validaHora en VAL_NORMAL y VAL_FILTER
                    //  $hora1 = "14:30:00";
                    //  $result1 = validaHora($hora1, "00:00:00");
                    //  echo "Valor: $hora1 | Resultado: " . ($result1 ? "válido" : "inválido") . "\n";

                    //  $hora2 = "25:00:00";
                    //  $result2 = validaHora($hora2, "00:00:00");
                    //  echo "Valor: $hora2 | Resultado: " . ($result2 ? "válido" : "inválido") . "\n";

        //PRUEBA validaemail en VAL_NORMAL y VAL_FILTER
                  //   $email1 = "usuario@dominio.com";
                  //   $result1 = validaEmail($email1, "aaaa@bbbb.ccc");
                  //   echo "Email: $email1 | Resultado: " . ($result1 ? "válido" : "inválido") . "\n";

                  // echo"  <br>";

                  //   // Caso con espacios
                  //   $email2 = "  usuarioAdominio.com ";
                  //   $result2 = validaEmail($email2, "aaaa@bbb.ccc");
                  //   echo "Email: $email2 | Resultado: " . ($result2 ? "válido" : "inválido") . "\n";

      
        //PRUEBA validaCadena en VAL_NORMAL y VAL_FILTER
                  // $longi = 15;

                  // $cadena1 = "buenas Natalia";
                  // $result1 = validaCadena($cadena1,$longi,"buenas nombre");
                  // echo "Cadena: $cadena1 | Resultado: " .($result1 ? "valido" : "invalido") . "\n";

                  // echo"  <br>";

                  // $cadena2 = "buenas Natalia como estas?";
                  // $result2 = validaCadena($cadena2,$longi,"buenas nombre");
                  // echo "Cadena: $cadena2 | Resultado" .($result2 ? "valido" : "invalido") . "\n";

        //PRUEBA validaExpresion en VAL_NORMAL y VAL_FILTER
              // $expresion ="/^[A-Z][a-zA-Z]{4}[1-9]{2}$/";
             
              // $cadena1="Buena45"; 
              // $result1 = validaExpresion($cadena1,$expresion,"Ajjjj44");
              // echo"Cadena : $cadena1 | Resultado: " .($result1 ? "valido" : "invalido") ."\n";


              // echo " <br>";

              // $cadena2="Buecna454"; 
              // $result2 = validaExpresion($cadena2,$expresion,"Ajjjj44");
              // echo"Cadena : $cadena2 | Resultado: " .($result2 ? "valido" : "invalido") ."\n";



        //PRUEBA validaRango en VAL_NORMAL y VAL_FILTER
              // $posibles = ["rojo", "verde", "azul"];
             
              // $valor1="verde"; 
              // $result1 = validaRango($valor1,$posibles,1);
              // echo"Valor : $valor1 | Resultado: " .($result1 ? "valido" : "invalido") ."\n";

              // echo " <br>";


              // $valor2="amarillo"; 
              // $result2 = validaRango($valor2,$posibles,1);  
              // echo"Valor : $valor2 | Resultado: " .($result2 ? "valido" : "invalido") ."\n";

              

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







}

?>