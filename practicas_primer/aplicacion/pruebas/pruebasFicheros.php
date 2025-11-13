<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$rutaweb = "/imagenes/";
$fichero="subida.jpg";
$rutaphp=RUTABASE.$rutaweb;
//controlador
$errores=[];
$mostrar=false;

//verifico que ha subido un fichero
if(isset($_POST["subida"])){
$mostrar=true;
    if(isset($_FILES["archivo"])){
        //existe el archivo 

        //verifico que el fichero es correcto 
        if($_FILES["archivo"]["error"]<>0){
            
            $errores[]="errores en la subida del archivo";
        }

        //exijo que tenga tamaño
        if($_FILES["archivo"]["size"]==0){
            $errores[]="El fichero esta vacio";
        }
        
        //compruebo el tipo 
        if($_FILES["archivo"]["type"]!=="image/jpeg"){
            $errores[]="solo se permiten imagenes jpeg";
        }

        if(!$errores){
          if(!move_uploaded_file($_FILES["archivo"]["tmp_name"],$rutaphp.$fichero))
                $errores[]="solo se permiten imagenes jpeg";
  
        }
    }
    
}

///////////////////////////////////////////////////////////////////////

//dibuja la plantilla de la vista
inicioCabecera("Natalia Cabello Luque");
cabecera();
finCabecera();
inicioCuerpo("");
cuerpo($rutaweb.$fichero, $mostrar, $errores);  //llamo a la vista
finCuerpo();

// **********************************************************

//vista cabecera donde podemos ver los otros enlaces
function cabecera() 
{}

//vista
function cuerpo(string $fichero,string $mostrar,array $errores) {

    if($mostrar){
        foreach($errores as $error){
            echo "$error <br>".PHP_EOL;
        }
    }

    ?>
    esta clase es de ficheros 

    <form enctype="multipart/form-data"action="" method="POST">
    <!--MAX_FILE_SIZE debe preceder al campo de entrada de archivo-->
    <input type="hidden"name="MAX_FILE_SIZE"value="3000000000"/>
    <!-- El nombre del elemento de entrada determina el nombre en el array
    $_FILES -->
    Enviar este archivo: 
    <input name="archivo"type="file"/><br>
    <input type="submit"value="Enviar fichero" name="subida"/>
    </form>
    
    
    <?php

    if(!$errores){
        echo "<img src=\"{$fichero}\">";
    }
    else{
        $mostrar=true;
    }
  
 
}

?>