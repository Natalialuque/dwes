<?php
echo CHTML::iniciarForm(["registro", "login"]);

// NICK
echo CHTML::modeloLabel($modelo, "nick");
echo CHTML::modeloText($modelo, "nick");
echo CHTML::modeloError($modelo, "nick");

echo CHTML::dibujaEtiqueta("br");

// CONTRASEÑA
echo CHTML::modeloLabel($modelo, "contrasenia");
echo CHTML::modeloPassword($modelo, "contrasenia");
echo CHTML::modeloError($modelo, "contrasenia");

echo CHTML::dibujaEtiqueta("br");

// BOTÓN
echo CHTML::campoBotonSubmit("Entrar");

echo CHTML::finalizarForm();
?>
