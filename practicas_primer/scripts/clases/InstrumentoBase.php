<?php
// Creamos una clase abstracta, pero para probarla la dejaremos normal
abstract class InstrumentoBase{

private string $_descripcion;
protected int $_edad = 10; //accesible desde clases hijos
protected int $_ordencreacion;

//Veces que se ha creado la clase
protected static int $_cont=0; 

//Constructor de la clase fijamos el la cadena de descripcion
public function __construct(string $_descripcion,int $_edad=10)
{
    $this->_descripcion=$_descripcion;
    $this->_edad=$_edad;
    self::$_cont++;
    $this->_ordencreacion=self::$_cont;
}

//Gets
public function getDescripcion():String{
    return $this->_descripcion;
}

public function getEdad():int{
    return $this->_edad;
}


public function getOrdenCreacion():int{
    return $this->_ordencreacion;
}

//Sets
public function setDescripcion(String $valor):void {
    $this->_descripcion=$valor;
}

//no hay set de edad

public function setOrdenCreacion(int $num): void {
    $this->_ordencreacion = $num;
}


/**estos metodos van abstractos */
//Funcion que devuielve el sonido
 abstract public function sonido() : string;

    
//Funcion que devuelve como afinar un instrumento
 abstract public function afinar() : string;
 
 /******************************************** */

//Metodo que aumenta la edad en 1 año
function envejecer() : void {
    $this->_edad++;
}

//Metodo que muestra todos los datos del instrumento
public function __toString(): string {
    return "Instrumento con descripción: {$this->_descripcion}<br>
            Instancia {$this->_ordencreacion} de un total de " .self::$_cont . 
            "<br> Tiene {$this->_edad} años,
            <br> La clase es " . get_class($this).
            "<br>";
}

//Deshabilitar la sobre carga (ACTIVA POR DEFECTO)
    public function __set(string $name, mixed $value):void{}

    public function __get($name):mixed{return 0;}

    public function __isset($name):bool{return true;}

    public function __unset($name):void{}

}

