<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $PoblacionId = $_POST["poblacion"] ?? "";
    if ($PoblacionId == "") {
        paginaError("poblacion invalida");
        exit();
    }

    if (!isset($POBLACIONES[$PoblacionId])) {
        paginaError("La poblacion indicada no es válida");
        exit();
    }

    $poblacion = $POBLACIONES[$PoblacionId];

    header("Content-Type: text/plain");

    echo $poblacion->getNombre() . " , " . $poblacion->getOrigen();
    echo "\n";
    foreach ($poblacion->dameElementos() as $elementos) {
        $args = [];

        foreach ($elementos as $key => $value) {
            $args[] = $key . ":" . $value . "";
        }

        for ($i = 0; $i < count($args); $i++) {
            if ($i != 0) {
                echo " ; ";
            }

            echo $args[$i];
        }
        echo "\n";
    }
    echo "\n";

    if (isset($_POST["descargar"]) && $_POST["descargar"]) {
        header('Content-Disposition: attachment; filename="poblacion.txt"');
    }
    exit();
} else {
    header("Location: /");
}

inicioCabecera("Enviar coleccion");
finCabecera();

inicioCuerpo("Enviar coleccion");
finCuerpo();
