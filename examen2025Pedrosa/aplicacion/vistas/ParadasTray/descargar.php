<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"; ?>
<para>
   <cod_trayecto><?php echo htmlspecialchars((string)$parada->cod_trayecto, ENT_XML1, "UTF-8"); ?></cod_trayecto>
   <nombreTrayecto><?php echo htmlspecialchars((string)$parada->nombreTrayecto, ENT_XML1, "UTF-8"); ?></nombreTrayecto>
   <estacion><?php echo htmlspecialchars((string)$parada->estacion, ENT_XML1, "UTF-8"); ?></estacion>
   <poblacion><?php echo htmlspecialchars((string)$parada->poblacion, ENT_XML1, "UTF-8"); ?></poblacion>
   <es_origen><?php echo htmlspecialchars((string)$parada->es_origen, ENT_XML1, "UTF-8"); ?></es_origen>
</para>
