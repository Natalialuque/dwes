<?php
echo CHTML::dibujaEtiqueta(
    "div",
    ["class" => "elemento"],"", false);

    foreach ($valor as $key => $value) {
        if($key=="es_origen"){
            if($value==1){
                $value="Si";
            }
            else $value="No";
        }
        echo CHTML::dibujaEtiqueta(
            "p",
            [],
            $key.":".$value,
            true
        );
    }
echo CHTML::dibujaEtiquetaCierre("div");