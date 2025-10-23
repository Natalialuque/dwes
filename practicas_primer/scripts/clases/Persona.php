<?php
class persona {

//variables 
private String $_nombre;
private String $_fecha_nacimiento;
private String $_domicilio;
private String $_localidad;
private EstadoCivil $_estadoCivil;

//sentencias get y set pa devolver sus valores 
public function getNombre(): string{
        return $this->_nombre;
}
    
public function setNombre(string $valor): void{
        $this->_nombre = $valor;
 }

public function getFechaNacimiento(): string{
        return $this->_fecha_nacimiento;
 }
    
public function setFechaNacimiento(string $valor): void{
     $this->_fecha_nacimiento = $valor;
}

public function getDomicilio(): string{
    return $this->_domicilio;
}
    
public function setDomicilio(string $valor): void{
    $this->_domicilio = $valor;
}

public function getLocalidad(): string{
     return $this->_localidad;
}
    
public function setLocalidad(string $valor): void{
    $this->_localidad = $valor;
}

public function getEstado(): EstadoCivil{
    return $this->_estadoCivil;
}

public function setEstado(EstadoCivil $valor): void{
    $this->_estadoCivil = $valor;
}

//constructor privado con al que no le llegan parametros pero si rellena las propiedades
private function __construct(){
        $this->_nombre = "Prueba";
        $this->_fecha_nacimiento = "01/01/2000";
        $this->_domicilio = "Carrera 12";
        $this->_localidad = "Antequera";
        $this->_estadoCivil = EstadoCivil::soltero;
}

//constructor estatico al que si se le pasan parametros 
public static function registrarPersona($_nombre, $_fecha_nacimiento, $_domicilio, $_localidad, $_estadoCivil): static{
        $PersonaNueva = new Persona();
        $PersonaNueva->setNombre($_nombre);
        $PersonaNueva->setFechaNacimiento($_fecha_nacimiento);
        $PersonaNueva->setDomicilio($_domicilio);
        $PersonaNueva->setLocalidad($_localidad);
        $PersonaNueva->setEstado($_estadoCivil);

        
        return $PersonaNueva;
}

//ToString
public function __toString(): string{
        return "{$this->_nombre} es una persona {$this->_estadoCivil->descripcion()} nacida el {$this->_fecha_nacimiento} y que vive en {$this->_localidad}";
}

}
?>