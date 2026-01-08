<?php
    echo "<br/>";

    echo "Hola mundo.";
    echo "<br/>";
    echo "<br/>".PHP_EOL;

    echo "funciona que no es poco pffff".PHP_EOL;
    



    echo Sistema::app()->generaURL(["usuario","borrar"]);
        echo "<br>";
    echo CHTML::link("modificar usuario",
                        Sistema::app()->generaURL(["usuario","modificar"],["id"=>234]));

    echo"<br>";
    echo "elo numero vale $n y la cadena $c";
