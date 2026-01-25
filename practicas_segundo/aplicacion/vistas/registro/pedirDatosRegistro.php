<?php
echo CHTML::iniciarForm(["registro","pedirDatosRegistro"]);

// NICK
echo CHTML::modeloLabel($modelo, "nick");
echo CHTML::modeloText($modelo,"nick");
echo CHTML::modeloError($modelo, "nick");

echo CHTML::dibujaEtiqueta("br");

// NIF
echo CHTML::modeloLabel($modelo, "nif");
echo CHTML::modeloText($modelo,"nif");
echo CHTML::modeloError($modelo, "nif");

echo CHTML::dibujaEtiqueta("br");

// FECHA NACIMIENTO
echo CHTML::modeloLabel($modelo, "fecha_nacimiento");
echo CHTML::modeloDate($modelo,"fecha_nacimiento");
echo CHTML::modeloError($modelo, "fecha_nacimiento");

echo CHTML::dibujaEtiqueta("br");

// PROVINCIA
echo CHTML::modeloLabel($modelo, "provincia");
echo CHTML::modeloText($modelo,"provincia");
echo CHTML::modeloError($modelo, "provincia");

echo CHTML::dibujaEtiqueta("br");

// ESTADO (input number)
echo CHTML::modeloLabel($modelo, "estado");
echo CHTML::modeloNumber($modelo,"estado");
echo CHTML::modeloError($modelo, "estado");

echo CHTML::dibujaEtiqueta("br");

// CONTRASEÑA
echo CHTML::modeloLabel($modelo, "contrasenia");
echo CHTML::modeloPassword($modelo,"contrasenia");
echo CHTML::modeloError($modelo, "contrasenia");

echo CHTML::dibujaEtiqueta("br");

// CONFIRMAR CONTRASEÑA
echo CHTML::modeloLabel($modelo, "confirmar_contrasenia");
echo CHTML::modeloPassword($modelo,"confirmar_contrasenia");
echo CHTML::modeloError($modelo, "confirmar_contrasenia");

echo CHTML::dibujaEtiqueta("br");

// BOTÓN
echo CHTML::campoBotonSubmit("Registrarse");

echo CHTML::finalizarForm();