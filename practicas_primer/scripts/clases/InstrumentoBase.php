<?php
// Creamos una clase abstracta, pero para probarla la dejaremos normal
 class InstrumentoBase{

private string $_descripcion;
private string $_edad;
private int $_tipoNum;

//Veces que se ha creado la clase
private static int $_numIntrumentos=0; 

//Constructor de la clase
public function __construct(string $_descripcion,int $_edad=10)
{
    $this->_descripcion=$_descripcion;
    $this->_edad=$_edad;
    self::$_numIntrumentos++;
    $this->_tipoNum=self::$_numIntrumentos;
}

//Gets
public function __getDescripcion(){
    return $this->_descripcion;
}

public function __getEdad(){
    return $this->_edad;
}

public function __getTipoNum(){
    return $this->_tipoNum;
}

public static function __getNumInstrumentos(){
return self::$_numIntrumentos;
}


//Sets
public function __setDescripcion($_descripcion) {
    $this->_descripcion=$_descripcion;
    return $this;
}

public function __setEdad($_edad){
    $this->_edad = $_edad;
    return $this;
}

//Funcion que devuielve el sonido
 function sonido(string $sonido) : string{
    return "sonido ".$sonido;
}
    
//Funcion que devuekve como afinar un instrumento
 function afinar() : string{
    return "afinar";
 }

//Metodo que aumenta la edad en 1 año
function envejecer() : void {
    $this->_edad++;
}

//Metodo que muestra todos los datos del instrumento
function get_class() : void {
    echo "Instrumento con descripción ".$this->_descripcion."<br>".
         "Tiene ".$this->_edad." años"."<br>".
         "Numero de instrumento ".$this->_tipoNum."<br>".
         "Total de instrumentos ".self::$_numIntrumentos."<br>";
}

}