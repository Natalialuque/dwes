<?php
echo CHTML::dibujaEtiqueta("h1", [], "Login correcto");
echo CHTML::dibujaEtiqueta("p", [], "Usuario registrado correctamente.");
echo CHTML::link("Volver", Sistema::app()->generaURL(["partida"]));