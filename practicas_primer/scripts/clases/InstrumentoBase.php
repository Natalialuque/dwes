<?php
// Creamos una clase abstracta, pero para probarla la dejaremos normal
abstract class InstrumentoBase{

private string $_descripcion;
protected int $_edad = 10; //accesible desde clases hijos
protected int $_tipoNum;

//Veces que se ha creado la clase
protected static int $_numIntrumentos=0; 

//Constructor de la clase fijamos el la cadena de descripcion
public function __construct(string $_descripcion,int $_edad=10)
{
    $this->_descripcion=$_descripcion;
    $this->_edad=$_edad;
    self::$_numIntrumentos++;
    $this->_tipoNum=self::$_numIntrumentos;
}

//Gets
public function getDescripcion():String{
    return $this->_descripcion;
}

public function getEdad():int{
    return $this->_edad;
}

public function getTipoNum():int{
    return $this->_tipoNum;
}

public static function getNumInstrumentos():int{
return self::$_numIntrumentos;
}


//Sets
public function setDescripcion($_descripcion):self {
    $this->_descripcion=$_descripcion;
    return $this;
}

public function setEdad($_edad):self{
    $this->_edad = $_edad;
    return $this;
}

public function setTipoNum(int $num): void {
    $this->_tipoNum = $num;
}


/**estos metodos van abstractos */
//Funcion que devuielve el sonido
 abstract public function sonido(string $sonido) : string;

    
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
            Instancia {$this->_tipoNum} de un total de " .self::$_numIntrumentos . 
            "<br> Tiene {$this->_edad} años,
            <br> La clase es " . get_class($this).
            "<br>";
}


}

