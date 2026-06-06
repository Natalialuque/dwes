<?php
echo CHTML::link(
    CHTML::imagen("/imagenes/16x16/nuevo.png","nuevo", 
    ["style"=>"width:40px;"])."NUEVO", 
    ["Pueblos","nuevo"]);

echo "<br>";
echo "<br>";

echo CHTML::iniciarForm(["Pueblos","puebloinicial"]);


echo CHTML::campoListaRadioButton("unesco", $radio, $datos, "|");


echo CHTML::campoBotonSubmit("Ver");
echo CHTML::finalizarForm();

if(!empty($pueblos)) {
    echo CHTML::dibujaEtiqueta("div",["class"=>"pueblos"],null,false);
    foreach($pueblos as $p){
        $this->dibujaVistaParcial("tarjeta",["p"=>$p]);
    }
    echo CHTML::dibujaEtiquetaCierre("div");
}