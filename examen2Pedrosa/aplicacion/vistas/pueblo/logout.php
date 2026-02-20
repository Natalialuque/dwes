<?php
echo CHTML::dibujaEtiqueta("h1", [], "Logout correcto");
echo CHTML::dibujaEtiqueta("p", [], "Usuario desconectado correctamente.");
echo CHTML::link("Volver", Sistema::app()->generaURL(["partida"]));