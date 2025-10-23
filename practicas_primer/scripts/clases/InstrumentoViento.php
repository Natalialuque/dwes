<?php

class InstrumentoViento extends InstrumentoBase {

    //atributo protegido, solo accesible desde aqui y las hijas
   protected String $_material;

   //constructor: llama al padre y mete nuevos datos 
   public function __construct(int $edad=15,string $_material="madera"){
    parent::__construct("instrumento de viento",$edad);
    $this->_material=$_material;
   }

   //llamamos a los metodos abstractos de la clase padre y los definimos correspondientes a esta clase 
   public function sonido(string $sonido): string{
    return "aire aire aire aire";
   }

   //El método afinar no debe ser redefinible en las clases derivadas
   // de esta, por eso usamos final
   final public function afinar(): string {
        return"Ajustar boquilla y presion del aire";
   }

   //No tenemos get ni set 

   //LLamamos al metodo mágico toString padre y le añadimos el material 
   public function __toString(): string{
    return parent::__toString()."<br> Material del instrumento: {$this->_material}";
   }

   //Getter
public function _getMaterial(){return $this->_material;}

}