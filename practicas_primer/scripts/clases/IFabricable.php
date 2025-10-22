<?php

interface IFabricable {
    public function metodoFabricacion(): string;//devuelve los pasos para fabricar elemento
    public function metodoReciclado(): string;//devuelve el metodo de reciclado que se debe aplicar segun su fabricacion
}
 
?> 