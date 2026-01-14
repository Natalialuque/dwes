<?php 

$this->textoHead=CHTML::script("/js/main.js",["defer"=>"defer"]);
echo CHTML::iniciarForm("", "get", ["id" => "id_form"]);
echo CHTML::campoBotonSubmit("enviar");
echo CHTML::finalizarForm();
echo "<br>";
echo CHTML::dibujaEtiqueta("p",["id"=>"id_resu"],"resultado");