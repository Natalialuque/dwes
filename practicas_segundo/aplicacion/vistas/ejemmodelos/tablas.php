<?php 
$tabla = new CGrid($cab,$fil,["class"=>"tabla1"]);
echo $tabla->dibujate();

$paginado = new CPager($cabpag,[]);
echo $paginado->dibujate();