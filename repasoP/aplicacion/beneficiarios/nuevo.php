<?php

include_once(dirname(__FILE__) . "/../../cabecera.php");

// header("refresh: 1 /aplicacion/practica1/index.php");
// paginaError("no es lo que esparabas");
// exit;

// echo "Ruta física a la raiz del sitio ".RUTABASE."<br>".PHP_EOL;
// echo "url a la que se llama ".$_SERVER["HTTP_HOST"]."<br>".PHP_EOL;
// echo "url a la que se llama ".$_SERVER["SERVER_NAME"]."<br>".PHP_EOL;

$nombre = "";
$nif = "";
$reduccion = 0;
$fecha = "";

$datos = [
    "nombre" => $nombre,
    "nif" => $nif,
    "reduccion" => $reduccion,
    "fecha" => $fecha
];

if(isset($errores)){
    unset($errores);
    $errores = [];
}
else{
    $errores = [];
}

if(isset($_POST) && count($_POST) > 0){

    $benef=new Beneficiario("jdjdj","11111111A",1,date("d/m/Y"));

    if(isset($_POST["nombre"])){
        //if (!$benef->set_nombre($_POST["nombre"]))
        if(!validaCadena($_POST["nombre"], 30, "")){
            $errores["nombre"] = "El nombre tiene mas de 30 caracteres \n";
        }
        if(trim($_POST["nombre"]) == ""){
            $errores["nombre"] = "No se introdujo un nombre\n";
        }
        $datos["nombre"] = trim($_POST["nombre"]);
    }

    if(isset($_POST["nif"])){
        if(!validaNIF($_POST["nif"])){
            $errores["nif"] = "El NIF es incorrecto, debe de tener la siguiente forma A9999999A o 99999999A\n";
        }
        if(trim($_POST["nif"]) == ""){
            $errores["nif"] = "No se introdujo un NIF\n";
        }
        $datos["nif"] = trim($_POST["nif"]);
    }

    if(isset($_POST["reduccion"])){
        $valor = intval($_POST["reduccion"]);
        // if(!validaEntero($valor, 3, 1, 0)){ //mirar
            if(!($valor >= 1 && $valor <= 3)){
                $errores["reduccion"] = "Se introdujo un valor erróneo como valor de reduccion\n";
            }
            $datos["reduccion"] = $valor;
    }

    if(isset($_POST["fecha"])){
        if(!validaFecha($_POST["fecha"], $_POST["fecha"])){
            $errores["fecha"] = "Se introducjo una fecha no válida\n";
        }
        if(!fechaAnteriorHoy($_POST["fecha"])){
            $errores["fecha"] = "Se inserto una fecha posterior a la actual\n";
        }
        $datos["fecha"] = trim($_POST["fecha"]);
    }

    if(count($errores) == 0){
        try {
            $beneficiario = new Beneficiario($datos["nombre"], $datos["nif"], $datos["reduccion"], $datos["fecha"]);
            $benefi[]=$beneficiario;
            
            $_SESSION["BENEFI"]=$benefi;
            header("location: /index.php");
        } catch (\Throwable $th) {
           $errores["nombre"]="Error al crear el objeto"; 
        }
        
       
    }

}

inicioCabecera("PRACTICA 9");
cabecera();
finCabecera();

inicioCuerpo("PRACTICA 9");
cuerpo($datos, $errores);
finCuerpo();

// **********************************************************

function cabecera()
{
}


function cuerpo(array $datos, array $errores)
{
?>


    <ul><a href="../../index.php">Volver al index</a></ul>

    <br>

    <?php
    formularioNuevo($datos, $errores);
    
}

function formularioNuevo(array $datos, array $errores){

    ?>

    <form method="post">
        <h3>Creació nuevo Beneficiario:</h3>

        <?php

        if(isset($errores["nombre"])){
            echo "<div class='error'> " . $errores["nombre"] . "</div>";
        }

        ?>

        <label for="nombre">Nombre: &nbsp;</label>
        <input type="text" name="nombre" id="" value="<?php echo $datos["nombre"] ?>" placeholder="Nombre">
        <br>

        <?php

        if(isset($errores["nif"])){
            echo "<div class='error'> " . $errores["nif"] . "</div>";
        }

        ?>

        <label for="nif">NIF: &nbsp;</label>
        <input type="text" name="nif" id="" value="<?php echo $datos["nif"] ?>" placeholder="NIF">
        <br>

        <?php

        if(isset($errores["reduccion"])){
            echo "<div class='error'> " . $errores["reduccion"] . "</div>";
        }

        ?>

        <label for="reduccion">Tipo de reducción: &nbsp;</label>
        <select name="reduccion" id="">
            
        <?php
        $reducciones = [
            1 => "Sin reducciones",
            2=> "Discapacidad",
            3=> "Familia numerosa",
        ];

        foreach($reducciones as $clave => $value){
            if($datos["reducciones"] == $clave){
                echo "<option value=". $clave ."selected >". $value ."</option>";
            }
            else{
                echo "<option value='". $clave ."'>". $value ."</option>";
            }
        }

        ?>

        </select>
        <br>

        <?php

        if(isset($errores["fecha"])){
            echo "<div class='error'> " . $errores["fecha"] . "</div>";
        }

        ?>

        <label for="fecha">Fecha de nacimiento: &nbsp;</label>
        <input type="text" name="fecha" id="" value="<?php echo $datos["fecha"] ?>" placeholder="dia/mes/año">
        <br><br>

        <input type="submit" value="enviar">
        <input type="reset" value="borrar">
    </form>

    <?php

}