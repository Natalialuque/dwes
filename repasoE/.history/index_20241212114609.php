<?php




<?php
   include_once(dirname(__FILE__) . "/cabecera.php");

   $ubicacion = [
    [
        "posicion" => "Inicio",
        "direccion" => "/"
    ],
    ["posicion" => "Relación 8",],
];
   
   $numVeces=1;
   if (isset($_COOKIE["num_veces"])) 
       {
           $_COOKIE["num_veces"] = intval($_COOKIE["num_veces"]) + 1; // Incrementamos el valor
           setcookie("num_veces", $_COOKIE["num_veces"]); // Reasignamos el valor a la cookie
           $numVeces=$_COOKIE["num_veces"];
       } else {
           setcookie("num_veces", 0); // Creamos la cookie en caso de que no exista
           header("location: /index.php");
           exit;
       }
   
   
   
   // === VISTA ===
   inicioCabecera("RELACIÓN 8");
   cabecera();
   finCabecera();
   
   inicioCuerpo("RELACIÓN 8", $ubicacion);
   cuerpo($numVeces);
   finCuerpo();
   
   
   // **********************************************************
   
   function cabecera()
   {
       
   }
   
   
   function cuerpo(int $numVeces)
   {
       echo "<br> Nº de veces que ha visitado la página: " . $numVeces;
   ?>
  
   <?php
   
   }
   
